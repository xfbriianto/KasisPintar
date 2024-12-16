<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Diskon extends Model
{
    protected $fillable = [
        'tanggal_mulai', 
        'tanggal_selesai', 
        'keterangan'
    ];
}