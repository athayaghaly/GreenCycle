<?php

namespace App\Http\Controllers;

use App\Models\TrashType;
use Illuminate\Http\Request;

class TrashTypeController extends Controller
{
    // 1. Tampilkan Daftar (READ)
    public function index()
    {
        $trashTypes = TrashType::all();
        return view('admin.trash_types.index', compact('trashTypes'));
    }

    // 2. Tampilkan Form Tambah (CREATE - View)
    public function create()
    {
        return view('admin.trash_types.create');
    }

    // 3. Proses Simpan Data (CREATE - Logic)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:organik,anorganik,b3',
            'price_per_kg' => 'required|numeric|min:0',
        ]);

        TrashType::create($request->all());

        return redirect()->route('trash-types.index')->with('success', 'Jenis sampah berhasil ditambahkan!');
    }

    // 4. Tampilkan Form Edit (UPDATE - View)
    public function edit(TrashType $trashType)
    {
        return view('admin.trash_types.edit', compact('trashType'));
    }

    // 5. Proses Update Data (UPDATE - Logic)
    public function update(Request $request, TrashType $trashType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:organik,anorganik,b3',
            'price_per_kg' => 'required|numeric|min:0',
        ]);

        $trashType->update($request->all());

        return redirect()->route('trash-types.index')->with('success', 'Data sampah berhasil diperbarui!');
    }

    // 6. Hapus Data (DELETE)
    public function destroy(TrashType $trashType)
    {
        $trashType->delete();
        return redirect()->route('trash-types.index')->with('success', 'Data sampah berhasil dihapus!');
    }
}