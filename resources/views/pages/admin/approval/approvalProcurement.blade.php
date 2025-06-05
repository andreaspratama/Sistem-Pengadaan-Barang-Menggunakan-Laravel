@extends('layouts.admin')

@section('title', 'Form Approval Pengadaan')

@section('content')
<div class="page-heading mb-4">
    <h2 class="fw-bold">Form Approval Pengadaan</h2>
    <p class="text-muted">Verifikasi dan persetujuan pengajuan pengadaan</p>
</div>

<div class="page-content">
    <section class="section">
        <div class="card shadow rounded-4 border-0">
            <div class="card-header bg-white border-bottom-0">
                <h5 class="card-title mb-0 fw-semibold">Detail Pengajuan #{{ $pengadaan->id }}</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Unit</label>
                    <div class="form-control-plaintext">{{ $pengadaan->unit }}</div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Keterangan</label>
                    <div class="form-control-plaintext">{{ $pengadaan->keterangan }}</div>
                </div>

                <hr class="my-4">

                <form method="POST" action="{{ route('approvalProcurementProses', $pengadaan->id) }}">
                    @csrf

                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold">Status Persetujuan</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="approved">Setujui</option>
                            <option value="rejected">Tolak</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="komentar" class="form-label fw-semibold">Komentar (Opsional)</label>
                        <textarea name="komentar" id="komentar" class="form-control" rows="4" placeholder="Tambahkan komentar jika perlu..."></textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success rounded-pill px-4">Submit Approval</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
@endpush