<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * TABLE ABSENSIS
         */
        Schema::table('absensis', function (Blueprint $table) {
            // pastikan kolom tanggal ada
            if (!Schema::hasColumn('absensis', 'tanggal')) {
                $table->date('tanggal')->nullable()->after('user_id');
            }

            // pastikan waktu_absen datetime
            if (Schema::hasColumn('absensis', 'waktu_absen')) {
                $table->dateTime('waktu_absen')->nullable()->change();
            }

            // tambah metode
            if (!Schema::hasColumn('absensis', 'metode')) {
                $table->string('metode', 50)->nullable()->after('status');
            }

            // tambah ip address
            if (!Schema::hasColumn('absensis', 'ip_address')) {
                $table->string('ip_address', 45)->nullable()->after('metode');
            }

            // perbaiki enum status
            if (Schema::hasColumn('absensis', 'status')) {
                $table->enum('status', ['hadir', 'terlambat', 'alpha', 'manual'])
                      ->default('hadir')
                      ->change();
            }
        });

        /**
         * TABLE USERS
         */
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'ip_address')) {
                $table->string('ip_address', 45)->nullable()->after('tanggal_lahir');
            }

            if (!Schema::hasColumn('users', 'foto')) {
                $table->string('foto')->nullable()->after('ip_address');
            }
        });
    }

    public function down(): void
    {
        //
        // TIDAK PERLU DIISI
        // Agar tidak menghapus kolom saat rollback
    }
};
