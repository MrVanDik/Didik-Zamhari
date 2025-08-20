@extends('layouts.pendaftaran')

@section('title', 'Detail Pasien')

@section('content')

    <!-- Content -->
    <div class="flex-grow-1">
        

        <!-- Content -->
        <div class="content">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title mb-0"><i class="fas fa-users me-2"></i>Daftar Pasien</h5>
                        <a href="{{ route('pendaftaran.pasien.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Tambah Pasien
                        </a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pasien</th>
                                    <th>Usia</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Alamat</th>
                                    <th>Wilayah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pasien as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $p->nama_pasien }}</td>
                                    <td>{{ $p->usia ?? '-' }}</td>
                                    <td>{{ $p->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    <td>{{ $p->alamat }}</td>
                                    <td>{{ $p->wilayah->nama_wilayah ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('pendaftaran.pasien.edit', $p->id_pasien) }}" class="btn btn-sm btn-warning btn-action">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('pendaftaran.pasien.destroy', $p->id_pasien) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger btn-action" onclick="return confirm('Hapus pasien ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('pendaftaran.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                
            </div>

@endsection

