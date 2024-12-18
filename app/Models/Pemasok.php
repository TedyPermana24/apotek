<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    use HasFactory;

    protected $table = 'pemasoks';
    protected $fillable = ['pemasok', 'alamat', 'telepon', 'deskripsi'];

    // public function obats()
    // {
    //     return $this->hasMany(Obat::class, 'kategori_id');
    // }

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class);
    }

   
}
