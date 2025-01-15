<?php
namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pembeli;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransaksiController extends Controller
{
    // Method untuk generate kode transaksi otomatis
   // Di TransaksiController, tambahkan method baru
private function generateKodeTransaksi()
{
    // Ambil transaksi terakhir
    $lastTransaksi = Transaksi::orderBy('id', 'desc')->first();

    if ($lastTransaksi) {
        // Ekstrak nomor terakhir
        $lastNumber = intval(substr($lastTransaksi->kode_transaksi, 1));
        $newNumber = $lastNumber + 1;
    } else {
        $newNumber = 1;
    }

    // Format kode transaksi dengan padding
    return 'T' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
}

// Dalam method create()
public function create()
{
    $pembelis = Pembeli::all();
    $barangs = Barang::all();
    $newKodeTransaksi = $this->generateKodeTransaksi();
    return view('transaksi.create', compact('pembelis', 'barangs', 'newKodeTransaksi'));
}

    public function index()
    {
        $transaksis = Transaksi::with(['pembeli', 'barang'])->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function store(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                // Validasi
                $validatedData = $request->validate([
                    'kode_transaksi' => 'required|unique:transaksis,kode_transaksi',
                    'pembeli_id' => 'required|exists:pembelis,id',
                    'kode_barang' => 'required|exists:barangs,kode_barang',
                    'jumlah_barang' => 'required|numeric|min:1',
                    'total_harga' => 'required|numeric|min:0',
                    'tanggal_transaksi' => 'required|date',
                    'status' => 'required|in:selesai,pending,batal'
                ]);
    
                // Debugging: Periksa data yang akan disimpan
                \Log::info('Data Transaksi:', $validatedData);
    
                // Cari barang
                $barang = Barang::where('kode_barang', $request->kode_barang)
                    ->lockForUpdate()
                    ->first();
                
                // Cek stok
                if (!$barang || $barang->stok < $request->jumlah_barang) {
                    throw new \Exception('Stok barang tidak mencukupi');
                }
    
                // Kurangi stok
                $barang->decrement('stok', $request->jumlah_barang);
    
                // Buat transaksi dengan data yang lengkap
                $transaksi = new Transaksi();
                $transaksi->kode_transaksi = $validatedData['kode_transaksi'];
                $transaksi->pembeli_id = $validatedData['pembeli_id'];
                $transaksi->kode_barang = $validatedData['kode_barang'];
                $transaksi->jumlah_barang = $validatedData['jumlah_barang'];
                $transaksi->total_harga = $validatedData['total_harga'];
                $transaksi->tanggal_transaksi = $validatedData['tanggal_transaksi'];
                $transaksi->status = $validatedData['status'];
                
                // Debugging: Periksa model sebelum save
                \Log::info('Model Transaksi:', $transaksi->toArray());
    
                // Simpan transaksi
                $transaksi->save();
    
                return redirect()->route('transaksi.index')
                    ->with('success', 'Transaksi berhasil ditambahkan');
            });
        } catch (\Exception $e) {
            // Logging error yang detail
            \Log::error('Error tambah transaksi:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
    
            return back()
                ->withErrors(['error' => 'Gagal menambah transaksi: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function edit(Transaksi $transaksi)
    {
        $pembelis = Pembeli::all();
        $barangs = Barang::all();
        return view('transaksi.edit', compact('transaksi', 'pembelis', 'barangs'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        try {
            return DB::transaction(function () use ($request, $transaksi) {
                // Validasi
                $validatedData = $request->validate([
                    'kode_transaksi' => 'required|unique:transaksis,kode_transaksi,'.$transaksi->id,
                    'pembeli_id' => 'required|exists:pembelis,id',
                    'kode_barang' => 'required|exists:barangs,kode_barang',
                    'jumlah_barang' => 'required|numeric|min:1',
                    'total_harga' => 'required|numeric|min:0',
                    'tanggal_transaksi' => 'required|date',
                    'status' => 'required|in:selesai,pending,batal'
                ]);

                // Kembalikan stok barang lama
                $barangLama = Barang::where('kode_barang', $transaksi->kode_barang)->first();
                $barangLama->increment('stok', $transaksi->jumlah_barang);

                // Cari barang baru
                $barangBaru = Barang::where('kode_barang', $request->kode_barang)->lockForUpdate()->first();
                
                // Cek stok
                if (!$barangBaru || $barangBaru->stok < $request->jumlah_barang) {
                    throw new \Exception('Stok barang tidak mencukupi');
                }

                // Kurangi stok barang baru
                $barangBaru->decrement('stok', $request->jumlah_barang);

                // Update transaksi
                $transaksi->update($validatedData);

                return redirect()->route('transaksi.index')
                    ->with('success', 'Transaksi berhasil diupdate');
            });

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error validasi
            return back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {
            Log::error('Error update transaksi: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal update transaksi: ' . $e->getMessage()]);
        }
    }

    public function destroy(Transaksi $transaksi)
    {
        try {
            return DB::transaction(function () use ($transaksi) {
                // Kembalikan stok barang
                $barang = Barang::where('kode_barang', $transaksi->kode_barang)->first();
                $barang->increment('stok', $transaksi->jumlah_barang);

                // Hapus transaksi
                $transaksi->delete();

                return redirect()->route('transaksi.index')
                    ->with('success', 'Transaksi berhasil dihapus');
            });
        } catch (\Exception $e) {
            Log::error('Error hapus transaksi: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menghapus transaksi: ' . $e->getMessage()]);
        }
    }public function show($id)
    {
        $transaksi = Transaksi::with(['pembeli', 'barang'])->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }
}