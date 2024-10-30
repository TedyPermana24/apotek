<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    protected $fillable = ['nama', 'tanggal', 'total_harga'];

    public function obats()
    {
        return $this->belongsToMany(Obat::class, 'penjualan_obat')->withPivot('nama', 'jumlah', 'harga');
    }
}
