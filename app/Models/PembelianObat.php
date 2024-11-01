<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianObat extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model
    protected $table = 'pembelian_obat';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'pembelian_id',
        'obat_id',
        'jumlah',
        'harga',
    ];

    // Relasi dengan model Pembelian
    public function pembelians()
    {
        return $this->belongsTo(Pembelian::class);
    }

    // Relasi dengan model Obat
    public function obats()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }
}
