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
                    List Perintah Order
                </h5>
                <a href="{{route('perintahorder.create')}}" class="btn btn-primary mt-2">Tambah PO</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover" id="po">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Vendor</th>
                        <th scope="col">Pengadaan</th>
                        <th scope="col">Nama Pemesan</th>
                        <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

    </section>
</div>

<!-- Modal Konfirmasi Delete -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="deleteForm" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
          </div>
          <div class="modal-body">
            Apakah kamu yakin ingin menghapus vendor ini?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Hapus</button>
          </div>
        </div>
      </form>
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
        $(function () {
            $('#po').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("perintahorder.data") }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false }, // nomor urut
                    { data: 'vendor', name: 'vendor.nama_perusahaan', orderable: false, searchable: false },
                    { data: 'pengadaan', name: 'pengadaan.keterangan', orderable: false, searchable: false },
                    { data: 'nama_pemesan', name: 'nama_pemesan' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });
        });
    </script>
@endpush