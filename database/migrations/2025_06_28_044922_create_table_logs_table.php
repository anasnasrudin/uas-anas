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
        Schema::create('table_logs', function (Blueprint $table) {
            $table->increments('id_log');
            $table->unsignedInteger('id_user');
            $table->timestamp('waktu')->nullable();
            $table->string('aktivitas',50)->nullable();
            $table->foreign('id_user')->references('id_user')->on('table_users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_logs');
    }
};
