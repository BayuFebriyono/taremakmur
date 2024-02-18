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
        Schema::create('barangs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('suplier_id');
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->integer('stock_sto')->default(0);
            $table->integer('jumlah_renteng')->default(0);
            $table->integer('stock_renteng')->default(0);
            $table->integer('stock_bayangan')->default(0);
            $table->integer('cash_dus')->nullable();
            $table->integer('cash_pack')->nullable();
            $table->integer('kredit_dus')->nullable();
            $table->integer('kredit_pack')->nullable();
            $table->integer('harga_beli_dus')->nullable();
            $table->integer('harga_beli_pack')->nullable();
            $table->double('diskon')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
