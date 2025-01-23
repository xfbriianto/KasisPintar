<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    protected $table = 'transaksis';

    protected $fillable = [
        'kode_transaksi', 
        'pembeli_id',
        'kode_barang', 
        'jumlah_barang', 
        'total_harga', 
        'tanggal_transaksi', 
        'jam_transaksi',
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
        return $this->belongsToMany(Barang::class)->withPivot('jumlah', 'harga');
        return $this->belongsToMany(Barang::class, 'transaksi_barang', 'transaksi_id', 'barang_id')
        ->withPivot('jumlah', 'harga');
          return $this->belongsToMany(
        Barang::class,
        'transaksi_barang',    // Nama pivot table
        'transaksi_id',        // Foreign key di pivot table untuk transaksi
        'barang_id'            // Foreign key di pivot table untuk barang
    )->withPivot('jumlah', 'harga'); // Pastikan kolom pivot ada

    }

    public function detailTransaksi()
{
    return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
}

}