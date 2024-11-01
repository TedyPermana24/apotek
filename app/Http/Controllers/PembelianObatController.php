<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembelianObat;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PembelianObatController extends Controller
{
    function tampil(Request $request){
        if ($request->ajax()) {
            $pembelian = Pembelian::query();

            return DataTables::of($pembelian)
            ->addColumn('pemasok_id', function ($pemasok) {
                return $pemasok->pemasoks ? $pemasok->pemasoks->pemasok : 'N/A'; // Get supplier name
            }) ->make(true);;
        }

        return view ('pages.detailpembelian.index', ['type_menu' => 'transaksi']);
    }

    function detail($id){
        $pembelian = Pembelian::with('pemasoks')->find($id);
        $detailObat = PembelianObat::with('obats')->where('pembelian_id', $id)->get();
        return view('pages.detailpembelian.detail', ['type_menu' => 'transaksi'], compact('pembelian', 'detailObat') );
        // return view('pages.detailpembelian.detail', ['type_menu' => 'transaksi']);
    }
}
