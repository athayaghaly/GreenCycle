<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Jika user adalah Nasabah, tampilkan view khusus Nasabah (Nanti kita buat)
        if (Auth::user()->role === 'nasabah') {
            return view('nasabah.dashboard', [
                'saldo' => Auth::user()->balance,
                'riwayat' => Transaction::where('user_id', Auth::id())->latest()->take(5)->get()
            ]);
        }

        // Jika Admin, hitung statistik
        $totalNasabah = User::where('role', 'nasabah')->count();
        $totalSampah = Transaction::sum('weight_kg');
        $totalUang = User::where('role', 'nasabah')->sum('balance'); // Total uang yang dimiliki nasabah

        // Ambil 5 transaksi terakhir untuk tabel
        $transaksiTerbaru = Transaction::with(['user', 'trashType'])->latest()->take(5)->get();

        return view('dashboard', compact('totalNasabah', 'totalSampah', 'totalUang', 'transaksiTerbaru'));
    }
}