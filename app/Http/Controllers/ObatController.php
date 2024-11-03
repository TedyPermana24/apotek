<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Obat;
use App\Models\Kategori;
use App\Models\Unit;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\QueryException;
use Exception;


class ObatController extends Controller
{
    function tampil(Request $request){
        if ($request->ajax()) {
            $obats = Obat::with(['kategoris', 'units'])->select('obats.*');

                return DataTables::of($obats)
                    ->addColumn('kategori_id', function ($obat) {
                        return $obat->kategoris ? $obat->kategoris->kategori : 'N/A'; // Get category name
                    })
                    ->addColumn('unit_id', function ($obat) {
                        return $obat->units ? $obat->units->unit : 'N/A'; // Get unit name
                    })
                    // ->addColumn('pemasok_id', function ($obat) {
                    //     return $obat->pemasoks ? $obat->pemasoks->pemasok : 'N/A'; // Get supplier name
                    // })
                    ->make(true);
        }
        return view ('pages.obat.index', ['type_menu' => 'data', 'kategori' => Kategori::all(), 'unit' => Unit::all()]);
        // return view ('obat.index', ['type_menu' => 'data', 'obat' => Obat::all(), 'kategori' => Kategori::all(), 'unit' => Unit::all(), 'pemasok' => Pemasok::all()]);
        // return view ('obat.index', ['type_menu' => 'obat'], compact('data', 'kategori', 'unit', 'pemasok'));
    }

    function add(Request $request){

        $validator = Validator::make($request->all(), [
            'nama_obat' => 'required|string|max:255',
            // 'kategori_id' => 'required|exists:kategoris,id',
            // 'unit_id' => 'required|exists:units,id',
            // 'stok' => 'required|integer|min:0',
            'kadaluwarsa' => 'required|date',
            // 'harga_beli' => 'required|numeric|min:0',
            // 'harga_jual' => 'required|numeric|min:0',
            'indikasi' => 'nullable|string|max:500',
            // 'pemasok_id' => 'required|exists:pemasoks,id'
        ], [
            'nama_obat.required' => 'Nama obat tidak boleh kosong.',
            // 'kategori_id.required' => 'Kategori obat harus dipilih.',
            // 'unit_id.required' => 'Unit obat harus dipilih.',
            // 'stok.required' => 'Stok tidak boleh kosong.',
            'kadaluwarsa.required' => 'Tanggal kadaluwarsa tidak boleh kosong.',
            // 'harga_beli.required' => 'Harga beli tidak boleh kosong.',
            // 'harga_jual.required' => 'Harga jual tidak boleh kosong.',
            'indikasi.string' => 'Indikasi harus berupa teks.',
            'indikasi.max' => 'Indikasi maksimal 500 karakter.',
            // 'pemasok_id.required' => 'Pemasok harus dipilih.',
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
        $obat->stok = 0;
        $obat->kadaluwarsa = $request->kadaluwarsa;
        $obat->harga_beli = 0;
        $obat->harga_jual = 0;
        $obat->indikasi = $request->indikasi;
        // $obat->pemasok_id = $request->pemasok_id;
        $obat->save();
    
        return redirect()->route('obat.tampil')
        ->with('type', 'Berhasil!')
        ->with('message', 'Data obat berhasil ditambahkan')
        ->with('icon', 'success');
    
    }

    function edit($id)
    {
        return view ('pages.obat.edit', ['type_menu' => 'data','obat' => Obat::find($id),  'kategori' => Kategori::all(), 'unit' => Unit::all()]);
        // return view ('obat.edit', ['type_menu' => 'data','obat' => Obat::find($id),  'kategori' => Kategori::all(), 'unit' => Unit::all(), 'pemasok' => Pemasok::all()]);
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
            'indikasi' => 'nullable|string|max:500',
            // 'pemasok_id' => 'required|exists:pemasoks,id'
        ], [
            'nama_obat.required' => 'Nama obat tidak boleh kosong.',
            'kategori_id.required' => 'Kategori obat harus dipilih.',
            'unit_id.required' => 'Unit obat harus dipilih.',
            'stok.required' => 'Stok tidak boleh kosong.',
            'kadaluwarsa.required' => 'Tanggal kadaluwarsa tidak boleh kosong.',
            'harga_beli.required' => 'Harga beli tidak boleh kosong.',
            'harga_jual.required' => 'Harga jual tidak boleh kosong.',
            'indikasi.string' => 'Indikasi harus berupa teks.',
            'indikasi.max' => 'Indikasi maksimal 500 karakter.',
            // 'pemasok_id.required' => 'Pemasok harus dipilih.',
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
        $obat->indikasi = $request->indikasi;
        // $obat->pemasok_id = $request->pemasok_id;
        $obat->update();

        return redirect()->route('obat.tampil')
        ->with('type', 'Berhasil!')
        ->with('message', 'Data obat berhasil diupdate')
        ->with('icon', 'success');
    }

    function delete($id)
    {
        try {
            $obat = Obat::find($id);
            $obat->delete();
            return redirect()->route('obat.tampil')
            ->with('type', 'Berhasil!')
            ->with('message', 'Data obat berhasil dihapus')
            ->with('icon', 'success');
        }catch (QueryException $e) {
            if ($e->getCode() === '23000') { // Error code 23000 terkait constraint
                return back()  
                ->with('type', 'Gagal!')
                ->with('message', 'Data obat gagal dihapus pelanggaran constraint')
                ->with('icon', 'error');
            }
            return back()->withErrors('Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        } catch (Exception $e) {
            // Menangani error umum lainnya
            return back()
            >with('type', 'Gagal!')
            ->with('message', $e->getMessage())
            ->with('icon', 'error');
        }
    }
}
