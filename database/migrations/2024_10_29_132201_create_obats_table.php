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
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_obat');
            $table->foreignId('kategori_id')->constrained();
            $table->foreignId('unit_id')->constrained();
            $table->integer('stok');
            $table->date('kadaluwarsa');
            $table->integer('harga_beli');
            $table->integer('harga_jual');
            $table->string('indikasi');
            $table->timestamps();
            // $table->foreignId('pemasok_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};
