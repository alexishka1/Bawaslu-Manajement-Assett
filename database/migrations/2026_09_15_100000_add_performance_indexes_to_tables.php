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
        Schema::table('items', function (Blueprint $table) {
            $table->index('status');
            $table->index('kategori');
            $table->index('created_at');
        });

        Schema::table('item_transactions', function (Blueprint $table) {
            $table->index('tanggal_kembali');
            $table->index('created_at');
        });

        Schema::table('item_reports', function (Blueprint $table) {
            $table->index('created_at');
        });

        Schema::table('bast_pemakaian_headers', function (Blueprint $table) {
            $table->index('status_dokumen');
            $table->index('created_at');
        });

        Schema::table('bast_pengembalian_headers', function (Blueprint $table) {
            $table->index('status_dokumen');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['kategori']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('item_transactions', function (Blueprint $table) {
            $table->dropIndex(['tanggal_kembali']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('item_reports', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });

        Schema::table('bast_pemakaian_headers', function (Blueprint $table) {
            $table->dropIndex(['status_dokumen']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('bast_pengembalian_headers', function (Blueprint $table) {
            $table->dropIndex(['status_dokumen']);
            $table->dropIndex(['created_at']);
        });
    }
};
