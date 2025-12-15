<x-app-layout>
    <x-slot name="header">{{ __('Dashboard Overview') }}</x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-slate-500 text-sm font-medium">{{ __('Total Customers') }}</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ $totalNasabah }}</h3>
                <div class="mt-4 flex items-center text-sm text-green-600 font-medium"><i class="fa-solid fa-users mr-1"></i> {{ __('People') }}</div>
            </div>
            <div class="absolute right-0 top-0 h-24 w-24 bg-green-100 rounded-bl-full -mr-4 -mt-4 opacity-50"></div>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-slate-500 text-sm font-medium">{{ __('Waste Collected') }}</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ number_format($totalSampah, 1) }} <span class="text-lg text-slate-400">kg</span></h3>
                <div class="mt-4 flex items-center text-sm text-blue-600 font-medium"><i class="fa-solid fa-recycle mr-1"></i> {{ __('All Time') }}</div>
            </div>
            <div class="absolute right-0 top-0 h-24 w-24 bg-blue-100 rounded-bl-full -mr-4 -mt-4 opacity-50"></div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-slate-500 text-sm font-medium">{{ __('Total Customer Balance') }}</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-1">Rp {{ number_format($totalUang, 0, ',', '.') }}</h3>
                <div class="mt-4 flex items-center text-sm text-yellow-600 font-medium"><i class="fa-solid fa-wallet mr-1"></i> {{ __('Rupiah') }}</div>
            </div>
            <div class="absolute right-0 top-0 h-24 w-24 bg-yellow-100 rounded-bl-full -mr-4 -mt-4 opacity-50"></div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-slate-700">{{ __('Latest Transactions') }}</h3>
            <a href="{{ route('transaction.index') }}" class="text-sm text-primary font-bold hover:underline">{{ __('See All') }}</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="bg-gray-50 text-slate-500 uppercase font-bold text-xs">
                    <tr>
                        <th class="px-6 py-4">{{ __('Date') }}</th>
                        <th class="px-6 py-4">{{ __('Customer') }}</th>
                        <th class="px-6 py-4">{{ __('Waste Type') }}</th>
                        <th class="px-6 py-4">{{ __('Weight') }}</th>
                        <th class="px-6 py-4 text-right">{{ __('Total') }} (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transaksiTerbaru as $trx)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">{{ $trx->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4 font-bold text-slate-700">{{ $trx->user->name }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $trx->trashType->category == 'organik' ? 'bg-green-100 text-green-700' : ($trx->trashType->category == 'b3' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700') }}">
                                {{ $trx->trashType->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $trx->weight_kg }} kg</td>
                        <td class="px-6 py-4 text-right font-bold text-primary">+ Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400">{{ __('No transactions yet') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>