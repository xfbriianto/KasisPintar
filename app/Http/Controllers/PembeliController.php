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
    // 1. Tambahkan debug log untuk melihat data yang masuk
    \Log::info('Incoming request data:', $request->all());

    $validatedData = $request->validate([
        'kode_pembeli' => 'required|unique:pembelis,kode_pembeli',
    ]);

    try {
        // 2. Debug log untuk data yang tervalidasi
        \Log::info('Validated Data:', $validatedData);

        $pembeli = Pembeli::create($validatedData);

        // 3. Debug log untuk pembeli yang berhasil dibuat
        \Log::info('Created Pembeli:', $pembeli->toArray());

        // 4. Ubah redirect untuk memastikan kembali ke index
        return redirect('/pembeli')->with('success', 'Pembeli berhasil ditambahkan');
        
    } catch (\Exception $e) {
        // 5. Tambahkan detail error lebih lengkap
        \Log::error('Error creating pembeli: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());

        return back()
            ->withInput()
            ->with('error', 'Gagal menambahkan pembeli: ' . $e->getMessage());
    }
}
    public function show(Pembeli $pembeli)
    {
        return view('pembeli.show', compact('pembeli'));
    }

    public function edit($id)
    {
        try {
            $pembeli = Pembeli::findOrFail($id);
            \Log::info('Edit Pembeli:', $pembeli->toArray());

            return view('pembeli.edit', compact('pembeli'));
        } catch (\Exception $e) {
            \Log::error('Error finding pembeli: ' . $e->getMessage());

            return redirect()->route('pembeli.index')
                ->with('error', 'Pembeli tidak ditemukan');
        }
    }

    public function update(Request $request, $id)
    {
        \Log::info('Update Pembeli Request:', $request->all());
    
        $pembeli = Pembeli::findOrFail($id);
    
        $validatedData = $request->validate([
            'kode_pembeli' => [
                'required',
                Rule::unique('pembelis', 'kode_pembeli')->ignore($pembeli->id)
            ],
        ], [
            'kode_pembeli.unique' => 'Kode pembeli sudah digunakan.',
        ]);
        
        try {
            $pembeli->update($validatedData);
    
            \Log::info('Updated Pembeli:', $pembeli->toArray());
    
            return redirect()->route('pembeli.index')
                ->with('success', 'Pembeli berhasil diupdate');
        } catch (\Exception $e) {
            \Log::error('Error updating pembeli: ' . $e->getMessage());
    
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate pembeli: ' . $e->getMessage());
        }
    }

    public function destroy(Pembeli $pembeli)
    {
        try {
            $pembeli->delete();

            return redirect()->route('pembeli.index')
                ->with('success', 'Pembeli berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('pembeli.index')
                ->with('error', 'Gagal menghapus pembeli: ' . $e->getMessage());
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $pembelis = Pembeli::where('kode_pembeli', 'LIKE', "%{$query}%")
            ->paginate(10);

        return view('pembeli.index', compact('pembelis', 'query'));
    }
}