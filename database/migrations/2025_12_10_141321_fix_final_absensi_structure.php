<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * ============================
         *  UPDATE TABLE ABSENSIS
         * ============================
         */
        Schema::table('absensis', function (Blueprint $table) {

            // Tambah device ID untuk mengunci 1 perangkat per siswa
            if (!Schema::hasColumn('absensis', 'device_id')) {
                $table->string('device_id', 100)->nullable()->after('ip_address');
            }

            // Tambah user agent (optional tapi sangat berguna)
            if (!Schema::hasColumn('absensis', 'user_agent')) {
                $table->text('user_agent')->nullable()->after('device_id');
            }

            // ENUM status final
            if (Schema::hasColumn('absensis', 'status')) {
                $table->enum('status', [
                    'hadir',
                    'terlambat',
                    'izin',
                    'sakit',
                    'alpha',
                    'manual'
                ])->default('hadir')->change();
            }
        });


        /**
         * ============================
         *  UPDATE TABLE USERS
         * ============================
         */
        Schema::table('users', function (Blueprint $table) {

            // Device ID terakhir yang digunakan login
            if (!Schema::hasColumn('users', 'device_id')) {
                $table->string('device_id', 100)->nullable()->after('foto');
            }

            // User Agent terakhir
            if (!Schema::hasColumn('users', 'user_agent')) {
                $table->text('user_agent')->nullable()->after('device_id');
            }

            // IP login terakhir
            if (!Schema::hasColumn('users', 'last_ip')) {
                $table->string('last_ip', 45)->nullable()->after('user_agent');
            }

            // Waktu login terakhir
            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->dateTime('last_login_at')->nullable()->after('last_ip');
            }
        });
    }

    public function down(): void
    {
        // Tidak menghapus kolom agar aman untuk rollback deployment
    }
};
