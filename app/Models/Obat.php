<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'obats';

    protected $fillable = [
        'nama_obat',
        'kategori',
        'unit',
        'stok',
        'kadaluwarsa',
        'harga_beli',
        'harga_jual'
    ];

    function kategoris()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    function units()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    // function pemasoks()
    // {
    //     return $this->belongsTo(Pemasok::class, 'pemasok_id');
    // }

    public function pembelians()
    {
        return $this->belongsToMany(Pembelian::class, 'pembelian_obat')->withPivot('jumlah', 'harga');
    }

    public function penjualans()
    {
        return $this->belongsToMany(Penjualan::class, 'penjualan_obat')->withPivot('nama', 'jumlah', 'harga');
    }

}
