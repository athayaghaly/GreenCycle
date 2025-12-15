<x-app-layout>
    <x-slot name="header">
        Riwayat Setoran Saya
    </x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        
        <!-- Header Kecil -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="font-bold text-slate-700">Daftar Pengajuan Setoran</h3>
                <p class="text-xs text-slate-400">Pantau status persetujuan setoran sampahmu di sini</p>
            </div>
            <a href="{{ route('transaction.create') }}" class="px-4 py-2 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primaryDark transition-all shadow-lg shadow-primary/20">
                + Ajukan Baru
            </a>
        </div>

        <!-- Tabel Riwayat -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="bg-gray-50 uppercase font-bold text-xs">
                    <tr>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Jenis Sampah</th>
                        <th class="px-6 py-4">Berat (kg)</th>
                        <th class="px-6 py-4">Estimasi Pendapatan</th>
                        <th class="px-6 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <!-- Tanggal -->
                        <td class="px-6 py-4">
                            {{ $trx->created_at->format('d M Y') }}
                            <span class="block text-xs text-slate-400">{{ $trx->created_at->format('H:i') }}</span>
                        </td>
                        
                        <!-- Jenis Sampah -->
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-700">{{ $trx->trashType->name }}</span>
                            <span class="block text-xs text-slate-400 capitalize">{{ $trx->trashType->category }}</span>
                        </td>

                        <!-- Berat -->
                        <td class="px-6 py-4 font-medium">
                            {{ $trx->weight_kg }} kg
                        </td>

                        <!-- Total -->
                        <td class="px-6 py-4 font-bold text-primary">
                            Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                        </td>

                        <!-- Status Badge -->
                        <td class="px-6 py-4 text-center">
                            @if($trx->status == 'pending')
                                <span class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold border border-yellow-200">
                                    <i class="fa-solid fa-hourglass-half"></i> Menunggu
                                </span>
                            @elseif($trx->status == 'approved')
                                <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold border border-green-200">
                                    <i class="fa-solid fa-check-circle"></i> Berhasil
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold border border-red-200">
                                    <i class="fa-solid fa-circle-xmark"></i> Ditolak
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <i class="fa-regular fa-folder-open text-2xl opacity-50"></i>
                                <p>Belum ada riwayat setoran.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination (Halaman 1, 2, dst) -->
        <div class="mt-4">
            {{ $transactions->links() }}
        </div>
    </div>
</x-app-layout>