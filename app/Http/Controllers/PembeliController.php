<?php
namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Models\Pembeli;
use Illuminate\Http\Request;

class PembeliController extends Controller
{
    public function index()
    {
        // Gunakan paginate untuk mendukung pagination
        $pembelis = Pembeli::paginate(10);
        return view('pembeli.index', compact('pembelis'));
    }

    public function create()
    {
        // Generate kode pembeli otomatis
        $lastPembeli = Pembeli::orderBy('id', 'desc')->first();
        $newKodePembeli = $lastPembeli 
            ? 'P' . sprintf('%04d', intval(substr($lastPembeli->kode_pembeli, 1)) + 1) 
            : 'P0001';

        return view('pembeli.create', compact('newKodePembeli'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'kode_pembeli' => 'required', // Ensure pembeli exists in the database
            'nama_pembeli' => 'required|string|max:255', // Ensure nama_pembeli is a string and not too long
            'alamat' => 'required|string|max:255', // Ensure alamat is a string and not too long
            'telepon' => 'required|string|max:15', // Ensure telepon is a string and not too long
        ]);

    try {
        // Debug: Cetak data yang akan disimpan
        \Log::info('Validated Data:', $validatedData);

        // Simpan data
        $pembeli = Pembeli::create($validatedData);

        // Debug: Cetak pembeli yang baru dibuat
        \Log::info('Created Pembeli:', $pembeli->toArray());

        // Redirect dengan pesan sukses
        return redirect()->route('pembeli.index')
            ->with('success', 'Pembeli berhasil ditambahkan');
    } catch (\Exception $e) {
        // Log error
        \Log::error('Error creating pembeli: ' . $e->getMessage());

        // Redirect dengan pesan error
        return redirect()->back()
            ->withInput()
            ->with('error', 'Gagal menambahkan pembeli: ' . $e->getMessage());
    }
}

    public function show(Pembeli $pembeli)
    {
        // Tampilkan detail pembeli
        return view('pembeli.show', compact('pembeli'));
    }

    public function edit($id)
{
    try {
        // Temukan pembeli
        $pembeli = Pembeli::findOrFail($id);

        // Debug: Cetak data pembeli
        \Log::info('Edit Pembeli:', $pembeli->toArray());

        // Kirim ke view
        return view('pembeli.edit', compact('pembeli'));
    } catch (\Exception $e) {
        // Log error
        \Log::error('Error finding pembeli: ' . $e->getMessage());

        // Redirect dengan pesan error
        return redirect()->route('pembeli.index')
            ->with('error', 'Pembeli tidak ditemukan');
    }
}

    public function update(Request $request, $id)
    {
        // Logging untuk debugging
        \Log::info('Update Pembeli Request:', $request->all());
    
        // Temukan pembeli yang akan diupdate
        $pembeli = Pembeli::findOrFail($id);
    
        // Validasi data
        $validatedData = $request->validate([
            'kode_pembeli' => [
                'required',
                // Abaikan unique untuk kode pembeli saat ini
                Rule::unique('pembelis', 'kode_pembeli')->ignore($pembeli->id)
            ],
            'nama_pembeli' => 'required|max:255',
            'alamat' => 'required',
            'telepon' => 'required|max:15'
        ], [
            // Pesan error kustom
            'kode_pembeli.unique' => 'Kode pembeli sudah digunakan.',
            'nama_pembeli.required' => 'Nama pembeli wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'telepon.required' => 'Nomor telepon wajib diisi.'
        ]);
    
        try {
            // Update pembeli
            $pembeli->update($validatedData);
    
            // Debug: Cetak pembeli yang diupdate
            \Log::info('Updated Pembeli:', $pembeli->toArray());
    
            // Redirect dengan pesan sukses
            return redirect()->route('pembeli.index')
                ->with('success', 'Pembeli berhasil diupdate');
        } catch (\Exception $e) {
            // Log error
            \Log::error('Error updating pembeli: ' . $e->getMessage());
    
            // Redirect dengan pesan error
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate pembeli: ' . $e->getMessage());
        }
    }

    public function destroy(Pembeli $pembeli)
    {
        try {
            // Hapus data
            $pembeli->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('pembeli.index')
                ->with('success', 'Pembeli berhasil dihapus');
        } catch (\Exception $e) {
            // Tangani error
            return redirect()->route('pembeli.index')
                ->with('error', 'Gagal menghapus pembeli: ' . $e->getMessage());
        }
    }

    // Metode pencarian (opsional)
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $pembelis = Pembeli::where('nama_pembeli', 'LIKE', "%{$query}%")
            ->orWhere('kode_pembeli', 'LIKE', "%{$query}%")
            ->paginate(10);

        return view('pembeli.index', compact('pembelis', 'query'));
    }
}