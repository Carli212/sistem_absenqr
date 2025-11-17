<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            // Tambahkan kolom 'tanggal' di bawah user_id
            $table->date('tanggal')->after('user_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropColumn('tanggal');
        });
    }
};
