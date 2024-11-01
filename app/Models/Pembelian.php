<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian';
    protected $fillable = ['invoice', 'tanggal', 'pemasok_id', 'total_harga'];

    public function pemasoks()
    {
        return $this->belongsTo(Pemasok::class, 'pemasok_id');
    }

    public function obats()
    {
        return $this->belongsToMany(Obat::class, 'pembelian_obat')->withPivot('jumlah', 'harga');
    }
}
