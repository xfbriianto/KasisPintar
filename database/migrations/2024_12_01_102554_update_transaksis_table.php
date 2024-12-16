<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->string('kode_pembeli'); // Tambahan kolom
            $table->integer('jumlah_barang');
            $table->string('kode_barang'); // Tambahan kolom
            $table->decimal('harga_jual', 10, 2); // Tambahan kolom
            $table->decimal('total_harga', 10, 2); // Tambahan kolom
            $table->unsignedBigInteger('pembeli_id');
            $table->unsignedBigInteger('kasir_id');
            $table->date('tanggal_transaksi');
            $table->string('status')->default('selesai');
            $table->timestamps();
    
            $table->foreign('pembeli_id')->references('id')->on('pembelis')->onDelete('cascade');
            $table->foreign('kasir_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
