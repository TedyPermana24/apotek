<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\LogEntry;
use App\Models\Obat;
use App\Models\Penjualan;
use App\Models\PenjualanObat;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;



class PenjualanController extends Controller
{
    function tampil(){
        
        return view ('pages.penjualan.index', ['type_menu' => 'transaksi', 'obat' => Obat::with('kategoris')->get(), 'kategori' => Kategori::all(), 'invoice' => strtoupper(Str::random(8))]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'tanggal' => 'required|date',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
            'harga' => 'required|array',
            'harga.*' => 'required|numeric|min:0',
            'nama_obat' => 'required|array',
            'nama_obat.*' => 'required|exists:obats,id',
        ], [
            'nama.required' => 'Nama wajib diisi',
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
            return redirect()->route('penjualan.tampil')
                ->withErrors($validator)
                ->withInput()
                ->with('type', 'Gagal!!')
                ->with('message', 'Penjualan gagal')
                ->with('icon', 'error');
        }

        $totalHarga = 0;
        foreach ($request->jumlah as $index => $jumlah) {
            $totalHarga += $jumlah * $request->harga[$index];
        }

        DB::beginTransaction();
   
        $penjualan = Penjualan::create([
            'invoice' => $request->invoice,
            'nama' => $request->nama,
            'tanggal' => $request->tanggal,
            'total_harga' => $totalHarga,
        ]);

        foreach ($request->jumlah as $index => $jumlah) {
            PenjualanObat::create([
                'penjualan_id' => $penjualan->id,
                'obat_id' => $request->nama_obat[$index],
                'jumlah' => $jumlah,
                'harga' => $request->harga[$index],
            ]);

            $obat = Obat::find($request->nama_obat[$index]);
            $obat->stok -= $jumlah;
            $obat->save();
        }

            
        DB::commit();

        LogEntry::create([
            'username' => Auth::user()->name,
             'action' => 'created',
             'penjualan_id' => $penjualan->id,
             'details' => json_encode($request->all()),
         ]);
 

        return redirect()->route('detailpenjualan.tampil')
        ->with('type', 'Berhasil!')
        ->with('message', 'Penjualan berhasil ditambahkan')
        ->with('icon', 'success');
    }

    function edit($id){
        $penjualan = Penjualan::find($id);
        $obat = Obat::all();
        $penjualanObat = PenjualanObat::where('penjualan_id', $id)->get();
    
        return view('pages.penjualan.edit', ['type_menu' => 'transaksi'], compact('penjualan', 'penjualanObat', 'obat'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'tanggal' => 'required|date',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
            'harga' => 'required|array',
            'harga.*' => 'required|numeric|min:0',
            'nama_obat' => 'required|array',
            'nama_obat.*' => 'required|exists:obats,id',
        ], [
            'nama.required' => 'Nama wajib diisi',
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
            return redirect()->route('penjualan.edit', $id)
                ->withErrors($validator)
                ->withInput()
                ->with('type', 'Gagal!!')
                ->with('message', 'Penjualan gagal diupdate')
                ->with('icon', 'error');
        }
    
        $totalHarga = 0;
        foreach ($request->jumlah as $index => $jumlah) {
            $totalHarga += $jumlah * $request->harga[$index];
        }
    
        DB::beginTransaction();
            $penjualan = Penjualan::with('penjualanObat')->findOrFail($id);
            
            $penjualan->update([
                'nama' => $request->nama,
                'tanggal' => $request->tanggal,
                'total_harga' => $totalHarga,
            ]);
    
            // Hapus data penjualan obat yang lama jika ada
            if ($penjualan->penjualanObat) {
                foreach ($penjualan->penjualanObat as $item) {
                    $obat = Obat::find($item->obat_id);
                    $obat->stok += $item->jumlah;  // Kembalikan stok obat
                    $obat->save();
                    $item->delete();
                }
            }
    
            // Tambah data penjualan obat yang baru
            foreach ($request->jumlah as $index => $jumlah) {
                PenjualanObat::create([
                    'penjualan_id' => $penjualan->id,
                    'obat_id' => $request->nama_obat[$index],
                    'jumlah' => $jumlah,
                    'harga' => $request->harga[$index],
                ]);
    
                // Kurangi stok obat
                $obat = Obat::find($request->nama_obat[$index]);
                $obat->stok -= $jumlah;
                $obat->save();
            }
    
            DB::commit();
            
            LogEntry::create([
                'username' => Auth::user()->name,
                 'action' => 'updated',
                 'penjualan_id' => $penjualan->id,
                 'details' => json_encode($request->all()),
             ]);
    
            return redirect()->route('detailpenjualan.tampil')
                ->with('type', 'Berhasil!')
                ->with('message', 'Penjualan berhasil diupdate')
                ->with('icon', 'success');
        
    }
    
    


    function delete($id){
        try {
            $penjualanObat = PenjualanObat::where('penjualan_id', $id)->get();
        
        
            foreach ($penjualanObat as $jual) {
                // Assuming you have a model for Obat and a 'stok' field for the stock quantity
                $obat = Obat::find($jual->obat_id); // Mengambil obat berdasarkan obat_id di tabel penjualan_obat
        
                if ($obat) {
                    $obat->stok += $jual->jumlah; 
                    $obat->save(); 
                }
            }
    
            PenjualanObat::where('penjualan_id', $id)->delete();
            
    
            $penjualan = Penjualan::find($id);
            $penjualan->delete();

            LogEntry::create([
                'username' => Auth::user()->name,
                 'action' => 'deleted',
                 'penjualan_id' => $penjualan->id,
                 'details' => 'Menghapus penjualan dengan ID: ' . $penjualan->id,
             ]);
            
             return redirect()->route('detailpenjualan.tampil')
            ->with('type', 'Berhasil!')
            ->with('message', 'Data penjualan berhasil dihapus')
            ->with('icon', 'success');
        }catch (QueryException $e) {
            if ($e->getCode() === '23000') { 
                return back()  
                ->with('type', 'Gagal!')
                ->with('message', 'Data penjualan gagal dihapus pelanggaran constraint')
                ->with('icon', 'error');
            }
            return back()->withErrors('Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        } catch (Exception $e) {
            return back()
            >with('type', 'Gagal!')
            ->with('message', $e->getMessage())
            ->with('icon', 'error');
        }
    }
}
