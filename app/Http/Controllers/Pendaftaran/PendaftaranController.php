<?php

namespace App\Http\Controllers\Pendaftaran;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PendaftaranController extends Controller
{
    public function index()
    {
        $pendaftaran = Pendaftaran::with(['pasien'])
            ->orderBy('status')
            ->orderBy('tgl_daftar', 'desc')
            ->paginate(10);

        return view('pendaftaran.pendaftaran.index', compact('pendaftaran'));
    }

    public function create()
    {
        $pasien = Pasien::orderBy('nama_pasien')->get();
        $lastReg = Pendaftaran::whereDate('tgl_daftar', today())->latest()->first();
        $noReg = 'REG-' . date('Ymd') . '-' . str_pad($lastReg ? substr($lastReg->no_reg, -4) + 1 : 1, 
    4, 
    '0', 
    STR_PAD_LEFT
);


         return view('pendaftaran.pendaftaran.create', compact('pasien', 'noReg'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pasien' => 'required|exists:pasien,id_pasien',
            'no_reg' => 'required|unique:pendaftaran,no_reg',
            'tgl_daftar' => 'required|date',
            'jenis_kunjungan' => 'required|in:baru,lama',
            'keluhan' => 'nullable|string',
        ]);

        // Ambil no_rm dari pasien
        $pasien = Pasien::find($request->id_pasien);

        Pendaftaran::create([
            'id_pasien' => $request->id_pasien,
            'no_reg' => $request->no_reg,
            'tgl_daftar' => $request->tgl_daftar,
            'jenis_kunjungan' => $request->jenis_kunjungan,
            'status' => 'antri',
            'keluhan' => $request->keluhan,
        ]);

        return redirect()->route('pendaftaran.pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil ditambahkan');
    }

    
    public function show($id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('pendaftaran.pasien.show', compact('pasien'));
    }

    public function edit($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pasien = Pasien::orderBy('nama_pasien')->get();

        return view('pendaftaran.pendaftaran.edit', compact('pendaftaran', 'pasien'));
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_pasien' => 'required|exists:pasien,id_pasien',
            'tgl_daftar' => 'required|date',
            'jenis_kunjungan' => 'required|in:baru,lama',
            'keluhan' => 'nullable|string',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update($request->all());

        return redirect()->route('pendaftaran.pendaftaran.index')
            ->with('success', 'Data pendaftaran berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->delete();

        return redirect()->route('pendaftaran.pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil dihapus');
    }
}