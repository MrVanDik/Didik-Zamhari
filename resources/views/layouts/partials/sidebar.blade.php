<!-- resources/views/partials/sidebar-pendaftaran.blade.php -->
<div class="col-md-3 col-lg-2 d-md-block sidebar">
    <div class="position-sticky pt-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center justify-content-between bg-primary">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-bolt me-2"></i>Aksi Cepat
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('pendaftaran.dashboard') }}" class="btn btn-primary btn-block text-start">
                        <i class="fas fa-user-plus me-2"></i>Dashboard
                    </a>
                    <a href="{{ route('pendaftaran.pasien.create') }}" class="btn btn-primary btn-block text-start">
                        <i class="fas fa-user-plus me-2"></i>Pasien Baru
                    </a>
                    <a href="{{ route('pendaftaran.pendaftaran.create') }}" class="btn btn-success btn-block text-start">
                        <i class="fas fa-clipboard-list me-2"></i>Daftar Kunjungan
                    </a>
                    <a href="{{ route('pendaftaran.pendaftaran.index') }}" class="btn btn-info btn-block text-start">
                        <i class="fas fa-list me-2"></i>Daftar Antrian
                    </a>
                    <a href="{{ route('pendaftaran.pasien.index') }}" class="btn btn-warning btn-block text-start">
                        <i class="fas fa-users me-2"></i>Data Pasien
                    </a>
                    <hr>
                    <div class="text-center small text-muted">
                        Total Pasien: <strong>{{ $total_pasien ?? 0 }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .sidebar {
        background-color: #f8f9fa;
        min-height: 100vh;
        padding-right: 0;
    }

    .sidebar .card {
        border: none;
        box-shadow: 0 0.15rem 1.75rem rgba(58, 59, 69, 0.1);
    }

    .sidebar .btn-block {
        margin-bottom: 0.5rem;
        padding: 0.6rem 1rem;
    }

    .sidebar .btn i {
        width: 20px;
        text-align: center;
    }

    @media (max-width: 767.98px) {
        .sidebar {
            min-height: auto;
            position: relative;
            margin-bottom: 1rem;
        }
    }
</style>
@endpush
