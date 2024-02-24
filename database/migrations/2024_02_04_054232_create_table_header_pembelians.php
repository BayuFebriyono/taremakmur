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
        Schema::create('header_pembelians', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id');
            $table->foreignUuid('suplier_id');
            $table->string('no_invoice')->unique();
            $table->string('jenis_pembayaran')->default('tunai');
            $table->integer('uang_muka')->nullable();
            $table->date('jatuh_tempo')->nullable();
            $table->boolean('sudah_cetak')->default(false);
            $table->boolean('lunas')->default(false);
            $table->string('status')->default('WAITING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('header_pembelians');
    }
};
