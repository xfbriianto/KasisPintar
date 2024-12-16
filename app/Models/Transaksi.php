<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    // Pastikan nama tabel benar
    protected $table = 'transaksis';

    // Gunakan snake_case untuk kolom
    protected $fillable = [
        'kode_transaksi', 
        'pembeli_id',      // Pastikan nama kolom benar
        'kode_barang', 
        'jumlah_barang', 
        'total_harga', 
        'tanggal_transaksi', 
        'status'
    ];

    // Relasi
    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class, 'pembeli_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode_barang');
    }

    public function barangs(): BelongsToMany
    {
        return $this->belongsToMany(Barang::class, 'detail_transaksis', 'transaksi_id', 'barang_id')
            ->withPivot('jumlah', 'harga_satuan', 'subtotal');
    }
}