<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    function tampil(Request $request){
        if ($request->ajax()) {
            $kategori = Kategori::query();

            return DataTables::of($kategori)->make(true);
        }

        return view ('pages.kategori.index', ['type_menu' => 'data']);
    }

    function add(Request $request){
        $validator = Validator::make($request->all(), [
            'kategori' => 'required|string|max:100',  // Validasi untuk kategori
            'deskripsi' => 'nullable|string|max:500', // Validasi untuk deskripsi
        ], [
            'kategori.required' => 'Kategori tidak boleh kosong.',
            'kategori.string' => 'Kategori harus berupa teks.',
            'kategori.max' => 'Kategori maksimal 100 karakter.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('kategori.tampil')
                ->withErrors($validator)
                ->withInput()
                ->with('type', 'Gagal!!')
                ->with('message', 'Data kategori gagal ditambahkan')
                ->with('icon', 'error');
        }
    
        // Jika validasi berhasil, simpan data
        $kategori = new Kategori();
        $kategori->kategori = $request->kategori;
        $kategori->deskripsi = $request->deskripsi;
        $kategori->save();
    
        return redirect()->route('kategori.tampil')
        ->with('type', 'Berhasil!')
        ->with('message', 'Data kategori berhasil ditambahkan')
        ->with('icon', 'success');
    }

    function edit($id)
    {
        return view ('pages.kategori.edit', ['type_menu' => 'data', 'kategori' => Kategori::find($id)]);
    }

    function update(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), [
            'kategori' => 'required|string|max:100',  // Validasi untuk kategori
            'deskripsi' => 'nullable|string|max:500', // Validasi untuk deskripsi
        ], [
            'kategori.required' => 'Kategori tidak boleh kosong.',
            'kategori.string' => 'Kategori harus berupa teks.',
            'kategori.max' => 'Kategori maksimal 100 karakter.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('kategori.edit', ['id' => $id])
                ->withErrors($validator)
                ->withInput()
                ->with('type', 'Gagal!!')
                ->with('message', 'Data kategori gagal diupdate')
                ->with('icon', 'error');
        }

        $kategori = Kategori::find($id);
        $kategori->kategori = $request->kategori;
        $kategori->deskripsi = $request->deskripsi;
        $kategori->update();

        return redirect()->route('kategori.tampil')
        ->with('type', 'Berhasil!')
        ->with('message', 'Data kategori berhasil diupdate')
        ->with('icon', 'success');
    }

    
    function delete($id)
    {
        $kategori = Kategori::find($id);
        $kategori->delete();
        return redirect()->route('kategori.tampil')
        ->with('type', 'Berhasil!')
        ->with('message', 'Data kategori berhasil dihapus')
        ->with('icon', 'success');
    }
}
