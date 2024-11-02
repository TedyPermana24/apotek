<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UnitController extends Controller
{
    function tampil(Request $request){
        if ($request->ajax()) {
            $unit = Unit::query();

            return DataTables::of($unit)->make(true);
        }

        return view ('pages.unit.index', ['type_menu' => 'data']);
    }

    function add(Request $request){
        $validator = Validator::make($request->all(), [
            'unit' => 'required|string|max:100',  // Validasi untuk unit
            'deskripsi' => 'nullable|string|max:500', // Validasi untuk deskripsi
        ], [
            'unit.required' => 'Unit tidak boleh kosong.',
            'unit.string' => 'Unit harus berupa teks.',
            'unit.max' => 'Unit maksimal 100 karakter.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('unit.tampil')
                ->withErrors($validator)
                ->withInput()
                ->with('type', 'Gagal!!')
                ->with('message', 'Data unit gagal ditambahkan')
                ->with('icon', 'error');
        }
    
        // Jika validasi berhasil, simpan data
        $unit = new Unit();
        $unit->unit = $request->unit;
        $unit->deskripsi = $request->deskripsi;
        $unit->save();
    
        return redirect()->route('unit.tampil')
        ->with('type', 'Berhasil!')
        ->with('message', 'Data unit berhasil ditambahkan')
        ->with('icon', 'success');
    }

    function edit($id)
    {
        return view ('pages.kategori.edit', ['type_menu' => 'data', 'unit' => Unit::find($id)]);
    }

    function update(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), [
            'unit' => 'required|string|max:100',  // Validasi untuk kategori
            'deskripsi' => 'nullable|string|max:500', // Validasi untuk deskripsi
        ], [
            'unit.required' => 'unit tidak boleh kosong.',
            'unit.string' => 'unit harus berupa teks.',
            'unit.max' => 'unit maksimal 100 karakter.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('unit.edit', ['id' => $id])
                ->withErrors($validator)
                ->withInput()
                ->with('type', 'Gagal!!')
                ->with('message', 'Data unit gagal diupdate')
                ->with('icon', 'error');
        }

        $unit = Unit::find($id);
        $unit->unit = $request->unit;
        $unit->deskripsi = $request->deskripsi;
        $unit->update();

        return redirect()->route('unit.tampil')
        ->with('type', 'Berhasil!')
        ->with('message', 'Data kategori berhasil diupdate')
        ->with('icon', 'success');
    }

    
    function delete($id)
    {
        $unit = Unit::find($id);
        $unit->delete();
        return redirect()->route('unit.tampil')
        ->with('type', 'Berhasil!')
        ->with('message', 'Data unit berhasil dihapus')
        ->with('icon', 'success');
    }
}
