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
        Schema::create('penjualan_obat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjualan_id')->constrained();
            $table->foreignId('obat_id')->constrained();
            $table->integer('jumlah');
            $table->integer('harga');
            $table->timestamps();

            // $table->foreign('penjualan_id')->references('id')->on('penjualans')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_obat');
    }
};
