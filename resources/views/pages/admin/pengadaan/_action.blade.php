<a href="{{ route('pengadaan.show', $row->id) }}" 
   class="btn btn-outline-primary btn-sm d-inline-flex align-items-center" 
   title="Lihat Detail Pengadaan" style="gap: 0.25rem;"><span>Detail Pengadaan</span>
</a>
@push('prepend-style')
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush

{{-- Tambahkan logic tombol approval sesuai role jika mau --}}
