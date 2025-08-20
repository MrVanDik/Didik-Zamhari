@extends('layouts.pendaftaran')

@section('title', 'Data Pendaftaran')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Pendaftaran Pasien</h6>
        <a href="{{ route('pendaftaran.pendaftaran.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Pendaftaran
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>No. Reg</th>
                        <th>Nama Pasien</th>
                        <th>Tgl Daftar</th>
                        <th>Jenis</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftaran as $item)
                    <tr>
                        <td>{{ $item->no_reg }}</td>
                        <td>{{ $item->pasien->nama_pasien }}</td>
                        <td>{{ $item->tgl_daftar->format('d/m/Y H:i') }}</td>
                        <td>{{ $item->jenis_kunjungan_lengkap }}</td>
                        
                        <td>
                            <a href="{{ route('pendaftaran.pendaftaran.edit', $item->id_daftar) }}" 
                               class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('pendaftaran.pendaftaran.destroy', $item->id_daftar) }}" 
                                  method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Hapus data ini?')" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $pendaftaran->links() }}
        </div>

        <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('pendaftaran.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                
            </div>


    </div>
</div>
@endsection