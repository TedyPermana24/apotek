<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanObat extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model
    protected $table = 'penjualan_obat';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'penjualan_id',
        'obat_id',
        'nama',
        'jumlah',
        'harga',
    ];

    // Relasi dengan model Pembelian
    public function penjualans()
    {
        return $this->belongsTo(Penjualan::class);
    }

    // Relasi dengan model Obat
    public function obats()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }
}
