<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;


    protected $fillable = [
        'nama_obat',
        'kategori',
        'stok',
        'date',
        'harga'
    ];

    function kategoris()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    function units()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

}
