@extends('layouts.admin')

@section('title')
    Tambah Pengadaan
@endsection

@section('content')
<div class="page-heading mb-4">
    <h3>Tambah Pengadaan Barang</h3>
</div>
<div class="page-content">
    <section class="section">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0" style="color: white">Form Tambah Pengadaan</h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pengadaan.store') }}" method="POST">
                    @csrf

                    <div class="mb-3 mt-3">
                        <label for="unit" class="form-label fw-bold">Unit</label>
                        <select id="unit" class="form-select" name="unit" required>
                            <option selected disabled>-- Pilih Unit --</option>
                            <option value="Manajemen">Manajemen</option>
                            <option value="Pre School Gajahmada">Pre School Gajahmada</option>
                            <option value="Pre School Tanah Mas">Pre School Tanah Mas</option>
                            <option value="Elementary">Elementary</option>
                            <option value="Junior High School">Junior High School</option>
                            <option value="Senior High School">Senior High School</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="keterangan" class="form-label fw-bold">Keterangan</label>
                        <input type="text" id="keterangan" class="form-control" name="keterangan" placeholder="Keterangan pengadaan..." required>
                    </div>

                    <div id="item-wrapper">
                        <div class="item-group card p-3 mb-3 shadow-sm position-relative">
                            <button type="button" class="btn-close position-absolute top-0 end-0 m-2" aria-label="Close" onclick="this.parentElement.remove()"></button>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Nama Barang</label>
                                    <input type="text" class="form-control" name="items[0][nama]" placeholder="Nama Barang" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Type</label>
                                    <input type="text" class="form-control" name="items[0][type]" placeholder="Type">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Merk</label>
                                    <input type="text" class="form-control" name="items[0][merk]" placeholder="Merk">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Fungsi</label>
                                    <input type="text" class="form-control" name="items[0][fungsi]" placeholder="Fungsi" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Ukuran</label>
                                    <input type="text" class="form-control" name="items[0][ukuran]" placeholder="Ukuran">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Jumlah</label>
                                    <input type="number" class="form-control" name="items[0][jumlah]" placeholder="Jumlah" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">RAB</label>
                                    <input type="text" class="form-control anggaran-input" name="items[0][rab]" placeholder="Harga">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Kategori</label>
                                    {{-- <input type="text" class="form-control" name="items[0][kategori_id]" placeholder="Kategori"> --}}
                                    <select class="form-select" aria-label="Default select example" name="items[0][kategori_id]" class="form-control">
                                        <option selected>-- Pilih Kategori --</option>
                                        @foreach ($kategoris as $ktg)
                                            <option value="{{$ktg->id}}">{{$ktg->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-outline-primary mb-3" onclick="tambahItem()">+ Tambah Barang</button>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success">💾 Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@push('prepend-style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
@endpush

@push('addon-script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    let index = 1;

    function tambahItem() {
        let html = `
        <div class="item-group card p-3 mb-3 shadow-sm position-relative">
            <button type="button" class="btn-close position-absolute top-0 end-0 m-2" aria-label="Close" onclick="this.parentElement.remove()"></button>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nama Barang</label>
                    <input type="text" class="form-control" name="items[${index}][nama]" placeholder="Nama Barang" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Type</label>
                    <input type="text" class="form-control" name="items[${index}][type]" placeholder="Type">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Merk</label>
                    <input type="text" class="form-control" name="items[${index}][merk]" placeholder="Merk">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Fungsi</label>
                    <input type="text" class="form-control" name="items[${index}][fungsi]" placeholder="Fungsi" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Ukuran</label>
                    <input type="text" class="form-control" name="items[${index}][ukuran]" placeholder="Ukuran">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Jumlah</label>
                    <input type="number" class="form-control" name="items[${index}][jumlah]" placeholder="Jumlah" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">RAB</label>
                    <input type="text" class="form-control anggaran-input" name="items[${index}][rab]" placeholder="RAB">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Kategori</label>
                    <select class="form-select" aria-label="Default select example" name="items[${index}][kategori_id]" class="form-control">
                        <option selected>-- Pilih Kategori --</option>
                        @foreach ($kategoris as $ktg)
                            <option value="{{$ktg->id}}">{{$ktg->nama}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>`;
        $('#item-wrapper').append(html);
        index++;

        formatAnggaranInputs(); // Apply format ke input baru
    }

    function formatAnggaranInputs() {
        $('.anggaran-input').off('input').on('input', function () {
            let value = this.value.replace(/\D/g, '');
            this.value = new Intl.NumberFormat('id-ID').format(value);
        });
    }

    // Format yang pertama kali muncul
    $(document).ready(function () {
        formatAnggaranInputs();
    });
</script>
@endpush
