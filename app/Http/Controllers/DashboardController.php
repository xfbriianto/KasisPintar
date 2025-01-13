<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\User; // Jika Anda ingin menghitung total pengguna
use App\Models\Pembeli; // Model untuk pembeli
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil total pengguna
        $totalUsers = User::count();

        // Ambil total pembeli
        $totalPembeli = Pembeli::count(); // Hitung total pembeli dari model Pembeli

        // Ambil transaksi terbaru
        $recentTransactions = Transaksi::with('pembeli') // Mengambil transaksi dengan relasi pembeli
            ->orderBy('tanggal_transaksi', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact('totalUsers', 'totalPembeli', 'recentTransactions'));
    }

    public function storeTransaction(Request $request)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'kode_pembeli' => 'required',
            'no_pembeli' => 'nullable|string|max:255', // Jadikan no_pembeli opsional
            'telepon' => 'required',
            'alamat' => 'nullable|string|max:255', // Alamat opsional
            'kode_transaksi' => 'required',
            'jumlah_barang' => 'required|integer',
            'total_harga' => 'required|numeric',
        ]);

        // Cek apakah pembeli sudah ada, jika tidak, buat pembeli baru
        $pembeli = Pembeli::firstOrCreate(
            ['kode_pembeli' => $validatedData['kode_pembeli']], // Cek berdasarkan kode pembeli
            [
                'no_pembeli' => $validatedData['no_pembeli'] ?? 'Tidak Diketahui',
                'alamat' => $validatedData['alamat'] ?? 'Tidak Diketahui',
                'telepon' => $validatedData['telepon'],
            ]
        );

        // Tambahkan transaksi
        Transaksi::create([
            'kode_transaksi' => $validatedData['kode_transaksi'],
            'jumlah_barang' => $validatedData['jumlah_barang'],
            'total_harga' => $validatedData['total_harga'],
            'tanggal_transaksi' => now(),
            'pembeli_id' => $pembeli->id, // Hubungkan transaksi dengan pembeli
        ]);

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil ditambahkan.');
    }
}
