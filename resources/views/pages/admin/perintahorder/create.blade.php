@extends('layouts.admin')

@section('title')
    Dashboard
@endsection

@section('content')
<div class="container my-4">
    <div class="card shadow rounded">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">📝 Input Perintah Order</h5>
        </div>
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Ups! Ada kesalahan input:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('perintahorder.store') }}" method="POST">
                @csrf

                <div class="row mb-3 mt-3">
                    <div class="col-md-6">
                        <label for="pengadaan_id" class="form-label">Pilih Pengadaan</label>
                        <select id="pengadaan_id" name="pengadaan_id" class="form-select">
                            <option value="">-- Pilih Pengadaan --</option>
                            @foreach($pengadaans as $pengadaan)
                                <option value="{{ $pengadaan->id }}">
                                    Pengadaan #{{ $pengadaan->id }} - {{ $pengadaan->keterangan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="vendor_id" class="form-label">Pilih Vendor</label>
                        <select id="vendor_id" name="vendor_id" class="form-select">
                            <option value="">-- Pilih Vendor --</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4" id="barang-list">
                    <!-- Barang akan ditampilkan di sini setelah vendor dipilih -->
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="no_surat" class="form-label">No Surat</label>
                        <input type="text" name="no_surat" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="nama_pemesan" class="form-label">Nama Pemesan</label>
                    <input type="text" name="nama_pemesan" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="alamat_pemesan" class="form-label">Alamat Pemesan</label>
                    <textarea name="alamat_pemesan" class="form-control" rows="3"></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="no_telp" class="form-label">No Telepon</label>
                        <input type="text" name="no_telp" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="contact_person" class="form-label">Contact Person</label>
                        <input type="text" name="contact_person" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="diskon" class="form-label">Diskon</label>
                        <input type="text" name="diskon" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="ppn" class="form-label">PPN</label>
                    <input type="text" name="ppn" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea id="catatan" name="catatan" class="form-control" rows="5"></textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        💾 Simpan
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
        document.getElementById('pengadaan_id').addEventListener('change', function() {
            const pengadaanId = this.value;
            const vendorSelect = document.getElementById('vendor_id');

            vendorSelect.innerHTML = '<option value=\"\">-- Loading Vendor --</option>';

            if (pengadaanId) {
                fetch(`/admin/perintahorders/vendors/${pengadaanId}`)
                    .then(response => response.json())
                    .then(data => {
                        vendorSelect.innerHTML = '<option value="">-- Pilih Vendor --</option>';
                        data.forEach(vendor => {
                            vendorSelect.innerHTML += `<option value="${vendor.id}">${vendor.nama_perusahaan}</option>`;
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        vendorSelect.innerHTML = '<option value="">-- Gagal memuat vendor --</option>';
                    });
                            }
        });
    </script>
    <script>
    document.getElementById('vendor_id').addEventListener('change', function () {
        const vendorId = this.value;
        const pengadaanId = document.getElementById('pengadaan_id').value;
        const barangList = document.getElementById('barang-list');

        barangList.innerHTML = '<p>Loading barang...</p>';

        if (vendorId && pengadaanId) {
            fetch(`/admin/perintahorders/barang/${pengadaanId}/${vendorId}`)
                .then(response => response.json())
                .then(data => {
                    // Filter: exclude kalau status_finance atau status_director adalah "rejected"
                    const filteredData = data.filter(item => 
                        item.status_finance === 'checked' || item.status_director === 'approved'
                    );

                    if (filteredData.length > 0) {
                        let html = '<h5>Daftar Barang</h5>';
                        html += '<table class="table"><thead><tr><th>Nama Barang</th><th>Jumlah</th><th>Harga/Unit</th><th>Catatan Finance</th><th>Catatan Direktur</th></tr></thead><tbody>';
                        filteredData.forEach((item, i) => {
                            html += `
                                <tr>
                                    <td>${item.nama}</td>
                                    <td>
                                        <input type="number" name="data[${i}][qty]" class="form-control" value="${item.jumlah}" min="1">
                                    </td>
                                    <td>${item.rab}</td>
                                    <td>${item.catatan_finance || '-'}</td>
                                    <td>${item.catatan_direktur || '-'}</td>
                                </tr>
                                <input type="hidden" name="data[${i}][pengadaan_item_id]" value="${item.id}">
                                <input type="hidden" name="data[${i}][rab]" value="${item.rab}">
                            `;
                        });
                        html += '</tbody></table>';
                        barangList.innerHTML = html;
                    } else {
                        barangList.innerHTML = '<p>Tidak ada barang yang sesuai.</p>';
                    }
                    // if (data.length > 0) {
                    //     let html = '<h5>Daftar Barang</h5>';
                    //     html += '<table class="table"><thead><tr><th>Nama Barang</th><th>Jumlah</th><th>Harga/Unit</th><th>Catatan Finance</th><th>Catatan Direktur</th></tr></thead><tbody>';
                    //     data.forEach((item, i) => {
                    //         html += `
                    //             <tr>
                    //                 <td>${item.nama}</td>
                    //                 <td>
                    //                     <input type="number" name="data[${i}][qty]" class="form-control" value="${item.jumlah}" min="1">
                    //                 </td>
                    //                 <td>${item.rab}</td>
                    //                 <td>${item.catatan_finance || '-'}</td>
                    //                 <td>${item.catatan_direktur || '-'}</td>
                    //             </tr>
                    //             <input type="hidden" name="data[${i}][pengadaan_item_id]" value="${item.id}">
                    //             <input type="hidden" name="data[${i}][rab]" value="${item.rab}">
                    //         `;
                    //     });
                        // data.forEach((item, i) => {
                        //     html += `
                        //     <tr>
                        //         <td>${item.nama}</td>
                        //         <td>${item.jumlah}</td>
                        //         <td>${item.rab}</td>
                        //         <td>${item.catatan_finance}</td>
                        //         <td>${item.catatan_direktur}</td>
                        //     </tr>
                        //     <input type="hidden" name="data[${i}][pengadaan_item_id]" value="${item.id}">
                        //     <input type="hidden" name="data[${i}][qty]" value="${item.jumlah}">
                        //     <input type="hidden" name="data[${i}][rab]" value="${item.rab}">
                        //     <input type="hidden" name="data[${i}][catatan_finance]" value="${item.catatan_finance}">
                        //     <input type="hidden" name="data[${i}][catatan_direktur]" value="${item.catatan_direktur}">
                        //     `;
                        // });
                    //     html += '</tbody></table>';
                    //     barangList.innerHTML = html;
                    // } else {
                    //     barangList.innerHTML = '<p>Tidak ada barang yang sesuai.</p>';
                    // }
                });
        }
    });
    </script>
    <script>
        const textarea = document.getElementById('catatan');

        textarea.addEventListener('keydown', function (e) {
            // Jika user menekan Enter
            if (e.key === 'Enter') {
                e.preventDefault(); // Hindari enter default
                const lines = textarea.value.split('\n');
                const newLineNumber = lines.length + 1;
                textarea.value += `\n${newLineNumber}. `;
            }
        });

        // Tambah 1. otomatis di awal
        textarea.addEventListener('focus', function () {
            if (textarea.value.trim() === '') {
                textarea.value = '1. ';
            }
        });
    </script>

    <script>
        new DataTable('#vendor');
    </script>
@endpush