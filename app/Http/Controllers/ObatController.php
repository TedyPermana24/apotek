<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Obat;
use App\Models\Kategori;
use App\Models\Unit;
use App\Models\Pemasok;
use DataTables;


class ObatController extends Controller
{
    function tampil(Request $request){
        $obat = Obat::get();
        $kategori = Kategori::get();
        $unit = Unit::get();
        $pemasok = Pemasok::get();
        if ($request->ajax()) {
            $obats = Obat::with(['kategoris', 'units', 'pemasoks'])->select('obats.*');

                return DataTables::of($obats)
                    ->addColumn('kategori_id', function ($obat) {
                        return $obat->kategoris ? $obat->kategoris->kategori : 'N/A'; // Get category name
                    })
                    ->addColumn('unit_id', function ($obat) {
                        return $obat->units ? $obat->units->nama_unit : 'N/A'; // Get unit name
                    })
                    ->addColumn('pemasok_id', function ($obat) {
                        return $obat->pemasoks ? $obat->pemasoks->nama_pemasok : 'N/A'; // Get supplier name
                    })
                    ->make(true);
        }
        return view ('obat.index', ['type_menu' => 'obat'], compact('obat', 'kategori', 'unit', 'pemasok'));
        // return view ('obat.index', ['type_menu' => 'obat'], compact('data', 'kategori', 'unit', 'pemasok'));
    }

    function add(Request $request){

        $validator = Validator::make($request->all(), [
            'nama_obat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'unit_id' => 'required|exists:units,id',
            'stok' => 'required|integer|min:0',
            'kadaluwarsa' => 'required|date',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'pemasok_id' => 'required|exists:pemasoks,id'
        ], [
            'nama_obat.required' => 'Nama obat tidak boleh kosong.',
            'kategori_id.required' => 'Kategori obat harus dipilih.',
            'unit_id.required' => 'Unit obat harus dipilih.',
            'stok.required' => 'Stok tidak boleh kosong.',
            'kadaluwarsa.required' => 'Tanggal kadaluwarsa tidak boleh kosong.',
            'harga_beli.required' => 'Harga beli tidak boleh kosong.',
            'harga_jual.required' => 'Harga jual tidak boleh kosong.',
            'pemasok_id.required' => 'Pemasok harus dipilih.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('obat.tampil')
                ->withErrors($validator)
                ->withInput()
                ->with('type', 'Gagal!!')
                ->with('message', 'Data obat gagal ditambahkan')
                ->with('icon', 'error');
        }
    
        // Jika validasi berhasil, simpan data
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
    
        return redirect()->route('obat.tampil')
        ->with('type', 'Berhasil!')
        ->with('message', 'Data obat berhasil ditambahkan')
        ->with('icon', 'success');
    
    }

    function edit($id)
    {
        $obat = Obat::find($id);
        $kategori = Kategori::get();
        $unit = Unit::get();
        $pemasok = Pemasok::get();
        return view ('obat.edit', ['type_menu' => 'obat'], compact('obat', 'kategori', 'unit', 'pemasok'));
    }

    function update(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), [
            'nama_obat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'unit_id' => 'required|exists:units,id',
            'stok' => 'required|integer|min:0',
            'kadaluwarsa' => 'required|date',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'pemasok_id' => 'required|exists:pemasoks,id'
        ], [
            'nama_obat.required' => 'Nama obat tidak boleh kosong.',
            'kategori_id.required' => 'Kategori obat harus dipilih.',
            'unit_id.required' => 'Unit obat harus dipilih.',
            'stok.required' => 'Stok tidak boleh kosong.',
            'kadaluwarsa.required' => 'Tanggal kadaluwarsa tidak boleh kosong.',
            'harga_beli.required' => 'Harga beli tidak boleh kosong.',
            'harga_jual.required' => 'Harga jual tidak boleh kosong.',
            'pemasok_id.required' => 'Pemasok harus dipilih.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('obat.edit', ['id' => $id])
                ->withErrors($validator)
                ->withInput()
                ->with('type', 'Gagal!!')
                ->with('message', 'Data obat gagal diupdate')
                ->with('icon', 'error');
        }

        $obat = Obat::find($id);
        $obat->nama_obat = $request->nama_obat;
        $obat->kategori_id = $request->kategori_id;
        $obat->unit_id = $request->unit_id;
        $obat->stok = $request->stok;
        $obat->kadaluwarsa = $request->kadaluwarsa;
        $obat->harga_beli = $request->harga_beli;
        $obat->harga_jual = $request->harga_jual;
        $obat->pemasok_id = $request->pemasok_id;
        $obat->update();

        return redirect()->route('obat.tampil')
        ->with('type', 'Berhasil!')
        ->with('message', 'Data obat berhasil diupdate')
        ->with('icon', 'success');
    }

    function delete($id)
    {
        $obat = Obat::find($id);
        $obat->delete();
        return redirect()->route('obat.tampil')
        ->with('type', 'Berhasil!')
        ->with('message', 'Data obat berhasil dihapus')
        ->with('icon', 'success');
    }
}
