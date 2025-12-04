<x-app-layout>
    <!-- Header Judul Halaman -->
    <x-slot name="header">
        Input Setor Sampah
    </x-slot>

    <!-- Content Utama -->
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        
        <!-- Header Form -->
        <div class="mb-6 pb-6 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Formulir Transaksi Baru</h3>
                <p class="text-sm text-slate-500">Masukkan data sampah yang disetor nasabah</p>
            </div>
            <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary">
                <i class="fa-solid fa-scale-balanced"></i>
            </div>
        </div>

        <!-- FORM MULAI DISINI -->
        <!-- Perhatikan action="{{ route('transaction.store') }}" -->
        <form action="{{ route('transaction.store') }}" method="POST">
            @csrf <!-- Wajib ada di Laravel untuk keamanan -->

            <!-- 1. Pilih Nasabah -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Nasabah</label>
                <select name="user_id" class="w-full bg-gray-50 border border-gray-300 text-slate-800 text-sm rounded-xl focus:ring-primary focus:border-primary block p-3" required>
                    <option value="">-- Cari Nama Nasabah --</option>
                    <!-- Loop Data Nasabah dari Controller -->
                    @foreach($nasabahs as $nasabah)
                        <option value="{{ $nasabah->id }}">{{ $nasabah->name }} (ID: {{ $nasabah->id }})</option>
                    @endforeach
                </select>
            </div>

            <!-- 2. Pilih Jenis Sampah & Berat -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Jenis Sampah -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Sampah</label>
                    <select name="trash_type_id" id="trashTypeSelect" onchange="calculateTotal()" class="w-full bg-gray-50 border border-gray-300 text-slate-800 text-sm rounded-xl focus:ring-primary focus:border-primary block p-3" required>
                        <option value="" data-price="0">-- Pilih Jenis --</option>
                        <!-- Loop Data Sampah dari Controller -->
                        @foreach($trashTypes as $type)
                            <!-- Kita simpan harga di attribute 'data-price' agar bisa dibaca JS -->
                            <option value="{{ $type->id }}" data-price="{{ $type->price_per_kg }}">
                                {{ $type->name }} (Rp {{ number_format($type->price_per_kg, 0, ',', '.') }}/kg)
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Berat (Kg) -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Berat (Kg)</label>
                    <div class="relative">
                        <input type="number" name="weight_kg" id="weightInput" step="0.1" min="0.1" value="0" oninput="calculateTotal()" class="w-full bg-gray-50 border border-gray-300 text-slate-800 text-sm rounded-xl focus:ring-primary focus:border-primary block p-3 pl-4" required>
                        <span class="absolute right-4 top-3 text-slate-400 text-sm font-bold">Kg</span>
                    </div>
                </div>
            </div>

            <!-- 3. Estimasi Total (Kalkulator Otomatis) -->
            <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 flex justify-between items-center mb-8">
                <div>
                    <p class="text-xs text-blue-600 font-bold uppercase tracking-wider">Total Rupiah</p>
                    <p class="text-xs text-blue-400 mt-1">Akan masuk ke saldo nasabah</p>
                </div>
                <div class="text-right">
                    <h4 class="text-3xl font-bold text-blue-700" id="totalPriceDisplay">Rp 0</h4>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="flex gap-4">
                <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-xl border border-gray-300 text-slate-600 font-bold hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="flex-1 px-6 py-3 rounded-xl bg-primary text-white font-bold shadow-lg shadow-primary/30 hover:bg-primaryDark transition-all">
                    <i class="fa-solid fa-save mr-2"></i> Simpan Transaksi
                </button>
            </div>
        </form>
    </div>

    <!-- Script Sederhana untuk Hitung Otomatis -->
    <script>
        function calculateTotal() {
            // 1. Ambil elemen
            const typeSelect = document.getElementById('trashTypeSelect');
            const weightInput = document.getElementById('weightInput');
            const display = document.getElementById('totalPriceDisplay');

            // 2. Ambil harga dari opsi yang dipilih (data-price)
            const selectedOption = typeSelect.options[typeSelect.selectedIndex];
            const price = selectedOption.getAttribute('data-price') || 0;
            
            // 3. Ambil berat
            const weight = weightInput.value || 0;

            // 4. Hitung Total
            const total = price * weight;

            // 5. Tampilkan (Format Rupiah)
            display.innerText = "Rp " + total.toLocaleString('id-ID');
        }
    </script>
</x-app-layout>