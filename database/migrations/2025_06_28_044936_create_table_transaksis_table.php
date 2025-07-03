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
        Schema::create('table_transaksis', function (Blueprint $table) {
            $table->increments('id_transaksi');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_barang');
            $table->string('no_transaksi',50)->nullable();
            $table->date('tgl_transaksi')->nullable();
            $table->bigInteger('total_bayar')->nullable();
            $table->foreign('id_user')->references('id_user')->on('table_users');
            $table->foreign('id_barang')->references('id_barang')->on('table_barangs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_transaksis');
    }
};
