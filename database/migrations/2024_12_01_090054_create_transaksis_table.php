<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            
            // Pastikan tipe data sesuai dengan primary key barangs
            $table->unsignedBigInteger('pembeli_id');
            $table->string('kode_barang');
            
            $table->integer('jumlah_barang');
            $table->decimal('total_harga', 15, 2);
            $table->date('tanggal_transaksi');
            $table->enum('status', ['pending', 'selesai', 'batal'])->default('pending');
            
            // Foreign key constraints
            $table->foreign('pembeli_id')
                  ->references('id')
                  ->on('pembelis')
                  ->onDelete('cascade');
            
            $table->foreign('kode_barang')
                  ->references('kode_barang')
                  ->on('barangs')
                  ->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        // Hapus foreign key terlebih dahulu
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropForeign(['pembeli_id']);
            $table->dropForeign(['kode_barang']);
        });
        
        Schema::dropIfExists('transaksis');
    }
}