<x-app-layout>
    <x-slot name="header">Manajemen Jenis Sampah</x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-slate-700">Daftar Harga Sampah</h3>
            <a href="{{ route('trash-types.create') }}" class="px-4 py-2 bg-primary text-white font-bold rounded-lg text-sm hover:bg-primaryDark">
                + Tambah Jenis
            </a>
        </div>

        <table class="w-full text-sm text-left text-slate-600">
            <thead class="bg-gray-50 uppercase font-bold text-xs">
                <tr>
                    <th class="px-4 py-3">Nama Sampah</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Harga / Kg</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($trashTypes as $type)
                <tr>
                    <td class="px-4 py-3 font-bold">{{ $type->name }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded text-xs border {{ $type->category == 'anorganik' ? 'border-blue-200 bg-blue-50 text-blue-700' : 'border-green-200 bg-green-50 text-green-700' }}">
                            {{ ucfirst($type->category) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">Rp {{ number_format($type->price_per_kg, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-center flex justify-center gap-2">
                        <a href="{{ route('trash-types.edit', $type->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('trash-types.destroy', $type->id) }}" method="POST" onsubmit="return confirm('Hapus jenis ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>