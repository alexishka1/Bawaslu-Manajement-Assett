<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nip')->nullable()->after('email');
            $table->string('jabatan')->nullable()->after('nip');
            $table->string('unit_kerja')->nullable()->after('jabatan');
            $table->boolean('is_verified')->default(false)->after('role');
            $table->timestamp('verified_at')->nullable()->after('is_verified');
            $table->foreignId('verified_by')->nullable()->after('verified_at')->constrained('users')->nullOnDelete();
        });

        // Set all existing users to verified so existing accounts continue working
        DB::table('users')->update([
            'is_verified' => true,
            'verified_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn([
                'nip',
                'jabatan',
                'unit_kerja',
                'is_verified',
                'verified_at',
                'verified_by',
            ]);
        });
    }
};
