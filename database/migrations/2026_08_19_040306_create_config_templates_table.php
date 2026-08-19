<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('config_templates', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_dokumen')->unique();
            $table->string('nama_template');
            $table->string('blade_view');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('config_templates');
    }
};