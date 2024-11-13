<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogEntry extends Model
{
    protected $table = 'log_entries';

    protected $fillable = [
        'username',  
        'action',
        'pembelian_id',
        'penjualan_id',
        'details',
    ];
}
