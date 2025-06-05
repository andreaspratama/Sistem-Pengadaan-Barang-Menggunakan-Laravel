@extends('layouts.admin')

@section('title')
    Pengadaan
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
                    List Pengadaan
                </h5>
                <a href="{{route('pengadaan.create')}}" class="btn btn-primary mt-2">Tambah Pengadaan</a>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <select id="filter-status" class="form-select">
                            <option value="">-- Filter Status --</option>
                            <option value="pending">Pending</option>
                            <option value="approved_finance">Approved Finance</option>
                            <option value="approved_procurement">Approved Procurement</option>
                            <option value="approved_director">Approved Director</option>
                            <option value="rejected_finance">Rejected Finance</option>
                            <option value="rejected_procurement">Rejected Procurement</option>
                            <option value="rejected_director">Rejected Director</option>
                            <option value="purchased">Purchased</option>
                            <option value="distributed">Distributed</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select id="filter-unit" class="form-select">
                            <option value="">-- Filter Unit --</option>
                            <option value="Elementary">Elementary</option>
                            <option value="Junior High School">Junior High School</option>
                            <option value="Senior High School">Senior High School</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="date" id="filter-date-start" class="form-control" placeholder="Tanggal Mulai">
                            <span class="input-group-text">s.d</span>
                            <input type="date" id="filter-date-end" class="form-control" placeholder="Tanggal Akhir">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <button id="reset-filter" class="btn btn-secondary w-100">Reset</button>
                    </div>
                </div>


                <table class="table table-bordered table-hover" id="pengadaan">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Mengajukan</th>
                        <th>Unit</th>
                        <th>Nama</th>
                        <th>Tangagl Pengajuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
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
            var table = $('#pengadaan').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("pengadaan.data") }}',
                    data: function (d) {
                        d.status = $('#filter-status').val();
                        d.unit = $('#filter-unit').val();
                        d.date_start = $('#filter-date-start').val();
                        d.date_end = $('#filter-date-end').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'user_info', name: 'user.name' },
                    { data: 'unit_label', name: 'unit' },
                    { data: 'keterangan', name: 'keterangan' },
                    { data: 'tanggal_pengajuan', name: 'tanggal_pengajuan' },
                    { data: 'status_label', name: 'status', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });

            // Trigger filter saat select atau date berubah
            $('#filter-status, #filter-unit, #filter-date-start, #filter-date-end').on('change', function () {
                table.ajax.reload();
            });

            // Tombol Reset Filter
            $('#reset-filter').on('click', function () {
                $('#filter-status').val('');
                $('#filter-unit').val('');
                $('#filter-date-start').val('');
                $('#filter-date-end').val('');
                table.ajax.reload();
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                timer: 2500,
                showConfirmButton: false
            });
        </script>
        @endif

        @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session("error") }}',
                timer: 2500,
                showConfirmButton: false
            });
        </script>
        @endif

        @if(session('rejected'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Item Ditolak!',
                text: '{{ session("rejected") }}',
                timer: 2500,
                showConfirmButton: false
            });
        </script>
    @endif

@endpush