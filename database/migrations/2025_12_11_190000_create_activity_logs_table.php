<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            // id user/admin (nullable untuk event system)
            $table->unsignedBigInteger('user_id')->nullable();

            // jenis: login, logout, scan_success, scan_failed, admin_create_user, dll.
            $table->string('activity', 100);

            // detail tambahan
            $table->text('description')->nullable();

            // ip, device, user agent
            $table->string('ip', 64)->nullable();
            $table->string('device_id', 128)->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
