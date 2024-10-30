<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'units';
    protected $fillable = [
        'nama_unit'
    ];

    function obats()
    {
        return $this->hasMany(Obat::class, 'unit_id');
    }

}
