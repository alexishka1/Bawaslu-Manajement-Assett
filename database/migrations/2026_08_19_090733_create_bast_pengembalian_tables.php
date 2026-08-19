<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bast_pengembalian_headers', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_bast_pengembalian')->nullable()->unique();
            $table->date('tanggal');
            $table->string('lokasi')->default('Kantor Bawaslu');
            $table->enum('pihak_menyerahkan_tipe', ['internal', 'eksternal'])->default('internal');
            $table->string('pihak_menyerahkan_nip')->nullable();
            $table->foreign('pihak_menyerahkan_nip')->references('nip')->on('ref_pegawais')->cascadeOnUpdate();
            $table->string('pihak_menyerahkan_nama_manual')->nullable();
            $table->string('pihak_menerima_nip');
            $table->foreign('pihak_menerima_nip')->references('nip')->on('ref_pejabats')->cascadeOnUpdate();
            $table->string('ttd_pihak1_url')->nullable();
            $table->string('ttd_pihak2_url')->nullable();
            $table->enum('status_dokumen', ['draft', 'final'])->default('draft');
            $table->foreignId('dibuat_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('bast_pengembalian_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengembalian_header_id')->constrained('bast_pengembalian_headers')->cascadeOnDelete();
            $table->foreignId('bast_pemakaian_detail_id')->nullable()->constrained('bast_pemakaian_details')->nullOnDelete();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->enum('kondisi_saat_kembali', ['Baik', 'Rusak Ringan', 'Rusak Berat', 'Hilang'])->default('Baik');
            $table->text('catatan_kerusakan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bast_pengembalian_details');
        Schema::dropIfExists('bast_pengembalian_headers');
    }
};