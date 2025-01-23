<?php
namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pembeli;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;  // Menambahkan Carbon untuk manipulasi tanggal dan waktu

class TransaksiController extends Controller
{
    /**
     * Generate kode transaksi otomatis
     */
    
    private function generateKodeTransaksi()
    {
        $lastTransaksi = Transaksi::orderBy('id', 'desc')->first();
        $newNumber = $lastTransaksi ? intval(substr($lastTransaksi->kode_transaksi, 1)) + 1 : 1;

        return 'T' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public function createPembeli()
    {
        $newKodePembeli = $this->generateKodePembeli();
        return view('transaksi.create_pembeli', compact('newKodePembeli'));
    }

    private function generateKodePembeli()
    {
        $lastPembeli = Pembeli::orderBy('id', 'desc')->first();
        $newNumber = $lastPembeli ? intval(substr($lastPembeli->kode_pembeli, 2)) + 1 : 1;

        return 'P' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public function storePembeli(Request $request)
{
    $validatedData = [
        'kode_pembeli' => $this->generateKodePembeli()
    ];
    
    $pembeli = Pembeli::create($validatedData);

    return redirect()->route('transaksi.create')
        ->with('selected_pembeli_id', $pembeli->id);
}

    public function getPembelis()
    {
        $pembelis = Pembeli::select('id', 'nama', 'telepon')->get();
        return response()->json($pembelis);
    }

    /**
     * Halaman index transaksi
     */
    public function index()
    {
        // Mengambil semua data transaksi, termasuk relasi dengan pembeli dan barang
        $transaksis = Transaksi::all();
        return view('transaksi.index', compact('transaksis'));
    }

    /**
     * Form tambah transaksi
     */
    public function create()
    {
        $pembelis = Pembeli::all();
        $barangs = Barang::all();
        $newKodeTransaksi = $this->generateKodeTransaksi();

        return view('transaksi.create', compact('pembelis', 'barangs', 'newKodeTransaksi'));
    }

    /**
     * Simpan transaksi baru
     */
    public function store(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                // Validasi data input
                $validatedData = $request->validate([
                    'pembeli_id' => 'required|exists:pembelis,id',
                    'kode_barang' => 'required|exists:barangs,kode_barang',
                    'jumlah_barang' => 'required|numeric|min:1',
                    'total_harga' => 'required|numeric|min:0',
                    'status' => 'required|in:selesai,pending,batal'
                ]);

                // Cari barang dan cek stok
                $barang = Barang::where('kode_barang', $request->kode_barang)->lockForUpdate()->first();

                if (!$barang || $barang->stok < $request->jumlah_barang) {
                    throw new \Exception('Stok barang tidak mencukupi');
                }

                // Kurangi stok barang
                $barang->decrement('stok', $request->jumlah_barang);

                // Menyimpan transaksi dengan waktu otomatis
                $transaksi = Transaksi::create([
                    'kode_transaksi' => $this->generateKodeTransaksi(),
                    'tanggal_transaksi' => now(), // Menyimpan tanggal saat ini
                    'jam_transaksi' => Carbon::now()->format('H:i:s'), // Menyimpan waktu saat ini
                    'pembeli_id' => $validatedData['pembeli_id'],
                    'kode_barang' => $validatedData['kode_barang'],
                    'jumlah_barang' => $validatedData['jumlah_barang'],
                    'total_harga' => $validatedData['total_harga'],
                    'status' => $validatedData['status'],
                ]);

                return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan');
            });
        } catch (\Exception $e) {
            Log::error('Error tambah transaksi:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return back()->withErrors(['error' => 'Gagal menambah transaksi: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Form edit transaksi
     */
    public function edit(Transaksi $transaksi)
    {
        $pembelis = Pembeli::all();
        $barangs = Barang::all();

        return view('transaksi.edit', compact('transaksi', 'pembelis', 'barangs'));
    }

    /**
     * Update transaksi
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        try {
            return DB::transaction(function () use ($request, $transaksi) {
                // Validasi data input
                $validatedData = $request->validate([
                    'pembeli_id' => 'required|exists:pembelis,id',
                    'kode_barang' => 'required|exists:barangs,kode_barang',
                    'jumlah_barang' => 'required|numeric|min:1',
                    'total_harga' => 'required|numeric|min:0',
                    'status' => 'required|in:selesai,pending,batal'
                ]);

                // Kembalikan stok barang lama
                $barangLama = Barang::where('kode_barang', $transaksi->kode_barang)->first();
                $barangLama->increment('stok', $transaksi->jumlah_barang);

                // Cari barang baru dan cek stok
                $barangBaru = Barang::where('kode_barang', $request->kode_barang)->lockForUpdate()->first();

                if (!$barangBaru || $barangBaru->stok < $request->jumlah_barang) {
                    throw new \Exception('Stok barang tidak mencukupi');
                }

                // Kurangi stok barang baru
                $barangBaru->decrement('stok', $request->jumlah_barang);

                // Update transaksi
                $transaksi->update($validatedData);

                return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diupdate');
            });
        } catch (\Exception $e) {
            Log::error('Error update transaksi:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors(['error' => 'Gagal update transaksi: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Hapus transaksi
     */
    public function destroy(Transaksi $transaksi)
    {
        try {
            return DB::transaction(function () use ($transaksi) {
                // Kembalikan stok barang
                $barang = Barang::where('kode_barang', $transaksi->kode_barang)->first();
                $barang->increment('stok', $transaksi->jumlah_barang);

                // Hapus transaksi
                $transaksi->delete();

                return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus');
            });
        } catch (\Exception $e) {
            Log::error('Error hapus transaksi:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors(['error' => 'Gagal menghapus transaksi: ' . $e->getMessage()]);
        }
    }

    /**
     * Tampilkan detail transaksi
     */
    public function show($id)
    {
        $transaksi = Transaksi::with(['pembeli', 'barang'])->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }
}