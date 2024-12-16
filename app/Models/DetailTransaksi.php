<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $fillable = [
        'transaksi_id', 
        'barang_id', 
        'jumlah_barang', 
        'harga_jual', 
        'subtotal',
        'tanggal_pembelian'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}