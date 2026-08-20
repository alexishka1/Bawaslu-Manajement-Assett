<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('item_reports', function (Blueprint $table) {
            $table->enum('status_validasi', ['menunggu', 'divalidasi', 'ditolak'])->default('menunggu')->after('foto_bukti');
            $table->foreignId('divalidasi_oleh')->nullable()->constrained('users')->nullOnDelete()->after('status_validasi');
            $table->timestamp('tanggal_validasi')->nullable()->after('divalidasi_oleh');
        });
    }

    public function down(): void
    {
        Schema::table('item_reports', function (Blueprint $table) {
            $table->dropForeign(['divalidasi_oleh']);
            $table->dropColumn(['status_validasi', 'divalidasi_oleh', 'tanggal_validasi']);
        });
    }
};