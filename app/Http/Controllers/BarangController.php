<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index()
    {
        // Mengambil data barang dengan relasi kategori dan melakukan paginasi
        $barangs = Barang::with('kategori')->paginate(10);
        
        // Mengembalikan tampilan dengan data barang
        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        // Ambil data kategori
        $kategoris = Kategori::all();

        // Generate kode barang otomatis
        $lastBarang = Barang::orderBy('id', 'desc')->first();
        $newKodeBarang = 'BR001'; // Default kode barang pertama

        if ($lastBarang) {
            // Ekstrak angka dari kode barang terakhir dan tambahkan 1
            $lastNumber = (int) substr($lastBarang->kode_barang, 2);
            $newKodeBarang = 'BR' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        }

        // Kirim data ke view
        return view('barang.create', compact('kategoris', 'newKodeBarang'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang',
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_barang' => 'required|max:255',
            'harga_jual' => 'required|numeric|min:0',
            'harga_dasar' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'diskon' => 'nullable|numeric|min:0|max:100',
            'tipe_barang' => 'nullable|max:255'
        ]);

        try {
            DB::beginTransaction();
            
            Barang::create($validatedData);
            
            DB::commit();
            
            return redirect()->route('barang.index')
                ->with('success', 'Barang berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->with('error', 'Gagal menambahkan barang: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Barang $barang)
    {
        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $kategoris = Kategori::all();
        return view('barang.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validatedData = $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang,' . $barang->id,
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_barang' => 'required|max:255',
            'harga_jual' => 'required|numeric|min:0',
            'harga_dasar' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'diskon' => 'nullable|numeric|min:0|max:100',
            'tipe_barang' => 'nullable|max:255'
        ]);

        try {
            DB::beginTransaction();
            
            $barang->update($validatedData);
            
            DB::commit();
            
            return redirect()->route('barang.index')
                ->with('success', 'Barang berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->with('error', 'Gagal mengupdate barang: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Barang $barang)
    {
        try {
            DB::beginTransaction();
            
            $barang->delete();
            
            DB::commit();
            
            return redirect()->route('barang.index')
                ->with('success', 'Barang berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->with('error', 'Gagal menghapus barang: ' . $e->getMessage());
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $barangs = Barang::with('kategori')
            ->where('nama_barang', 'LIKE', "%{$query}%")
            ->orWhere('kode_barang', 'LIKE', "%{$query}%")
            ->paginate(10);
        
        return view('barang.index', compact('barangs', 'query'));
    }
}
