<x-app-layout>
    <x-slot name="header">Dashboard Nasabah</x-slot>

    <!-- KARTU SALDO -->
    <div class="bg-gradient-to-r from-primary to-emerald-600 rounded-3xl p-8 text-white shadow-xl shadow-green-200 mb-8 relative overflow-hidden">
        <div class="relative z-10">
            <p class="text-emerald-100 font-medium mb-1">Saldo Tabungan Sampah Anda</p>
            <h2 class="text-4xl font-bold">Rp {{ number_format($saldo, 0, ',', '.') }}</h2>
            <p class="mt-4 text-sm text-emerald-50 bg-white/20 inline-block px-3 py-1 rounded-lg">
                <i class="fa-solid fa-wallet mr-2"></i> Kumpulkan poin untuk ditukar hadiah!
            </p>
        </div>
        <div class="absolute right-0 bottom-0 text-9xl text-white opacity-10 -mr-10 -mb-10">
            <i class="fa-solid fa-leaf"></i>
        </div>
    </div>

    <!-- TABEL RIWAYAT PRIBADI -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-slate-700 mb-4">Riwayat Setoran Terakhir Anda</h3>
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 uppercase text-xs font-bold text-slate-500">
                <tr>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Jenis Sampah</th>
                    <th class="px-4 py-3">Berat</th>
                    <th class="px-4 py-3 text-right">Pendapatan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($riwayat as $trx)
                <tr>
                    <td class="px-4 py-3">{{ $trx->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-3">{{ $trx->trashType->name }}</td>
                    <td class="px-4 py-3">{{ $trx->weight_kg }} kg</td>
                    <td class="px-4 py-3 text-right font-bold text-green-600">+ Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-6 text-slate-400">Belum ada riwayat setoran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>