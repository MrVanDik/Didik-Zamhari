<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tindakan;

class TindakanController extends Controller
{
    public function index()
    {
        $tindakan = Tindakan::all();
        return view('admin.tindakan.index', compact('tindakan'));
    }

    public function create()
    {
        return view('admin.tindakan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tindakan' => 'required',
            'biaya_tindakan' => 'required|numeric'
        ]);

        Tindakan::create($request->all());
        return redirect()->route('admin.tindakan.index')->with('success', 'Tindakan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tindakan = Tindakan::findOrFail($id);
        return view('admin.tindakan.edit', compact('tindakan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_tindakan' => 'required',
            'biaya_tindakan' => 'required|numeric'
        ]);

        $tindakan = Tindakan::findOrFail($id);
        $tindakan->update($request->all());

        return redirect()->route('admin.tindakan.index')->with('success', 'Tindakan berhasil diupdate.');
    }

    public function destroy($id)
    {
        $tindakan = Tindakan::findOrFail($id);
        $tindakan->delete();
        return redirect()->route('admin.tindakan.index')->with('success', 'Tindakan berhasil dihapus.');
    }
}
