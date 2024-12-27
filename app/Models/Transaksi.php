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
        'status'
    ];

    // Relasi
    public function pembeli()
    {
    return $this->belongsTo(Pembeli::class, 'pembeli_id')->withoutGlobalScopes();
}

    

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode_barang');
    }
}