<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TrashTypeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;



// 1. Halaman Depan (Bisa diakses siapa saja)
Route::get('/', function () {
    return view('welcome');
});

// 2. Route Ganti Bahasa (ID / EN)
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('switch.lang');

// 3. Area Wajib Login (Nasabah & Admin masuk sini)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // --- DASHBOARD ---
    // Controller akan mendeteksi: Jika Admin -> Tampil Statistik, Jika Nasabah -> Tampil Saldo
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- FITUR TRANSAKSI (NASABAH & ADMIN) ---
    
    // Index: Admin lihat semua, Nasabah lihat punya sendiri (Logika ada di Controller)
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transaction.index');

    // Input: Sekarang bisa diakses Nasabah (Dikeluarkan dari grup middleware 'admin')
    Route::get('/setor-sampah', [TransactionController::class, 'create'])->name('transaction.create');
    Route::post('/setor-sampah', [TransactionController::class, 'store'])->name('transaction.store');


    // --- AREA KHUSUS ADMIN (Dilarang Masuk Selain Admin) ---
    Route::middleware(['admin'])->group(function () {
        
        // Admin Action: Setujui (Approve) atau Tolak (Reject) Transaksi
        Route::post('/transaction/{id}/approve', [TransactionController::class, 'approve'])->name('transaction.approve');
        Route::post('/transaction/{id}/reject', [TransactionController::class, 'reject'])->name('transaction.reject');

        // Admin Action: CRUD Jenis Sampah (Harga & Kategori)
        Route::resource('trash-types', TrashTypeController::class);
    });

});

require __DIR__.'/auth.php';