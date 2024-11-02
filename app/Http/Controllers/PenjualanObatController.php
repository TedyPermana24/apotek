<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\PenjualanObat;
use Yajra\DataTables\Facades\DataTables;


class PenjualanObatController extends Controller
{
    function tampil(Request $request){
        if ($request->ajax()) {
            $penjualan = Penjualan::query();

            return DataTables::of($penjualan)
            ->make(true);
        }

        return view ('pages.detailpenjualan.index', ['type_menu' => 'transaksi']);
    }

    function detail($id){
        $penjualan = Penjualan::find($id);
        $detailObat = PenjualanObat::with('obats')->where('penjualan_id', $id)->get();
        return view('pages.detailpenjualan.detail', ['type_menu' => 'transaksi'], compact('penjualan', 'detailObat'));
    }

    function hapus($id){
        // Menghapus semua data terkait di penjualan_obat berdasarkan penjualan_id
        PenjualanObat::where('penjualan_id', $id)->delete();
        
        // Menghapus data penjualan
        $penjualan = Penjualan::find($id);
        if ($penjualan) {
            $penjualan->delete();
            return response()->json(['success' => 'Data penjualan dan detail obat berhasil dihapus']);
        } else {
            return response()->json(['error' => 'Data penjualan tidak ditemukan'], 404);
        }
    }
    
}
