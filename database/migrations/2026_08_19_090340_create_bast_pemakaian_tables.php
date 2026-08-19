<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bast_pemakaian_headers', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_bast')->nullable()->unique();
            $table->enum('jenis_bast', ['BAST_PEMAKAIAN_KIB', 'BAST_PEMAKAIAN_NON_KIB', 'BAST_PINJAM_PAKAI']);
            $table->date('tanggal_bast');
            $table->string('lokasi')->default('Kantor Bawaslu');
            $table->string('pihak_pertama_nip');
            $table->foreign('pihak_pertama_nip')->references('nip')->on('ref_pejabats')->cascadeOnUpdate();
            $table->enum('pihak_kedua_tipe', ['internal', 'eksternal'])->default('internal');
            $table->string('pihak_kedua_nip')->nullable();
            $table->foreign('pihak_kedua_nip')->references('nip')->on('ref_pegawais')->cascadeOnUpdate();
            $table->string('pihak_kedua_nama_manual')->nullable();
            $table->string('ttd_pihak1_url')->nullable();
            $table->string('ttd_pihak2_url')->nullable();
            $table->enum('status_dokumen', ['draft', 'final'])->default('draft');
            $table->foreignId('dibuat_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('bast_pemakaian_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bast_header_id')->constrained('bast_pemakaian_headers')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->string('kondisi_saat_diserahkan')->default('Baik');
            $table->enum('status_item', ['dipakai', 'dikembalikan'])->default('dipakai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bast_pemakaian_details');
        Schema::dropIfExists('bast_pemakaian_headers');
    }
};