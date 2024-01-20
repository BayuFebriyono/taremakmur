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
            $table->integer('stock')->default(0);
            $table->integer('balance')->default(0);
            $table->integer('kredit_dus')->nullable();
            $table->integer('kredit_pack')->nullable();
            $table->integer('kredit_pcs')->nullable();
            $table->integer('cash_dus')->nullable();
            $table->integer('cash_pack')->nullable();
            $table->integer('cash_pcs')->nullable();
            $table->boolean('diskon')->nullable();
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
