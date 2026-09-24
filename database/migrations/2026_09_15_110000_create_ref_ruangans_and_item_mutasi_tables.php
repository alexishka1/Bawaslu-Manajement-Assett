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
        // 1. Tabel Master Ruangan Kantor
        Schema::create('ref_ruangans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_ruangan', 20)->unique();
            $table->string('nama_ruangan', 100);
            $table->string('lantai', 50)->default('Lantai 1');
            $table->string('gedung', 100)->default('Gedung Kantor Bawaslu');
            $table->string('penanggung_jawab', 100)->nullable();
            $table->string('nip_penanggung_jawab', 30)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // 2. Hubungkan Tabel Items ke Ruangan
        Schema::table('items', function (Blueprint $table) {
            $table->foreignId('ref_ruangan_id')
                ->nullable()
                ->after('status')
                ->constrained('ref_ruangans')
                ->nullOnDelete();
        });

        // 3. Tabel Log Mutasi & Perpindahan Aset Antar Ruangan
        Schema::create('item_mutasi_ruangans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->foreignId('ruangan_asal_id')->nullable()->constrained('ref_ruangans')->nullOnDelete();
            $table->foreignId('ruangan_tujuan_id')->constrained('ref_ruangans')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('tanggal_mutasi');
            $table->string('alasan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_mutasi_ruangans');

        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['ref_ruangan_id']);
            $table->dropColumn('ref_ruangan_id');
        });

        Schema::dropIfExists('ref_ruangans');
    }
};
