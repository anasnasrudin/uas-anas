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
        Schema::create('table_users', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('tipe_user',50)->nullable();
            $table->string('nama',50)->nullable();
            $table->string('alamat',150)->nullable();
            $table->string('telepon',50)->nullable();
            $table->string('username',50)->nullable();
            $table->string('password',50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_users');
    }
};
