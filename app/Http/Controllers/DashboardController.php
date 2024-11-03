<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\User;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    function tampil(){
        $jumlahObat = Obat::count();
        $totalPenjualan = Penjualan::sum('total_harga');
        $totalPembelian = Pembelian::sum('total_harga');
        $hari = now()->addDays(30);
        $ObatKadaluwarsa = Obat::where('kadaluwarsa', '<', $hari )->get();
        $ObatTerlaris = DB::table('penjualan_obat')
        ->join('obats', 'penjualan_obat.obat_id', '=', 'obats.id')
        ->select('obats.nama_obat as nama_obat', 'obat_id', DB::raw('SUM(penjualan_obat.jumlah) as total_terjual'))
        ->groupBy('obat_id', 'obats.nama_obat')
        ->orderByDesc('total_terjual')
        ->take(5)
        ->get();

        return view('home', ['type_menu' => 'dashboard'], compact('ObatKadaluwarsa', 'jumlahObat', 'totalPembelian', 'totalPenjualan', 'ObatTerlaris'));
    }
}
