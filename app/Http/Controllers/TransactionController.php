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
    // 1. Tampilkan Form Setor Sampah
    public function create()
    {
        $nasabahs = User::where('role', 'nasabah')->get();
        $trashTypes = TrashType::all();
        
        return view('admin.transaction.create', compact('nasabahs', 'trashTypes'));
    }

    // 2. Proses Simpan Transaksi (Logika Utama)
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'trash_type_id' => 'required|exists:trash_types,id',
            'weight_kg' => 'required|numeric|min:0.1',
        ]);

        // Ambil Data Sampah untuk cek harga
        $sampah = TrashType::findOrFail($request->trash_type_id);
        
        // Hitung Total Uang
        $totalRp = $sampah->price_per_kg * $request->weight_kg;

        // Gunakan DB Transaction agar data aman
        DB::transaction(function () use ($request, $sampah, $totalRp) {
            
            // A. Simpan data riwayat transaksi
            Transaction::create([
                'user_id' => $request->user_id,
                'admin_id' => Auth::id(), // Siapa admin yang input
                'trash_type_id' => $sampah->id,
                'weight_kg' => $request->weight_kg,
                'total_price' => $totalRp,
            ]);

            // B. Update Saldo Nasabah
            $nasabah = User::findOrFail($request->user_id);
            $nasabah->balance += $totalRp; // Tambah saldo
            $nasabah->save();
        });

        // Redirect dengan Notifikasi Sukses
        return redirect()->route('dashboard')->with('success', 'Transaksi Berhasil! Saldo Nasabah Bertambah.');
    }
}
