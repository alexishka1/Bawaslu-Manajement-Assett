<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ref_pegawais', function (Blueprint $table) {
            $table->string('nip')->primary();
            $table->string('nama');
            $table->string('jabatan');
            $table->string('unit_kerja');
            $table->enum('status', ['aktif', 'non_aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ref_pegawais');
    }
};
