<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BarangResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kode_barang' => $this->kode_barang,
            'kategori_id' => $this->kategori_id,
            'nama_barang' => $this->nama_barang,
            'harga_jual' => $this->harga_jual,
            'harga_dasar' => $this->harga_dasar,
            'stok' => $this->stok,
            'diskon' => $this->diskon,
            'tipe_barang' => $this->tipe_barang,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}