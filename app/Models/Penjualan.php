<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualans';
    protected $fillable = ['invoice', 'nama', 'tanggal', 'total_harga'];

    public function obats()
    {
        return $this->belongsToMany(Obat::class, 'penjualan_obat')->withPivot('nama', 'jumlah', 'harga');
    }

    public function penjualanObat()
    {
        return $this->hasMany(PenjualanObat::class);
    }
}
