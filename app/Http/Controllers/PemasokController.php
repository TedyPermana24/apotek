<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemasok;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\QueryException;
use Exception;

class PemasokController extends Controller
{
    function tampil(Request $request){
        if ($request->ajax()) {
            $pemasok = Pemasok::query();

            return DataTables::of($pemasok)->make(true);
        }

        return view ('pages.pemasok.index', ['type_menu' => 'data']);
    }

    function add(Request $request){
        $validator = Validator::make($request->all(), [
            'pemasok' => 'required|string|max:100',  
            'alamat' => 'required|string|max:255', 
            'telepon' => 'required|string|max:15|regex:/^[0-9]+$/',
            'deskripsi' => 'nullable|string|max:500',
        ], [
            'pemasok.required' => 'Pemasok tidak boleh kosong.',
            'pemasok.string' => 'Pemasok harus berupa teks.',
            'pemasok.max' => 'Pemasok maksimal 100 karakter.',
            'alamat.required' => 'Alamat tidak boleh kosong.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'alamat.max' => 'Alamat maksimal 255 karakter.',
            'telepon.required' => 'No Telepon tidak boleh kosong.',
            'telepon.string' => 'No Telepon harus berupa teks.',
            'telepon.max' => 'No Telepon maksimal 15 karakter.',
            'telepon.regex' => 'No Telepon hanya boleh berisi angka.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('pemasok.tampil')
                ->withErrors($validator)
                ->withInput()
                ->with('type', 'Gagal!!')
                ->with('message', 'Data Pemasok gagal ditambahkan')
                ->with('icon', 'error');
        }
    
        // Jika validasi berhasil, simpan data
        $pemasok = new Pemasok();
        $pemasok->pemasok = $request->pemasok;
        $pemasok->alamat = $request->alamat;
        $pemasok->telepon = $request->telepon;
        $pemasok->deskripsi = $request->deskripsi;
        $pemasok->save();
    
        return redirect()->route('pemasok.tampil')
        ->with('type', 'Berhasil!')
        ->with('message', 'Data Pemasok berhasil ditambahkan')
        ->with('icon', 'success');
    }

    function edit($id)
    {
        return view ('pages.pemasok.edit', ['type_menu' => 'data', 'pemasok' => Pemasok::find($id)]);
    }

    function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pemasok' => 'required|string|max:100',  
            'alamat' => 'required|string|max:255', 
            'telepon' => 'required|string|max:15|regex:/^[0-9]+$/',
            'deskripsi' => 'nullable|string|max:500',
        ], [
            'pemasok.required' => 'Pemasok tidak boleh kosong.',
            'pemasok.string' => 'Pemasok harus berupa teks.',
            'pemasok.max' => 'Pemasok maksimal 100 karakter.',
            'alamat.required' => 'Alamat tidak boleh kosong.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'alamat.max' => 'Alamat maksimal 255 karakter.',
            'telepon.required' => 'No Telepon tidak boleh kosong.',
            'telepon.string' => 'No Telepon harus berupa teks.',
            'telepon.max' => 'No Telepon maksimal 15 karakter.',
            'telepon.regex' => 'No Telepon hanya boleh berisi angka.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('pemasok.edit', ['id' => $id])
                ->withErrors($validator)
                ->withInput()
                ->with('type', 'Gagal!!')
                ->with('message', 'Data Pemasok gagal diupdate')
                ->with('icon', 'error');
        }

        $pemasok = Pemasok::find($id);
        $pemasok->pemasok = $request->pemasok;
        $pemasok->alamat = $request->alamat;
        $pemasok->telepon = $request->telepon;
        $pemasok->deskripsi = $request->deskripsi;
        $pemasok->update();

        return redirect()->route('pemasok.tampil')
        ->with('type', 'Berhasil!')
        ->with('message', 'Data Pemasok berhasil diupdate')
        ->with('icon', 'success');
    }

    
    function delete($id)
    {

        try {
            $pemasok = Pemasok::find($id);
            $pemasok->delete();
            return redirect()->route('pemasok.tampil')
            ->with('type', 'Berhasil!')
            ->with('message', 'Data Pemasok berhasil dihapus')
            ->with('icon', 'success');
        }catch (QueryException $e) {
            if ($e->getCode() === '23000') { // Error code 23000 terkait constraint
                return back()  
                ->with('type', 'Gagal!')
                ->with('message', 'Data pemasok gagal dihapus pelanggaran constraint')
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
