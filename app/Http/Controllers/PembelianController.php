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
use Illuminate\Database\QueryException;
use Exception;


class PembelianController extends Controller
{
    function tampil(){
        
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

    function edit($id){
        $pembelian = Pembelian::find($id);
        $obat = Obat::all();
        $pemasok = Pemasok::all();
        $pembelianObat = PembelianObat::where('pembelian_id', $id)->get();
    
        return view('pages.pembelian.edit', ['type_menu' => 'transaksi'], compact('pembelian', 'pembelianObat', 'obat', 'pemasok'));
    }
    
    public function update(Request $request, $id)
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
            return redirect()->route('pembelian.edit', $id)
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
    
            $pembelian = Pembelian::with('pembelianObat')->findOrFail($id);
            
            $pembelian->update([
                'tanggal' => $request->tanggal,
                'pemasok_id' => $request->pemasok_id,
                'total_harga' => $totalHarga,
            ]);
    
          
            if ($pembelian->pembelianObat) {
                foreach ($pembelian->pembelianObat as $item) {
                    $obat = Obat::find($item->obat_id);
                    $obat->stok -= $item->jumlah;  
                    $obat->save();
                    $item->delete();
                }
            }
    
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
                ->with('message', 'Pembelian berhasil diupdate')
                ->with('icon', 'success');
        
    }


    function delete($id){
        try {
            $pembelianobat = PembelianObat::where('pembelian_id', $id)->get();
        
        
            foreach ($pembelianobat as $jual) {
                // Assuming you have a model for Obat and a 'stok' field for the stock quantity
                $obat = Obat::find($jual->obat_id); // Mengambil obat berdasarkan obat_id di tabel penjualan_obat
        
                if ($obat) {
                    // Menambahkan stok obat sesuai jumlah yang dijual
                    $obat->stok -= $jual->jumlah; // 'jumlah' merupakan jumlah pembelian dalam penjualan_obat
                    $obat->save(); // Menyimpan stok terbaru ke database
                }
            }
    
            PembelianObat::where('pembelian_id', $id)->delete();
            
    
            $pembelian = Pembelian::find($id);
            $pembelian->delete();
            
             return redirect()->route('detailpembelian.tampil')
            ->with('type', 'Berhasil!')
            ->with('message', 'Data pembelian berhasil dihapus')
            ->with('icon', 'success');
        }catch (QueryException $e) {
            if ($e->getCode() === '23000') { // Error code 23000 terkait constraint
                return back()  
                ->with('type', 'Gagal!')
                ->with('message', 'Data pembelian gagal dihapus pelanggaran constraint')
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
