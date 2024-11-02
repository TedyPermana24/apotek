<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\PenjualanObat;
use App\Models\Obat;
use Yajra\DataTables\Facades\DataTables;


class PenjualanObatController extends Controller
{
    function tampil(Request $request){
        if ($request->ajax()) {
            $penjualan = Penjualan::query();

            return DataTables::of($penjualan)
            ->make(true);
        }

        return view ('pages.detailpenjualan.index', ['type_menu' => 'transaksi', 'penjualan_obat' => PenjualanObat::all()]);
    }

    function detail($id){
        $penjualan = Penjualan::find($id);
        $detailObat = PenjualanObat::with('obats')->where('penjualan_id', $id)->get();
        return view('pages.detailpenjualan.detail', ['type_menu' => 'transaksi'], compact('penjualan', 'detailObat'));
    }

    
}
