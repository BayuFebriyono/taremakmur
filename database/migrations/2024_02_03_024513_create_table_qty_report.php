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
        Schema::create('qty_report', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_barang');
            $table->integer('in')->nullable();
            $table->integer('out')->nullable();
            $table->integer('balance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qty_report');
    }
};
