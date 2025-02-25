<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pembeli extends Model
{
    protected $fillable = [
        'kode_pembeli',
    ];

    public $timestamps = true;

    // Method untuk mendapatkan transaksi terkait
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}