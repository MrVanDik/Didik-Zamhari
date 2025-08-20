<?php

namespace App\Http\Controllers\Pendaftaran;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index()
    {
        $pasien = Pasien::with('wilayah')->latest()->paginate(10);
        return view('pendaftaran.pasien.index', compact('pasien'));
    }

    public function create()
    {
        $wilayah = Wilayah::all();
        $lastId = Pasien::max('id_pasien') ?? 0;
        $nextId = $lastId + 1;
        
        return view('pendaftaran.pasien.create', compact('wilayah', 'nextId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pasien' => 'required|numeric|unique:pasien',
            'nama_pasien' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'jk' => 'required|in:L,P',
            'alamat' => 'required|string',
            'no_telp' => 'nullable|string|max:15',
            'id_wilayah' => 'required|exists:wilayah,id_wilayah'
        ]);

        Pasien::create($request->all());

        return redirect()->route('pendaftaran.pasien.index')
            ->with('success', 'Data pasien berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pasien = Pasien::findOrFail($id);
        $wilayah = Wilayah::orderBy('nama_wilayah')->get();
        return view('pendaftaran.pasien.edit', compact('pasien', 'wilayah'));
    }

    public function show($id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('pendaftaran.pasien.show', compact('pasien'));
    }

    public function update(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);

        $validated = $request->validate([
            'nama_pasien' => 'required|string|max:100',
            'tgl_lahir' => 'nullable|date',
            'jk' => 'required|in:L,P',
            'alamat' => 'nullable|string|max:255',
            'id_wilayah' => 'nullable|exists:wilayah,id_wilayah',
        ]);

        $pasien->update($validated);

        return redirect()->route('pendaftaran.pasien.index')
                         ->with('success', 'Data pasien berhasil diperbarui.');
    }


     public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();

        return redirect()->route('pendaftaran.pasien.index')
                         ->with('success', 'Pasien berhasil dihapus.');
    }
}