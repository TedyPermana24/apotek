<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\Kategori;
use App\Models\Unit;
use App\Models\Pemasok;


class ObatController extends Controller
{
    function tampil(){
        $data = Obat::get();
        $kategori = Kategori::get();
        $unit = Unit::get();
        $pemasok = Pemasok::get();
        return view ('obat.index', ['type_menu' => 'obat'], compact('data', 'kategori', 'unit', 'pemasok'));
    }

    function add(Request $request){
        $obat = new Obat();
        $obat->nama_obat = $request->nama_obat;
        $obat->kategori_id = $request->kategori_id;
        $obat->unit_id = $request->unit_id;
        $obat->stok = $request->stok;
        $obat->kadaluwarsa = $request->kadaluwarsa;
        $obat->harga_beli = $request->harga_beli;
        $obat->harga_jual = $request->harga_jual;
        $obat->pemasok_id = $request->pemasok_id;
        $obat->save();

        return redirect()->route('obat.tampil');
        
    }
}
