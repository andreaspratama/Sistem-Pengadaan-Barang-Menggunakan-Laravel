@extends('layouts.admin')

@section('title')
    Dashboard
@endsection

@section('content')
<div class="page-heading">
    <h3>Dashboard</h3>
</div> 
<div class="page-content"> 
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Form Tambah Unit
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('unit.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <div>
                        <div class="grid grid-cols-2 gap-6 mb-3">
                            <div class="">
                                <label for="nama" class="block form-label">Nama Unit</label>
                                <input type="text" name="nama" id="nama" class="mt-1 block w-full border rounded p-2 form-control" placeholder="Nama unit..." required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6 mb-3">
                            <div class="">
                                <label for="alamat" class="block form-label">Alamat Unit</label>
                                <input type="text" name="alamat" id="alamat" class="mt-1 block w-full border rounded p-2 form-control" placeholder="Alamat unit..." required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6 mb-3">
                            <div class="">
                                <label for="no_tlp" class="block form-label">No Telepon</label>
                                <input type="text" name="no_tlp" id="no_tlp" class="mt-1 block w-full border rounded p-2 form-control" placeholder="No Telp..." required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6 mb-3">
                            <div class="">
                                <label for="email" class="block form-label">Email</label>
                                <input type="text" name="email" id="email" class="mt-1 block w-full border rounded p-2 form-control" placeholder="Email..." required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="">
                                <label for="cp" class="block form-label">Contact Person</label>
                                <input type="text" name="cp" id="cp" class="mt-1 block w-full border rounded p-2 form-control" placeholder="Contact Person..." required>
                            </div>
                        </div>

                    <!-- Submit -->
                    <div class="text-right pt-4">
                        <button type="submit" class="btn btn-primary">
                            Simpan Unit
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </section>
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
        new DataTable('#kategori');
    </script>
@endpush