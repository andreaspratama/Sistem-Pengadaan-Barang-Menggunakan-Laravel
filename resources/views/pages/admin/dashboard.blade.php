@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="page-heading mb-4">
        <h3 class="fw-bold">Dashboard Pengadaan</h3>
        <p class="text-muted">Selamat datang, {{ auth()->user()->name }} 👋</p>
    </div>

    @if (auth()->user()->role == 'supervisor' && $pendingForSupervisor > 0)
        <div class="alert alert-warning d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-triangle me-2 fs-5"></i>
            <div>
                Anda memiliki <strong>{{ $pendingForSupervisor }}</strong> pengadaan yang menunggu approval Supervisor.
                <a href="{{ route('approval.supervisor.index') }}" class="ms-2 text-decoration-underline">Lihat Sekarang</a>
            </div>
        </div>
    @endif

    @if (auth()->user()->role == 'Finance' && $pendingForFinance > 0)
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class="bi bi-cash-coin me-2 fs-5"></i>
            <div>
                Terdapat <strong>{{ $pendingForFinance }}</strong> pengadaan yang menunggu approval Keuangan.
                @foreach($pengadaanMenungguFinance as $pengadaan)
                    <li>
                        <a href="{{ route('approvalFinance', ['id' => $pengadaan->id]) }}">
                            Approve: {{ $pengadaan->keterangan }}
                        </a>
                    </li>
                @endforeach
            </div>
        </div>
    @endif

    @if (auth()->user()->role == 'Director' && $pendingForDirektur > 0)
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class="bi bi-person-check me-2 fs-5"></i>
            <div>
                Ada <strong>{{ $pendingForDirektur }}</strong> pengadaan yang perlu disetujui Direktur.
                @foreach($pengadaanMenungguDirektur as $pengadaan)
                    <li>
                        <a href="{{ route('approvalDirektur', ['id' => $pengadaan->id]) }}">
                            Approve: {{ $pengadaan->keterangan }}
                        </a>
                    </li>
                @endforeach
            </div>
        </div>
    @endif
    
    @if (auth()->user()->role == 'Procurement' && $pendingForProcurement > 0)
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class="bi bi-person-check me-2 fs-5"></i>
            <div>
                Ada <strong>{{ $pendingForProcurement }}</strong> pengadaan yang perlu untuk pembuatan PERINTAH ORDER.
                @foreach($pengadaanMenungguProcurement as $pengadaan)
                    <li>
                        <a href="{{ route('approvalDirektur', ['id' => $pengadaan->id]) }}">
                            Approve: {{ $pengadaan->keterangan }}
                        </a>
                    </li>
                @endforeach
            </div>
        </div>
    @endif


    <div class="row g-3 mb-4">
        <!-- Total Pengadaan -->
        <div class="col-md-3">
            <div class="card border-0 shadow rounded-3">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 text-primary">
                        <i class="bi bi-clipboard-data fs-3"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">Total Pengadaan</div>
                        <h5 class="mb-0">{{ $totalPengadaan }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <!-- Draft -->
        <div class="col-md-3">
            <div class="card border-0 shadow rounded-3">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 text-warning">
                        <i class="bi bi-pencil-square fs-3"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">Draft</div>
                        <h5 class="mb-0">{{ $pengadaanDraft }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <!-- Disetujui -->
        <div class="col-md-3">
            <div class="card border-0 shadow rounded-3">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 text-success">
                        <i class="bi bi-check-circle fs-3"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">Disetujui</div>
                        <h5 class="mb-0">{{ $pengadaanApproved }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <!-- Ditolak -->
        <div class="col-md-3">
            <div class="card border-0 shadow rounded-3">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 text-danger">
                        <i class="bi bi-x-circle fs-3"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">Ditolak</div>
                        <h5 class="mb-0">{{ $pengadaanRejected }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Log Terakhir dan Batas Approval -->
    @if (in_array(Auth::user()->role, ['Finance', 'Director', 'Procurement']))
        <div class="card border-0 shadow mb-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">Log Approval Terakhir</h5>
            </div>
            <div class="card-body">
                @if ($lastLog)
                    <p class="mb-2 mt-2">
                        Anda terakhir melakukan approval pada pengadaan: 
                        <strong>{{ $lastLog->pengadaan->keterangan ?? '-' }}</strong><br>
                        Disetujui oleh: <strong>{{ ucfirst($lastLog->role) }}</strong> 
                        pada <strong>{{ \Carbon\Carbon::parse($lastLog->tanggal_approval)->translatedFormat('d F Y') }}</strong>
                    </p>
                @else
                    <div class="alert alert-warning mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Belum ada log approval.
                    </div>
                @endif
            </div>
        </div>
    @endif
    @php
        $role = auth()->user()->role;
        $noPending = false;

        if ($role === 'supervisor' && $pendingForSupervisor == 0) {
            $noPending = true;
        } elseif ($role === 'Finance' && $pendingForFinance == 0) {
            $noPending = true;
        } elseif ($role === 'Director' && $pendingForDirektur == 0) {
            $noPending = true;
        } elseif ($role === 'Procurement' && $pendingForProcurement == 0) {
            $noPending = true;
        }
    @endphp

    @if ($noPending)
        <div class="alert alert-success mt-3">
            <i class="bi bi-check-circle me-2"></i>
            Tidak ada pengadaan yang perlu Anda approve saat ini. 👍
        </div>
    @endif


    <!-- Tabel Pengadaan Terbaru -->
    {{-- <div class="card border-0 shadow">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0">Pengadaan Terbaru</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Pengadaan</th>
                        <th>Unit</th>
                        <th>Status</th>
                        <th>Tanggal Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestPengadaan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->keterangan }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>
                                <span class="badge bg-{{ $item->status_color }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div> --}}
</div>
@endsection
