<x-app-layout>
    <x-slot name="header">{{ __('Submit Waste Request') }}</x-slot>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        
        <!-- Info Box -->
        <div class="mb-6 bg-blue-50 border border-blue-100 p-4 rounded-xl flex gap-3 items-start">
            <i class="fa-solid fa-circle-info text-blue-500 mt-1"></i>
            <div class="text-sm text-blue-700">
                <p class="font-bold">{{ __('Customer Info') }}:</p>
                <p>{{ __('Customer Info Desc') }}</p>
            </div>
        </div>

        <form action="{{ route('transaction.store') }}" method="POST">
            @csrf

            <!-- Pilihan Jenis Sampah -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">{{ __('Select Waste Label') }}</label>
                <select name="trash_type_id" id="trashTypeSelect" onchange="calculateTotal()" class="w-full bg-gray-50 border border-gray-300 rounded-xl p-3 focus:ring-primary focus:border-primary" required>
                    <option value="" data-price="0">{{ __('Select Waste Placeholder') }}</option>
                    @foreach($trashTypes as $type)
                        <option value="{{ $type->id }}" data-price="{{ $type->price_per_kg }}">
                            {{ $type->name }} (Rate: Rp {{ number_format($type->price_per_kg) }}/kg)
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Input Berat -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">{{ __('Est. Weight Label') }}</label>
                <div class="relative">
                    <input type="number" name="weight_kg" id="weightInput" step="0.1" min="0.1" value="1" oninput="calculateTotal()" class="w-full bg-gray-50 border border-gray-300 rounded-xl p-3 pl-4 focus:ring-primary focus:border-primary" required>
                    <span class="absolute right-4 top-3 text-slate-400 font-bold">Kg</span>
                </div>
                <p class="text-xs text-slate-400 mt-2">{{ __('Weight Hint') }}</p>
            </div>

            <!-- Kalkulator Hitam -->
            <div class="bg-gray-800 text-white p-6 rounded-2xl mb-8 flex justify-between items-center shadow-lg shadow-gray-300">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">{{ __('Est. Income') }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ __('Income Desc') }}</p>
                </div>
                <div class="text-right">
                    <h3 class="text-3xl font-bold text-emerald-400" id="totalPriceDisplay">Rp 0</h3>
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-primary text-white font-bold rounded-xl shadow-lg hover:bg-primaryDark transition-all transform hover:-translate-y-1">
                <i class="fa-solid fa-paper-plane mr-2"></i> {{ __('Submit Button') }}
            </button>
        </form>
    </div>

    <!-- Script Kalkulator Sederhana -->
    <script>
        function calculateTotal() {
            // 1. Ambil elemen input
            const typeSelect = document.getElementById('trashTypeSelect');
            const weightInput = document.getElementById('weightInput');
            const display = document.getElementById('totalPriceDisplay');
            
            // 2. Ambil harga dari atribut data-price
            const price = typeSelect.options[typeSelect.selectedIndex].getAttribute('data-price') || 0;
            const weight = weightInput.value || 0;
            
            // 3. Hitung total
            const total = price * weight;
            
            // 4. Tampilkan format Rupiah
            display.innerText = "Rp " + total.toLocaleString('id-ID');
        }
    </script>
</x-app-layout>