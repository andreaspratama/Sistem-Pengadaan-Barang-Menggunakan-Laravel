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
                    Detail Vendor
                </h5>
            </div>
            <div class="card-body">

                <!-- 1. Biodata Perusahaan -->
                <div>
                    <h3 class="text-xl font-semibold text-blue-600 mb-4">1. Biodata Perusahaan</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm text-gray-700 mb-5">
                        <div><strong>Nama Perusahaan:</strong> {{ $vendor->nama_perusahaan }}</div>
                        <div><strong>Tahun Berdiri:</strong> {{ $vendor->tahun_berdiri }}</div>
                        <div><strong>Kategori Bisnis:</strong> {{ $vendor->kategori_bisnis }}</div>
                        <div class="col-span-2"><strong>Alamat:</strong> {{ $vendor->alamat_perusahaan }}</div>
                        <div><strong>Telepon:</strong> {{ $vendor->no_telp }}</div>
                        <div><strong>Izin Usaha:</strong> {{ $vendor->ijin_usaha }}</div>
                        <div><strong>NPWP:</strong> {{ $vendor->npwp }}</div>
                        <div><strong>NIK:</strong> {{ $vendor->nik }}</div>
                    </div>
                </div>

                <!-- 2. Informasi Bank -->
                <div>
                    <h3 class="text-xl font-semibold text-blue-600 mb-4">2. Informasi Bank</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm text-gray-700 mb-5">
                        <div><strong>Nama Bank:</strong> {{ $vendor->nama_bank }}</div>
                        <div><strong>No. Rekening:</strong> {{ $vendor->no_rek }}</div>
                        <div><strong>Bank Atas Nama:</strong> {{ $vendor->atas_nama_bank }}</div>
                        <div class="col-span-2"><strong>Alamat Bank:</strong> {{ $vendor->alamat_bank }}</div>
                        <div><strong>Kode Bank:</strong> {{ $vendor->kode_bank }}</div>
                    </div>
                </div>

                <!-- 3. Penanggung Jawab -->
                <div>
                    <h3 class="text-xl font-semibold text-blue-600 mb-4">3. Penanggung Jawab</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-700">
                        <!-- Kontak Utama -->
                        <div class="bg-gray-50 border p-4 rounded">
                            <h4 class="font-medium text-gray-800 mb-2">Kontak Utama</h4>
                            <p><strong>Nama:</strong> {{ $vendor->nama_kontak_utama }}</p>
                            <p><strong>Posisi:</strong> {{ $vendor->posisi_kontak_utama }}</p>
                            <p><strong>Email:</strong> {{ $vendor->email_kontak_utama }}</p>
                            <p><strong>HP:</strong> {{ $vendor->hp_kontak_utama }}</p>
                        </div>
                        <!-- Kontak Keuangan -->
                        <div class="bg-gray-50 border p-4 rounded">
                            <h4 class="font-medium text-gray-800 mb-2">Kontak Keuangan</h4>
                            <p><strong>Nama:</strong> {{ $vendor->nama_kontak_keuangan }}</p>
                            <p><strong>Posisi:</strong> {{ $vendor->posisi_kontak_keuangan }}</p>
                            <p><strong>Email:</strong> {{ $vendor->email_kontak_keuangan }}</p>
                            <p><strong>HP:</strong> {{ $vendor->hp_kontak_keuangan }}</p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-sm text-gray-500 mt-8 flex justify-between items-center border-t pt-4">
                    <div>
                        <p>Dibuat: {{ $vendor->created_at->format('d M Y H:i') }}</p>
                        <p>Diupdate: {{ $vendor->updated_at->format('d M Y H:i') }}</p>
                    </div>
                    <a href="{{ route('vendor.index') }}" class="text-blue-600 hover:underline font-medium">← Kembali ke daftar</a>
                </div>
            </div>
        </div>

    </section>
</div>
@endsection

@push('prepend-style')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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