<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';
    protected $fillable = [
        'kategori',
        'deskripsi',
    ];

    function obats()
    {
        return $this->hasMany(Obat::class, 'kategori_id');
    }

}
