<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    function tampil(Request $request){
        if ($request->ajax()) {
            $user = User::query();

            return DataTables::of($user)->make(true);
        }

        return view ('pages.pegawai.index', ['type_menu' => 'Pegawai']);
    }

    function add(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:255', // Ensure valid email format
            'password' => 'required|string|max:15', // Only digits
            'role' => 'required|string|in:admin,kasir', // Specify valid roles
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari :max karakter.',
            
            'email.required' => 'Email wajib diisi.',
            'email.string' => 'Email harus berupa teks.',
            'email.email' => 'Email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari :max karakter.',
            
            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.max' => 'Password tidak boleh lebih dari :max karakter.',
            
            'role.required' => 'Role wajib diisi.',
            'role.string' => 'Role harus berupa teks.',
            'role.in' => 'Role harus salah satu dari: admin, kasir.', // List valid roles
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('pegawai.tampil')
                ->withErrors($validator)
                ->withInput()
                ->with('type', 'Gagal!!')
                ->with('message', 'Data pegawai gagal ditambahkan')
                ->with('icon', 'error');
        }
    
        // Jika validasi berhasil, simpan data
        $user = new user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->save();
    
        return redirect()->route('pegawai.tampil')
        ->with('type', 'Berhasil!')
        ->with('message', 'Data pegawai berhasil ditambahkan')
        ->with('icon', 'success');
    }

    function edit($id)
    {
        return view ('pages.pegawai.edit', ['type_menu' => 'data','pegawai' => User::find($id)]);
        // return view ('obat.edit', ['type_menu' => 'data','obat' => Obat::find($id),  'kategori' => Kategori::all(), 'unit' => Unit::all(), 'pemasok' => Pemasok::all()]);
    }

    function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->id, // Ensure valid email format
            'password' => 'nullable|string', // Only digits
            'role' => 'required|string|in:admin,kasir', // Specify valid roles
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari :max karakter.',
            
            'email.required' => 'Email wajib diisi.',
            'email.string' => 'Email harus berupa teks.',
            'email.email' => 'Email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari :max karakter.',
            
            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.max' => 'Password tidak boleh lebih dari :max karakter.',
            
            'role.required' => 'Role wajib diisi.',
            'role.string' => 'Role harus berupa teks.',
            'role.in' => 'Role harus salah satu dari: admin, kasir.', // List valid roles
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('pegawai.edit', ['id' => $id])
                ->withErrors($validator)
                ->withInput()
                ->with('type', 'Gagal!!')
                ->with('message', 'Data pegawai gagal diubah')
                ->with('icon', 'error');
        }
    
        $user = User::find($request->id);

        if (!$user) {
            return redirect()->route('pegawai.tampil')
                ->with('type', 'Gagal!')
                ->with('message', 'Data pegawai tidak ditemukan')
                ->with('icon', 'error');
        }


        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
       
        if ($request->filled('password')) { 
            $user->password = bcrypt($request->password);
        }

        $user->save();
    
        return redirect()->route('pegawai.tampil')
        ->with('type', 'Berhasil!')
        ->with('message', 'Data pegawai berhasil diubah')
        ->with('icon', 'success');
    }

    function delete($id)
    {
        $pegawai = User::find($id);
        $pegawai->delete();
        return redirect()->route('pegawai.tampil')
        ->with('type', 'Berhasil!')
        ->with('message', 'Data pegawai berhasil dihapus')
        ->with('icon', 'success');
    }

}
