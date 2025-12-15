<x-app-layout>
    <x-slot name="header">Tambah Jenis Sampah</x-slot>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <form action="{{ route('trash-types.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Sampah</label>
                <input type="text" name="name" class="w-full border-gray-300 rounded-xl focus:ring-primary focus:border-primary" placeholder="Contoh: Kardus Bekas" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold text-slate-700 mb-2">Kategori</label>
                <select name="category" class="w-full border-gray-300 rounded-xl focus:ring-primary focus:border-primary">
                    <option value="anorganik">Anorganik</option>
                    <option value="organik">Organik</option>
                    <option value="b3">B3 (Berbahaya)</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Harga per Kg (Rp)</label>
                <input type="number" name="price_per_kg" class="w-full border-gray-300 rounded-xl focus:ring-primary focus:border-primary" placeholder="0" required>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('trash-types.index') }}" class="px-4 py-2 border rounded-xl text-slate-600">Batal</a>
                <button type="submit" class="px-6 py-2 bg-primary text-white font-bold rounded-xl hover:bg-primaryDark">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>