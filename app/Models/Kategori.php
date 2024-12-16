<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillablle = ['nama_kategori', 'deskripsi'];
    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }
}

