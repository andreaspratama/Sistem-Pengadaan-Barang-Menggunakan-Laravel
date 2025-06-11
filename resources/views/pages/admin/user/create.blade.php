@extends('layouts.admin')

@section('title')
    Dashboard
@endsection

@section('content')
<div class="container mt-5">
    <div class="card border-0 shadow rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h4 class="mb-0">👤 Tambah User Baru</h4>
        </div>
        <div class="card-body p-5">
            <form action="{{ route('user.store') }}" method="POST">
                @csrf

                {{-- Nama --}}
                <div class="mb-4">
                    <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama user" required>
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="user@email.com" required>
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Minimal 8 karakter" required>
                </div>

                {{-- Role --}}
                <div class="mb-4">
                    <label for="role" class="form-label fw-semibold">Role</label>
                    <select name="role" id="role" class="form-select" required>
                        <option disabled selected>-- Pilih Role --</option>
                        <option value="Director">Direktur</option>
                        <option value="Finance">Finance</option>
                        <option value="Procurement">Procurement</option>
                        <option value="Staff Procurement">Staff Procurement</option>
                        <option value="Kepala Sekolah">Kepala Sekolah</option>
                        <option value="Admin Keu">Admin Keuangan</option>
                        <option value="Checker">Checker</option>
                        <option value="Kabid">Kabid</option>
                    </select>
                </div>

                {{-- Unit --}}
                <div class="mb-4">
                    <label for="unit" class="form-label fw-semibold">Unit</label>
                    <select name="unit" id="unit" class="form-select">
                        <option disabled selected>-- Pilih Unit --</option>
                        <option value="Manajemen">Manajemen</option>
                        <option value="Pre School Gajahmada">Pre School Gajahmada</option>
                        <option value="Pre School Tanah Mas">Pre School Tanah Mas</option>
                        <option value="Elementary">Elementary</option>
                        <option value="Junior High School">Junior High School</option>
                        <option value="Senior High School">Senior High School</option>
                    </select>
                </div>

                {{-- Tombol --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-success px-4 py-2 shadow rounded-3">
                        💾 Simpan User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('prepend-style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.bootstrap5.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

@endpush

@push('addon-script')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.bootstrap5.js"></script>
    <script>
        new DataTable('#kategori');
    </script>
@endpush