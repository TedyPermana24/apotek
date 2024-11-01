<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Obat;
use App\Models\Pemasok;
use App\Models\Kategori;
use App\Models\PembelianObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class PembelianController extends Controller
{
    function tampil(){

        $invoice = strtoupper(Str::random(8));
        
        return view ('pages.pembelian.index', ['type_menu' => 'transaksi', 'obat' => Obat::with('kategoris')->get(), 'pemasok' => Pemasok::all(), 'kategori' => Kategori::all(), 'invoice' => strtoupper(Str::random(8))]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pemasok_id' => 'required|exists:pemasoks,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
            'harga' => 'required|array',
            'harga.*' => 'required|numeric|min:0',
            'nama_obat' => 'required|array',
            'nama_obat.*' => 'required|exists:obats,id',
        ], [
            'pemasok_id.required' => 'Pemasok wajib diisi.',
            'pemasok_id.exists' => 'Pemasok yang dipilih tidak valid.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'jumlah.required' => 'Jumlah obat wajib diisi.',
            'jumlah.array' => 'Format jumlah tidak valid.',
            'jumlah.*.required' => 'Jumlah setiap obat wajib diisi.',
            'jumlah.*.integer' => 'Jumlah harus berupa angka bulat.',
            'jumlah.*.min' => 'Jumlah minimal adalah 1.',
            'harga.required' => 'Harga obat wajib diisi.',
            'harga.array' => 'Format harga tidak valid.',
            'harga.*.required' => 'Harga setiap obat wajib diisi.',
            'harga.*.numeric' => 'Harga harus berupa angka.',
            'harga.*.min' => 'Harga minimal adalah 0.',
            'nama_obat.required' => 'Nama obat wajib diisi.',
            'nama_obat.array' => 'Format nama obat tidak valid.',
            'nama_obat.*.required' => 'Nama setiap obat wajib diisi.',
            'nama_obat.*.exists' => 'Obat yang dipilih tidak valid.',
        ]);
        

        if ($validator->fails()) {
            return redirect()->route('pembelian.tampil')
                ->withErrors($validator)
                ->withInput()
                ->with('type', 'Gagal!!')
                ->with('message', 'Pembelian gagal')
                ->with('icon', 'error');
        }

        $totalHarga = 0;
        foreach ($request->jumlah as $index => $jumlah) {
            $totalHarga += $jumlah * $request->harga[$index];
        }

        DB::beginTransaction();
   
        $pembelian = Pembelian::create([
            'invoice' => $request->invoice,
            'tanggal' => $request->tanggal,
            'pemasok_id' => $request->pemasok_id,
            'total_harga' => $totalHarga,
        ]);

        foreach ($request->jumlah as $index => $jumlah) {
            PembelianObat::create([
                'pembelian_id' => $pembelian->id,
                'obat_id' => $request->nama_obat[$index],
                'jumlah' => $jumlah,
                'harga' => $request->harga[$index],
            ]);

            $obat = Obat::find($request->nama_obat[$index]);
            $obat->stok += $jumlah;
            $obat->save();
        }

            
        DB::commit();

        return redirect()->route('detailpembelian.tampil')
        ->with('type', 'Berhasil!')
        ->with('message', 'Pembelian berhasil ditambahkan')
        ->with('icon', 'success');
    }
}
