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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique();
            $table->unsignedBigInteger('kategori_id');
            $table->string('nama_barang');
            $table->decimal('harga_jual', 10, 2);
            $table->decimal('harga_dasar', 10, 2);
            $table->integer('stok')->default(0);
            $table->decimal('diskon', 5, 2)->default(0);
            $table->string('tipe_barang')->nullable();
            $table->timestamps();
    
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
