<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Obat;

class ObatController extends Controller
{
    public function index()
    {
        $obat = Obat::all();
        return view('admin.obat.index', compact('obat'));
    }

    public function create()
    {
        return view('admin.obat.create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'kode_obat'    => 'nullable|string|max:10|unique:obat,kode_obat',
            'nama_obat'    => 'required|string|max:255',
            'jenis_obat'   => 'nullable|string|in:Tablet,Kapsul,Sirup,Salep,Injeksi,Drop,Inhaler,Suppositoria',
            'harga_obat'   => 'required|numeric|min:0',
            'stok'         => 'required|integer|min:0',
            'expired_date' => 'nullable|date|after:today',
            'keterangan'   => 'nullable|string'
        ]);

        Obat::create($validatedData);

        return redirect()
            ->route('admin.obat.index')
            ->with('success', 'Obat berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $obat = Obat::findOrFail($id);
        return view('admin.obat.edit', compact('obat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_obat' => 'required',
            'harga_obat' => 'required|numeric',
            'stok' => 'required|integer'
        ]);

        $obat = Obat::findOrFail($id);
        $obat->update($request->all());

        return redirect()->route('admin.obat.index')->with('success', 'Obat berhasil diupdate.');
    }

    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();
        return redirect()->route('admin.obat.index')->with('success', 'Obat berhasil dihapus.');
    }
}
