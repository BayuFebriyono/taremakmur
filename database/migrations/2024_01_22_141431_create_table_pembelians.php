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
        Schema::create('pembelians', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('suplier_id');
            $table->string('no_invoice');
            $table->string('kode_barang');
            $table->integer('qty');
            $table->integer('aktual')->default(0);
            $table->integer('harga');
            $table->double('diskon')->default(0);
            $table->string('remark')->nullable();
            $table->string('status',12)->default('WAITING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelians');
    }
};
