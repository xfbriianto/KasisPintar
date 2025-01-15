<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    // Pastikan nama tabel sesuai
    protected $table = 'barangs';

    // Tambahkan kolom yang bisa diisi
    protected $fillable = [
        'kode_barang', 
        'kategori_id', 
        'nama_barang', 
        'harga_jual', 
        'harga_dasar', 
        'stok', 
        'diskon', 
        'tipe_barang'
    ];

    // Relasi dengan Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function transaksis(): BelongsToMany
  {
        return $this->belongsToMany(Transaksi::class, 'detail_transaksis', 'barang_id', 'transaksi_id')
            ->withPivot('jumlah', 'harga_satuan', 'subtotal');
            return $this->belongsToMany(Transaksi::class)->withPivot('jumlah', 'harga');
            return $this->belongsToMany(Transaksi::class, 'transaksi_barang', 'barang_id', 'transaksi_id')
                    ->withPivot('jumlah', 'harga');
                    return $this->belongsToMany(
                        Transaksi::class,
                        'transaksi_barang',
                        'barang_id',
                        'transaksi_id'
                    )->withPivot('jumlah', 'harga');
    }
}