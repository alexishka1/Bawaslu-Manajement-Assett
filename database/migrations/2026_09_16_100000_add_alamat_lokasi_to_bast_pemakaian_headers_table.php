<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bast_pemakaian_headers', function (Blueprint $table) {
            $table->text('alamat_peminjam')->nullable()->after('pihak_kedua_nama_manual');
            $table->decimal('latitude', 10, 8)->nullable()->after('alamat_peminjam');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
        });
    }

    public function down(): void
    {
        Schema::table('bast_pemakaian_headers', function (Blueprint $table) {
            $table->dropColumn(['alamat_peminjam', 'latitude', 'longitude']);
        });
    }
};
