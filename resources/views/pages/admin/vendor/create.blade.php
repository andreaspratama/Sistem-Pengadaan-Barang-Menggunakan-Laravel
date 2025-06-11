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
                    Form Tambah Vendor
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('vendor.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- 1. Biodata Perusahaan -->
                    <div>
                        <h4 class="text-lg font-semibold text-blue-600 mb-4">1. Biodata Perusahaan</h4>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="mb-3">
                                <label for="nama_perusahaan" class="block form-label">Nama Perusahaan</label>
                                <input type="text" name="nama_perusahaan" id="nama_perusahaan" class="mt-1 block w-full border rounded p-2 form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="kategori_id" class="block form-label">Kategori Bisnis</label>
                                <select class="form-select" aria-label="Default select example" name="kategori_id">
                                    <option selected>Kategori Perusahaan</option>
                                    @foreach ($kategoris as $ktg)
                                        <option value="{{$ktg->id}}">{{$ktg->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tahun_berdiri" class="block form-label">Tahun Berdiri</label>
                                <input type="number" name="tahun_berdiri" id="tahun_berdiri" class="mt-1 block w-full border rounded p-2 form-control">
                            </div>
                            <div class="mb-3">
                                <label for="no_telp" class="block form-label">Nomor Telepon</label>
                                <input type="text" name="no_telp" id="no_telp" class="mt-1 block w-full border rounded p-2 form-control">
                            </div>
                            <div class="mb-3">
                                <label for="ijin_usaha" class="block form-label">Nomor Izin Usaha</label>
                                <input type="text" name="ijin_usaha" id="ijin_usaha" class="mt-1 block w-full border rounded p-2 form-control">
                            </div>
                            <div class="mb-3">
                                <label for="npwp" class="block form-label">Nomor NPWP</label>
                                <input type="text" name="npwp" id="npwp" class="mt-1 block w-full border rounded p-2 form-control">
                            </div>
                            <div class="mb-3">
                                <label for="nik" class="block form-label">NIK</label>
                                <input type="text" name="nik" id="nik" class="mt-1 block w-full border rounded p-2 form-control">
                            </div>
                            <div class="mb-3">
                                <label for="mep" class="block form-label">Mechanical, Electrical, and Plumbing</label>
                                <input type="text" name="mep" id="mep" class="mt-1 block w-full border rounded p-2 form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat_perusahaan" class="block form-label">Alamat Perusahaan</label>
                            <textarea name="alamat_perusahaan" id="alamat_perusahaan" rows="3" class="mt-1 block w-full border rounded p-2 form-control"></textarea>
                        </div>
                    </div>

                    <!-- 2. Informasi Bank -->
                    <div>
                        <h4 class="text-lg font-semibold text-blue-600 mb-4">2. Informasi Bank Perusahaan</h4>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="mb-3">
                                <label for="nama_bank" class="block form-label">Nama Bank</label>
                                <input type="text" name="nama_bank" id="nama_bank" class="mt-1 block w-full border rounded p-2 form-control">
                            </div>
                            <div class="mb-3">
                                <label for="no_rek" class="block form-label">Nomor Rekening Bank</label>
                                <input type="text" name="no_rek" id="no_rek" class="mt-1 block w-full border rounded p-2 form-control">
                            </div>
                            <div class="mb-3">
                                <label for="atas_nama_bank" class="block form-label">Bank Atas Nama</label>
                                <input type="text" name="atas_nama_bank" id="atas_nama_bank" class="mt-1 block w-full border rounded p-2 form-control">
                            </div>
                            <div class="mb-3">
                                <label for="kode_bank" class="block form-label">Kode Bank (jika ada)</label>
                                <input type="text" name="kode_bank" id="kode_bank" class="mt-1 block w-full border rounded p-2 form-control">
                            </div>
                            <div class="col-span-2 mb-3">
                                <label for="alamat_bank" class="block form-label">Alamat Bank</label>
                                <input type="text" name="alamat_bank" id="alamat_bank" class="mt-1 block w-full border rounded p-2 form-control">
                            </div>
                        </div>
                    </div>

                    <!-- 3. Penanggung Jawab -->
                    <div>
                        <h3 class="text-lg font-semibold text-blue-600 mb-4">3. Penanggung Jawab</h3>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <h6 class="font-semibold mb-1">Kontak Utama Perusahaan</h6>
                                <label for="nama_kontak_utama" class="block text-sm form-label">Nama</label>
                                <input type="text" name="nama_kontak_utama" id="nama_kontak_utama" class="w-full border rounded p-2 mb-2 form-control">

                                <label for="posisi_kontak_utama" class="block text-sm form-label">Posisi</label>
                                <input type="text" name="posisi_kontak_utama" id="posisi_kontak_utama" class="w-full border rounded p-2 mb-2 form-control">

                                <label for="email_kontak_utama" class="block text-sm form-label">Email</label>
                                <input type="email" name="email_kontak_utama" id="email_kontak_utama" class="w-full border rounded p-2 mb-2 form-control">

                                <label for="hp_kontak_utama" class="block text-sm form-label">Mobile Phone</label>
                                <input type="text" name="hp_kontak_utama" id="hp_kontak_utama" class="w-full border rounded p-2 form-control mb-4">
                            </div>

                            <div>
                                <h6 class="font-semibold mb-1">Kontak Keuangan Perusahaan</h6>
                                <label for="nama_kontak_keuangan" class="block text-sm form-label">Nama</label>
                                <input type="text" name="nama_kontak_keuangan" id="nama_kontak_keuangan" class="w-full border rounded p-2 mb-2 form-control">

                                <label for="posisi_kontak_keuangan" class="block text-sm form-label">Posisi</label>
                                <input type="text" name="posisi_kontak_keuangan" id="posisi_kontak_keuangan" class="w-full border rounded p-2 mb-2 form-control">

                                <label for="email_kontak_keuangan" class="block text-sm form-label">Email</label>
                                <input type="email" name="email_kontak_keuangan" id="email_kontak_keuangan" class="w-full border rounded p-2 mb-2 form-control">

                                <label for="hp_kontak_keuangan" class="block text-sm form-label">Mobile Phone</label>
                                <input type="text" name="hp_kontak_keuangan" id="hp_kontak_keuangan" class="w-full border rounded p-2 form-control">
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="text-right pt-4">
                        <button type="submit" class="btn btn-primary">
                            Simpan Vendor
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
        new DataTable('#vendor');
    </script>
@endpush