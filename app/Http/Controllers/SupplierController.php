<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // Menampilkan daftar semua supplier
    public function index()
    {
        $suppliers = Supplier::all();
        return view('supplier.index', compact('suppliers'));
    }

    // Menampilkan form untuk membuat supplier baru
    public function create()
    {
        return view('supplier.create');
    }

    // Menyimpan supplier baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'kode_supplier' => 'required|unique:suppliers|max:255',
            'nama_supplier' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
        ]);

        Supplier::create($request->all());

        return redirect()->route('supplier.index')->with('success', 'Supplier created successfully.');
    }

    // Menampilkan detail supplier
    public function show(Supplier $supplier)
    {
        return view('supplier.show', compact('supplier'));
    }

    // Menampilkan form untuk mengedit supplier
    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    // Memperbarui data supplier
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'kode_supplier' => 'required|max:255|unique:suppliers,kode_supplier,' . $supplier->id,
            'nama_supplier' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
        ]);

        $supplier->update($request->all());

        return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully.');
    }

    // Menghapus supplier
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('supplier.index')->with('success', 'Supplier deleted successfully.');
    }
}