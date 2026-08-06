<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('kode_bmn')->unique();
            $table->string('nama_barang');
            $table->enum('kategori', [
                'Elektronik',
                'ATK',
                'Kendaraan',
                'Mebel',
                'Arsip',
            ]);
            $table->string('foto')->nullable();
            $table->string('lokasi_simpan');
            $table->string('qr_code')->nullable();
            $table->enum('status', [
                'tersedia',
                'terpakai',
                'servis',
                'rusak',
            ])->default('tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
