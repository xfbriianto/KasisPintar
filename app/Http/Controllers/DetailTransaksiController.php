<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use App\Models\Barang;
use Illuminate\Http\Request;

class DetailTransaksiController extends Controller
{
    /**
     * Menampilkan semua detail transaksi
     */
    public function index()
    {
        $detailTransaksis = DetailTransaksi::with(['transaksi', 'barang'])->get();
        $transaksis = Transaksi::all(); // Ambil semua data transaksi
        return view('detail_transaksis.index', compact('detailTransaksis', 'transaksis'));
    }

    /**
     * Form untuk menambah detail transaksi
     */
    public function create()
    {
        $transaksis = Transaksi::all();
        $barangs = Barang::all();
        return view('detail_transaksis.create', compact('transaksis', 'barangs'));
    }

    /**
     * Menyimpan detail transaksi baru
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'transaksi_id' => 'required|exists:transaksis,id',
            'barang_id' => 'required|exists:barangs,id',
            'jumlah_barang' => 'required|integer|min:1',
            'harga_jual' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'tanggal_pembelian' => 'required|date'
        ]);

        DetailTransaksi::create($validatedData);

        return redirect()->route('detail_transaksis.index')
            ->with('success', 'Detail Transaksi berhasil ditambahkan');
    }

    /**
     * Form untuk mengedit detail transaksi
     */
    public function edit(DetailTransaksi $detailTransaksi)
    {
        $transaksis = Transaksi::all();
        $barangs = Barang::all();
        return view('detail_transaksis.edit', compact('detailTransaksi', 'transaksis', 'barangs'));
    }

    /**
     * Mengupdate detail transaksi
     */
    public function update(Request $request, DetailTransaksi $detailTransaksi)
    {
        $validatedData = $request->validate([
            'transaksi_id' => 'required|exists:transaksis,id',
            'barang_id' => 'required|exists:barangs,id',
            'jumlah_barang' => 'required|integer|min:1',
            'harga_jual' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'tanggal_pembelian' => 'required|date'
        ]);

        $detailTransaksi->update($validatedData);

        return redirect()->route('detail_transaksis.index')
            ->with('success', 'Detail Transaksi berhasil diupdate');
    }

    /**
     * Menghapus detail transaksi
     */
    public function destroy(DetailTransaksi $detailTransaksi)
    {
        $detailTransaksi->delete();

        return redirect()->route('detail_transaksis.index')
            ->with('success', 'Detail Transaksi berhasil dihapus');
    }

    /**
     * Menampilkan detail transaksi
     */
    public function show($id)
    {
        // Ambil data detail transaksi beserta relasi
        $detailTransaksi = DetailTransaksi::with(['transaksi.pembeli', 'barang'])->findOrFail($id);

        // Kirim data ke view
        return view('detail_transaksis.show', compact('detailTransaksi'));
    }
}