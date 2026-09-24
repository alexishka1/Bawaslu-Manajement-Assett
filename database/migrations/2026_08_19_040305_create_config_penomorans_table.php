<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('config_penomorans', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_dokumen')->index();
            $table->string('format_nomor');
            $table->integer('counter_terakhir')->default(0);
            $table->integer('tahun_berjalan');
            $table->timestamps();

            $table->unique(['jenis_dokumen', 'tahun_berjalan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('config_penomorans');
    }
};
