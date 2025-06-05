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
                    List Barang
                </h5>
            </div>
            <div class="card-body">
                {{-- <h3>Status Approval</h3>

                @php
                    $userRole = auth()->user()->role; // pastikan role-nya sudah login
                    $log = $pengadaan->approvalLogs->firstWhere('role', $userRole);
                @endphp

                @if ($log)
                    <p><strong>Status Anda:</strong> {{ ucfirst($log->status) }}</p>
                    <p><strong>Tanggal Disetujui:</strong> {{ $log->approved_at->format('d M Y') }}</p>
                    @if ($log->catatan)
                        <p><strong>Catatan:</strong> {{ $log->catatan }}</p>
                    @endif
                @else
                    <form action="{{ route('pengadaan.approval', $pengadaan->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="role" value="{{ $userRole }}">
                        <input type="hidden" name="status" value="approved">

                        <label>Catatan (opsional):</label>
                        <textarea name="catatan" rows="2" class="form-control"></textarea>

                        <button type="submit" class="btn btn-success mt-2">Approve Sebagai {{ ucfirst($userRole) }}</button>
                    </form>
                @endif --}}
                @if ($pengadaan->status === 'approved_finance')
                    <span class="badge bg-success mb-3">Telah di setujui oleh finance</span>
                @elseif ($pengadaan->status === 'approved_director')
                    <span class="badge bg-success mb-3">Telah di setujui oleh direktur</span>
                @elseif ($pengadaan->status === 'approved_procurement')
                    <span class="badge bg-success mb-3">Telah di setujui oleh procurement</span>
                @endif
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Fungsi</th>
                            <th>Bentuk</th>
                            <th>Ukuran</th>
                            <th>Type</th>
                            <th>Jumlah</th>
                            <th>Anggaran</th>
                            <th>Merk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengadaan->items as $item)
                        <tr>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->fungsi }}</td>
                            <td>{{ $item->bentuk }}</td>
                            <td>{{ $item->ukuran }}</td>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ $item->anggaran }}</td>
                            <td>{{ $item->merk }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="{{route('pengadaan.index')}}" class="btn btn-secondary">Kembali</a>
                @if (auth()->user()->role === 'Finance')
                    @if ($pengadaan->status != 'approved_finance')
                        <a href="{{route('approvalFinance', $pengadaan->id)}}" class="btn btn-primary">Approved Finance</a>  
                    @endif
                @elseif(auth()->user()->role === 'Direktur')
                    @if ($pengadaan->status != 'approved_director')
                        <a href="{{route('approvalDirektur', $pengadaan->id)}}" class="btn btn-primary">Approved Direktur</a>  
                    @endif
                @elseif(auth()->user()->role === 'Procurement')
                    @if ($pengadaan->status != 'approved_procurement')
                        <a href="{{route('approvalProcurement', $pengadaan->id)}}" class="btn btn-primary">Approved Procurement</a>  
                    @endif
                @endif
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
    <script>
        let index = 1;
        function tambahItem() {
            let html = `
                <div class="item-group">
                    <input type="text" class="form-control mb-3" name="items[${index}][nama]" placeholder="Nama Barang">
                    <input type="text" class="form-control mb-3" name="items[${index}][fungsi]" placeholder="Fungsi">
                    <input type="text" class="form-control mb-3" name="items[${index}][bentuk]" placeholder="Bentuk">
                    <input type="text" class="form-control mb-3" name="items[${index}][ukuran]" placeholder="Ukuran">
                    <input type="text" class="form-control mb-3" name="items[${index}][type]" placeholder="Type">
                    <input type="integer" class="form-control mb-3" name="items[${index}][jumlah]" placeholder="Jumlah">
                    <input type="text" class="form-control mb-3" name="items[${index}][anggaran]" placeholder="Anggaran">
                    <input type="text" class="form-control mb-3" name="items[${index}][merk]" placeholder="Merk">
                </div>`;
            document.getElementById('item-wrapper').insertAdjacentHTML('beforeend', html);
            index++;
        }
    </script>
@endpush