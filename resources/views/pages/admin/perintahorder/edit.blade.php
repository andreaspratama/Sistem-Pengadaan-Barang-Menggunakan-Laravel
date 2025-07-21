@extends('layouts.admin')

@section('title')
    Edit Perintah Order
@endsection

@section('content')
<div class="container my-4">
    <div class="card shadow rounded">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0">✏️ Edit Perintah Order</h5>
        </div>
        <div class="card-body">
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

            <form action="{{ route('perintahorder.update', $po->id) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="pengadaan_id" value="{{ $po->pengadaan_id }}">
                <input type="hidden" name="vendor_id" value="{{ $po->vendor_id }}">

                <div class="row mb-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Pengadaan</label>
                        <select id="pengadaan_id" name="pengadaan_id" class="form-select">
                            <option value="">-- Pilih Pengadaan --</option>
                            <option value="{{ $po->pengadaan->id }}" selected>
                                #{{ $po->pengadaan->kode }} - {{ $po->pengadaan->keterangan }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Vendor</label>
                        <select id="vendor_id" name="vendor_id" class="form-select">
                            <option value="">-- Pilih Vendor --</option>
                            {{-- Data vendor akan dimuat lewat JavaScript berdasarkan pengadaan --}}
                        </select>
                    </div>
                </div>

                <div class="mb-4" id="barang-list">
                    <h5>Daftar Barang</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga/Unit</th>
                                <th>Catatan Finance</th>
                                <th>Catatan Direktur</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $i => $item)
                                <tr>
                                    <td>{{ $item->items->judul_buku ?? $item->items->nama }}</td>
                                    <td>
                                        <input type="number" name="data[{{ $i }}][qty]" class="form-control" value="{{ $item->qty }}" min="1">
                                    </td>
                                    <td>{{ $item->items->rab }}</td>
                                    <td>{{ $item->items->catatan_finance ?? '-' }}</td>
                                    <td>{{ $item->items->catatan_direktur ?? '-' }}</td>
                                </tr>
                                <input type="hidden" name="data[{{ $i }}][pengadaan_item_id]" value="{{ $item->pengadaan_item_id }}">
                                <input type="hidden" name="data[{{ $i }}][rab]" value="{{ floatval(str_replace('.', '', $item->items->rab)) }}">
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="unit_id" class="form-label">Pilih Unit</label>
                        <select id="unit_id" name="unit_id" class="form-select">
                            <option value="">-- Pilih Unit --</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}" {{ $po->unit_id == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ $po->tanggal }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama_pemesan" class="form-label">Nama Pemesan</label>
                        <input type="text" name="nama_pemesan" class="form-control" value="{{ $po->nama_pemesan }}">
                    </div>
                    <div class="col-md-6">
                        <label for="alamat_pemesan" class="form-label">Alamat Pemesan</label>
                        <input type="text" name="alamat_pemesan" class="form-control" value="{{ $po->alamat_pemesan }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="no_telp" class="form-label">No Telp</label>
                        <input type="text" name="no_telp" class="form-control" value="{{ $po->no_telp }}">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" value="{{ $po->email }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="contact_person" class="form-label">Contact Person</label>
                    <input type="text" name="contact_person" class="form-control" value="{{ $po->contact_person }}">
                </div>

                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea name="catatan" class="form-control" rows="5" id="catatan">{{ $po->catatan }}</textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">💾 Update</button>
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
        document.addEventListener('DOMContentLoaded', function () {
            const pengadaanIdSelect = document.getElementById('pengadaan_id');
            const vendorSelect = document.getElementById('vendor_id');
            const selectedVendorId = "{{ $po->vendor_id }}";

            function loadVendors(pengadaanId, selectedVendor = null) {
                vendorSelect.innerHTML = '<option value="">-- Loading Vendor --</option>';

                fetch(`/admin/perintahorders/vendors/${pengadaanId}`)
                    .then(response => response.json())
                    .then(data => {
                        vendorSelect.innerHTML = '<option value="">-- Pilih Vendor --</option>';
                        data.forEach(vendor => {
                            const isSelected = selectedVendor == vendor.id ? 'selected' : '';
                            vendorSelect.innerHTML += `<option value="${vendor.id}" ${isSelected}>${vendor.nama_perusahaan}</option>`;
                        });
                    })
                    .catch(error => {
                        console.error('Gagal memuat vendor:', error);
                        vendorSelect.innerHTML = '<option value="">-- Gagal memuat vendor --</option>';
                    });
            }

            // Saat halaman dimuat
            if (pengadaanIdSelect.value) {
                loadVendors(pengadaanIdSelect.value, selectedVendorId);
            }

            // Saat pengadaan diubah
            pengadaanIdSelect.addEventListener('change', function () {
                const pengadaanId = this.value;
                if (pengadaanId) {
                    loadVendors(pengadaanId);
                } else {
                    vendorSelect.innerHTML = '<option value="">-- Pilih Vendor --</option>';
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const pengadaanId = "{{ $po->pengadaan_id }}";
            const selectedVendorId = "{{ $po->vendor_id }}";
            const vendorSelect = document.getElementById('vendor_id');

            if (pengadaanId) {
                fetch(`/admin/perintahorders/vendors/${pengadaanId}`)
                    .then(response => response.json())
                    .then(data => {
                        vendorSelect.innerHTML = '<option value="">-- Pilih Vendor --</option>';
                        data.forEach(vendor => {
                            const isSelected = vendor.id == selectedVendorId ? 'selected' : '';
                            vendorSelect.innerHTML += `<option value="${vendor.id}" ${isSelected}>${vendor.nama_perusahaan}</option>`;
                        });
                    })
                    .catch(error => {
                        console.error('Gagal memuat vendor:', error);
                        vendorSelect.innerHTML = '<option value="">-- Gagal memuat vendor --</option>';
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


@endpush
