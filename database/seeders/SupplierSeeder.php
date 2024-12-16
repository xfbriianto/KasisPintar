<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier; // Pastikan model Supplier sudah ada
use Carbon\Carbon;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $suppliers = [
            [
                'kode_supplier' => 'S001', 
                'nama_supplier' => 'PT. Sumber Rejeki', 
                'alamat' => 'Jl. Merpati No. 8', 
                'telepon' => '081345678901'
            ],
            [
                'kode_supplier' => 'S002', 
                'nama_supplier' => 'CV. Maju Bersama', 
                'alamat' => 'Jl. Mawar No. 12', 
                'telepon' => '087654321098'
            ]
        ];

        foreach ($suppliers as $supplierData) {
            Supplier::firstOrCreate(
                ['kode_supplier' => $supplierData['kode_supplier']],
                $supplierData
            );
        }
    }
}