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
        Schema::create('table_barangs', function (Blueprint $table) {
            $table->increments('id_barang');
            $table->string('kode_barang',50)->nullable();
            $table->string('nama_barang',50)->nullable();
            $table->date('expired_date')->nullable();
            $table->bigInteger('jumlah_barang')->nullable();
            $table->string('satuan',50)->nullable();
            $table->bigInteger('harga_satuan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_barangs');
    }
};
