<x-app-layout>
    <x-slot name="header">
        {{ __('Check Request') }}
    </x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        
        <!-- Judul & Statistik -->
        <div class="mb-6 flex justify-between items-center border-b border-gray-100 pb-4">
            <div>
                <h3 class="font-bold text-lg text-slate-800">{{ __('Request List') }}</h3>
                <p class="text-sm text-slate-500">{{ __('Request Description') }}</p>
            </div>
            <div class="bg-blue-50 text-blue-600 px-4 py-2 rounded-xl text-sm font-bold">
                {{ __('Total Request') }}: {{ $transactions->total() }}
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="bg-gray-50 text-slate-500 uppercase font-bold text-xs">
                    <tr>
                        <th class="px-6 py-4 rounded-tl-xl">{{ __('Time & Customer') }}</th>
                        <th class="px-6 py-4">{{ __('Detail Waste') }}</th>
                        <th class="px-6 py-4">{{ __('Weight') }}</th>
                        <th class="px-6 py-4">{{ __('Est. Rupiah') }}</th>
                        <th class="px-6 py-4 text-center">{{ __('Status') }}</th>
                        <th class="px-6 py-4 rounded-tr-xl text-center">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <!-- Waktu & Nama -->
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $trx->user->name }}</div>
                            <div class="text-xs text-slate-400 mt-1">
                                <i class="fa-regular fa-clock mr-1"></i> {{ $trx->created_at->format('d M Y, H:i') }}
                            </div>
                        </td>

                        <!-- Detail Sampah -->
                        <td class="px-6 py-4">
                            <span class="font-semibold text-slate-700">{{ $trx->trashType->name }}</span>
                            <span class="block text-xs text-slate-400 capitalize bg-gray-100 inline-block px-2 py-0.5 rounded mt-1">
                                {{ $trx->trashType->category }}
                            </span>
                        </td>

                        <!-- Berat -->
                        <td class="px-6 py-4 font-medium text-slate-700">{{ $trx->weight_kg }} kg</td>

                        <!-- Total Rupiah -->
                        <td class="px-6 py-4 font-bold text-primary text-base">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>

                        <!-- Status Badge -->
                        <td class="px-6 py-4 text-center">
                            @if($trx->status == 'pending')
                                <span class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold border border-yellow-200">
                                    <i class="fa-solid fa-hourglass-half"></i> {{ __('Pending') }}
                                </span>
                            @elseif($trx->status == 'approved')
                                <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold border border-green-200">
                                    <i class="fa-solid fa-check-circle"></i> {{ __('Approved') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold border border-red-200">
                                    <i class="fa-solid fa-circle-xmark"></i> {{ __('Rejected') }}
                                </span>
                            @endif
                        </td>

                        <!-- Tombol Aksi -->
                        <td class="px-6 py-4 text-center">
                            @if($trx->status == 'pending')
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Tombol Approve Hijau -->
                                    <form action="{{ route('transaction.approve', $trx->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="group relative w-9 h-9 rounded-lg bg-emerald-500 text-white hover:bg-emerald-600 shadow-md shadow-emerald-200 transition-all flex items-center justify-center" title="{{ __('Approve') }}">
                                            <i class="fa-solid fa-check text-lg"></i>
                                        </button>
                                    </form>
                                    <!-- Tombol Reject Merah -->
                                    <form action="{{ route('transaction.reject', $trx->id) }}" method="POST" onsubmit="return confirm('{{ __('Confirm Reject') }}');">
                                        @csrf
                                        <button type="submit" class="group relative w-9 h-9 rounded-lg bg-red-50 text-red-500 border border-red-200 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center" title="{{ __('Reject') }}">
                                            <i class="fa-solid fa-xmark text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="text-xs text-slate-400 italic">
                                    {{ __('Finished by') }}:<br>
                                    {{ $trx->admin->name ?? 'Admin' }}
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center text-gray-300 text-2xl mb-2">
                                    <i class="fa-regular fa-folder-open"></i>
                                </div>
                                <p class="font-medium">{{ __('No new requests') }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $transactions->links() }}</div>
    </div>
</x-app-layout>