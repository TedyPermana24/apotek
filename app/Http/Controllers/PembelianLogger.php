<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogEntry;
use Yajra\DataTables\Facades\DataTables;

class PembelianLogger extends Controller
{
    public function tampil(Request $request)
    {
        if ($request->ajax()) {
            $logs = LogEntry::whereNotNull('pembelian_id')->get(); 

            return DataTables::of($logs)->make(true);
        }

        return view('pages.logger.pembelianLogger', ['type_menu' => 'logger']); 
    }
}
