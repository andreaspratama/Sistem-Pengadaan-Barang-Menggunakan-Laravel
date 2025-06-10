@extends('layouts.admin')

@section('title', 'Detail Perintah Order')

@section('content')
<div class="page-heading mb-4">
    <h2 class="fw-bold">Detail Perintah Order</h2>
</div>

<div class="page-content">
    <section class="section">
        <div class="mb-4 d-flex justify-content-between">
            <a href="{{ route('generatePdf', $po->id) }}" class="btn btn-primary">
                <i class="bi bi-printer"></i> Generate PDF
            </a>
            <a href="{{ route('perintahorder.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        {{-- Informasi Umum --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0 fw-semibold">Informasi Umum</h5>
            </div>
            <div class="card-body mt-3">
                <div class="row mb-2">
                    <div class="col-md-6"><strong>No Surat:</strong> {{ $po->no_surat }}</div>
                    <div class="col-md-6"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($po->tanggal)->translatedFormat('d M Y') }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Nama Pemesan:</strong> {{ $po->nama_pemesan }}</div>
                    <div class="col-md-6"><strong>Email:</strong> {{ $po->email }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Alamat:</strong> {{ $po->alamat_pemesan }}</div>
                    <div class="col-md-6"><strong>No Telp:</strong> {{ $po->no_telp }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Contact Person:</strong> {{ $po->contact_person }}</div>
                    <div class="col-md-6"><strong>Diskon:</strong> {{ $po->diskon }}%</div>
                </div>
                <div class="row">
                    <div class="col-md-6"><strong>PPN:</strong> {{ $po->ppn }}%</div>
                </div>
            </div>
        </div>

        {{-- Vendor --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0 fw-semibold">Informasi Vendor</h5>
            </div>
            <div class="card-body mt-3">
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Nama Vendor:</strong> {{ $po->vendor->nama_perusahaan ?? '-' }}</div>
                    <div class="col-md-6"><strong>Kontak Vendor:</strong> {{ $po->vendor->no_telp ?? '-' }}</div>
                </div>
                <div class="row">
                    <div class="col-md-12"><strong>Alamat:</strong> {{ $po->vendor->alamat_perusahaan ?? '-' }}</div>
                </div>
            </div>
        </div>

        {{-- Barang --}}
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0 fw-semibold">Daftar Barang Pengadaan</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                            <th>Fungsi</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $grandTotal = 0;
                        @endphp
                        @foreach ($po->poitem as $item)
                            @php
                                $rab = (int) str_replace('.', '', $item->rab);
                                $qty = (int) $item->qty;
                                $total = $rab * $qty;
                                $grandTotal += $total;
                            @endphp
                            <tr>
                                <td>{{ $item->items->nama ?? '-' }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->items->fungsi ?? '-' }}</td>
                                <td>Rp {{ number_format($rab, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach

                        @php
                            $diskonPersen = $po->diskon ?? 0;
                            $nilaiDiskon = $grandTotal * ($diskonPersen / 100);
                            $grandTotalAfterDiskon = $grandTotal - $nilaiDiskon;
                        @endphp

                        <tr class="table-light fw-semibold">
                            <td colspan="4" class="text-end">Sub Total (Setelah Diskon)</td>
                            <td>Rp {{ number_format($grandTotalAfterDiskon, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>
@endsection

@push('prepend-style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endpush
