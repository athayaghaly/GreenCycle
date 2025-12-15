<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TrashType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // 1. Tampilkan Halaman (Beda tampilan untuk Admin & Nasabah)
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin melihat semua transaksi, urutkan yang pending di atas
            $transactions = Transaction::with(['user', 'trashType'])
                            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
                            ->latest()
                            ->paginate(10);
            return view('admin.transaction.index', compact('transactions'));
        } else {
            // Nasabah hanya melihat transaksinya sendiri
            $transactions = Transaction::with('trashType')
                            ->where('user_id', $user->id)
                            ->latest()
                            ->paginate(10);
            return view('nasabah.transaction.index', compact('transactions'));
        }
    }

    // 2. Form Input (Sekarang untuk NASABAH)
    public function create()
    {
        $trashTypes = TrashType::all();
        // Tidak butuh data user lain, karena input untuk diri sendiri
        return view('nasabah.transaction.create', compact('trashTypes'));
    }

    // 3. Proses Simpan (Oleh NASABAH)
    public function store(Request $request)
    {
        $request->validate([
            'trash_type_id' => 'required|exists:trash_types,id',
            'weight_kg' => 'required|numeric|min:0.1',
        ]);

        $sampah = TrashType::findOrFail($request->trash_type_id);
        $totalRp = $sampah->price_per_kg * $request->weight_kg;

        Transaction::create([
            'user_id' => Auth::id(), // ID diri sendiri
            'admin_id' => null,      // Belum ada admin
            'trash_type_id' => $sampah->id,
            'weight_kg' => $request->weight_kg,
            'total_price' => $totalRp,
            'status' => 'pending'    // Default pending
        ]);

        return redirect()->route('transaction.index')->with('success', 'Permintaan setoran berhasil dikirim! Menunggu konfirmasi Admin.');
    }

    // 4. Proses Persetujuan (Oleh ADMIN)
    public function approve($id)
    {
        // Hanya Admin yang boleh
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $trx = Transaction::findOrFail($id);

        if ($trx->status !== 'pending') {
            return back()->with('error', 'Transaksi ini sudah diproses sebelumnya.');
        }

        DB::transaction(function () use ($trx) {
            // A. Update Status Transaksi
            $trx->update([
                'status' => 'approved',
                'admin_id' => Auth::id() // Catat siapa admin yang menyetujui
            ]);

            // B. Tambah Saldo Nasabah
            $nasabah = User::findOrFail($trx->user_id);
            $nasabah->balance += $trx->total_price;
            $nasabah->save();
        });

        return back()->with('success', 'Setoran disetujui! Saldo nasabah telah bertambah.');
    }
    
    // 5. Proses Tolak (Opsional)
    public function reject($id)
    {
         if (Auth::user()->role !== 'admin') abort(403);
         
         $trx = Transaction::findOrFail($id);
         $trx->update(['status' => 'rejected', 'admin_id' => Auth::id()]);
         
         return back()->with('success', 'Setoran ditolak.');
    }
}