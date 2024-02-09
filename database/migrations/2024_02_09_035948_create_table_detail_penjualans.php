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
        Schema::create('detail_penjualans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('no_invoice');
            $table->string('kode_barang');
            $table->string('jenis');
            $table->string('qty');
            $table->string('aktual');
            $table->integer('harga_satuan');
            $table->integer('harga');
            $table->integer('diskon')->default(0);
            $table->string('remark')->nullable();
            $table->string('status')->default('WAITING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualans');
    }
};
