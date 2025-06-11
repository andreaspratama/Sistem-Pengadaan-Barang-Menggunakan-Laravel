@extends('layouts.admin')

@section('title')
    Dashboard
@endsection

@section('content')
<div class="container mt-5">
    <div class="card border-0 shadow rounded-4">
        <div class="card-header bg-warning text-dark rounded-top-4">
            <h4 class="mb-0">✏️ Edit User</h4>
        </div>
        <div class="card-body p-5">
            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Password (Kosongkan jika tidak diganti)</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
                </div>

                {{-- Role --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Role</label>
                    <select name="role" class="form-select" required>
                        <option disabled>-- Pilih Role --</option>
                        @foreach(['Director', 'Finance', 'Procurement', 'Staff Procurement', 'Kepala Sekolah', 'Checker', 'Kabid'] as $role)
                            <option value="{{ $role }}" {{ $user->role === $role ? 'selected' : '' }}>{{ $role }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Unit --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Unit</label>
                    <select name="unit" class="form-select">
                        <option value="" disabled {{ $user->unit == null ? 'selected' : '' }}>-- Pilih Unit --</option>
                        @foreach(['Manajemen', 'Pre School Gajahmada', 'Pre School Tanah Mas', 'Elementary', 'Junior High School', 'Senior High School'] as $unit)
                            <option value="{{ $unit }}" {{ $user->unit === $unit ? 'selected' : '' }}>{{ $unit }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tombol --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-warning px-4 py-2 shadow rounded-3">
                        💾 Update User
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
@endpush

@push('addon-script')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.bootstrap5.js"></script>
    <script>
        new DataTable('#vendor');
    </script>
@endpush