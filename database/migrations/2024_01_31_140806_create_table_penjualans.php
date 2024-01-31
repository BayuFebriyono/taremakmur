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
        Schema::create('penjualans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('no_nota');
            $table->string('kode_barang');
            $table->integer('qty');
            $table->integer('aktual');
            $table->integer('harga');
            $table->double('diskon');
            $table->string('remark')->nullable();
            $table->string('toko');
            $table->string('status')->default('WAITING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
