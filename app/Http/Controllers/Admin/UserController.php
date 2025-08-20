<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        
        $pegawai = Pegawai::whereDoesntHave('user')->get();
        return view('admin.user.create', compact('pegawai'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required|exists:pegawai,id_pegawai',
            'id_role' => 'required|integer',
        ]);

        $pegawai = Pegawai::findOrFail($request->id_pegawai);

        User::create([
            'id_pegawai' => $pegawai->id_pegawai,
            'name' => $pegawai->nama_pegawai,
            'email' => $pegawai->email,
            'password' => Hash::make('password123'), 
            'id_role' => $request->id_role,
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'password' => 'nullable|min:6|confirmed',
            'id_role' => 'required|integer',
        ]);

        $user->id_role = $request->id_role;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus.');
    }
}
