<?php

namespace App\Http\Controllers;

// app/Http/Controllers/KategoriController.php
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return view('kategoris.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategoris.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kategori' => 'required|max:255',
            'deskripsi' => 'nullable'
        ]);

        Kategori::create($validatedData);

        return redirect()->route('kategoris.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Kategori $kategori)
    {
        return view('kategoris.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $validatedData = $request->validate([
            'nama_kategori' => 'required|max:255',
            'deskripsi' => 'nullable'
        ]);

        $kategori->update($validatedData);

        return redirect()->route('kategoris.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return redirect()->route('kategoris.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}