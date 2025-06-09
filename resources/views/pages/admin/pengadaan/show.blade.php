@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-heading mb-4">
    <h3>Dashboard</h3>
</div> 

<div class="page-content">
    <section class="section">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0" style="color: white">List Barang</h5>
                <a href="{{ route('pengadaan.index') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                @if (Auth::user()->role === 'Procurement')
                    <div class="d-flex gap-2 mt-3">
                        @if ($pengadaan->status === 'finish_procurement')
                            <form action="{{ route('pengadaan.updateStatus', [$pengadaan->id, 'purchased']) }}" method="POST">
                                @csrf
                                <button class="btn btn-warning">Purchased</button>
                            </form>
                        @endif

                        @if ($pengadaan->status === 'purchased')
                            <form action="{{ route('pengadaan.updateStatus', [$pengadaan->id, 'distributed']) }}" method="POST">
                                @csrf
                                <button class="btn btn-info">Distributed</button>
                            </form>
                        @endif

                    </div>
                @endif
                    @if ($pengadaan->status === 'distributed')
                        <form action="{{ route('pengadaan.updateStatusWithNote', [$pengadaan->id, 'accepted']) }}" method="POST" class="mt-3">
                            @csrf
                            <div class="form-group">
                                <label for="komentar">Catatan (opsional)</label>
                                <textarea name="komentar" id="komentar" class="form-control" placeholder="Contoh: Mouse belum dikirim"></textarea>
                            </div>
                            <button class="btn btn-warning mt-2">Accepted</button>
                        </form>
                    @endif
                    @php
                        $roleTerlarang = ['Procurement', 'Director', 'Finance'];
                    @endphp

                    @if ($pengadaan->status === 'accepted' && !in_array(Auth::user()->role, $roleTerlarang))
                        <form action="{{ route('pengadaan.updateStatus', [$pengadaan->id, 'completed']) }}" method="POST" class="mt-3">
                            @csrf
                            <button class="btn btn-success">Finish</button>
                        </form>
                    @endif

                    {{-- @if ($pengadaan->status === 'distributed')
                        <form action="{{ route('pengadaan.updateStatus', [$pengadaan->id, 'completed']) }}" method="POST" class="mt-3">
                            @csrf
                            <button class="btn btn-success">Selesai</button>
                        </form>
                    @endif --}}
                <p class="d-inline-flex gap-1 mt-3">
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    Riwayat Status
                </button>
                </p>
                <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    <ul class="list-group">
                        @foreach ($pengadaan->approvalLogs as $log)
                            <li class="list-group-item">
                                <span class="badge bg-success">{{ ucfirst($log->status) }}</span>
                                by <strong>{{ $log->role }}</strong>  {{ $log->komentar }} <br>
                                <small>{{ \Carbon\Carbon::parse($log->tanggal_approval)->format('d M Y') }}</small>
                            </li>
                        @endforeach
                    </ul>
                </div>
                </div>
                {{-- <h5>Riwayat Status</h5>
                <ul class="list-group">
                @foreach ($pengadaan->approvalLogs as $log)
                    <li class="list-group-item">
                        <span class="badge bg-primary">{{ ucfirst($log->status) }}</span>
                        oleh <strong>{{ $log->role }}</strong> — {{ $log->komentar }} <br>
                        <small>{{ \Carbon\Carbon::parse($log->tanggal_approval)->format('d M Y') }}</small>
                    </li>
                @endforeach
                </ul> --}}


                @php
                    $statusBadges = [
                        'validated_finance' => [
                            'class' => 'success',
                            'text' => 'Telah Divalidasi Oleh Finance',
                            'role' => 'Finance',
                            'status' => 'validated',
                        ],
                        'approved_director' => [
                            'class' => 'success',
                            'text' => 'Telah Disetujui Oleh Direktur',
                            'role' => 'Director',
                            'status' => 'approved',
                        ],
                        'finish_procurement' => [
                            'class' => 'success',
                            'text' => 'Telah dilihat oleh Procurement',
                            'role' => 'Procurement',
                            'status' => 'Finish Review',
                        ],
                        'rejected_finance' => [
                            'class' => 'danger',
                            'text' => 'Ditolak oleh Finance',
                            'role' => 'Finance',
                            'status' => 'rejected',
                        ],
                        'rejected_director' => [
                            'class' => 'danger',
                            'text' => 'Ditolak oleh Direktur',
                            'role' => 'Director',
                            'status' => 'rejected',
                        ],
                        'purchased' => [
                            'class' => 'success',
                            'text' => 'Barang sedang dibelikan oleh Procurement',
                            'role' => 'Procurement',
                            'status' => 'purchased',
                        ],
                        'distributed' => [
                            'class' => 'success',
                            'text' => 'Barang telah didistribusikan',
                            'role' => 'Procurement',
                            'status' => 'distributed',
                        ],
                        'accepted' => [
                            'class' => 'success',
                            'text' => 'Barang telah diterima namun dengan catatan',
                            'role' => ['Admin Keu', 'Kabid', 'Kepala Sekolah'],
                            'status' => 'accepted',
                        ],
                        // 'accepted' => [
                        //     'class' => 'success',
                        //     'text' => 'Barang telah diterima namun dengan catatan',
                        //     'role' => 'Procurement',
                        //     'status' => 'accepted',
                        // ],
                        'completed' => [
                            'class' => 'success',
                            'text' => 'Barang telah diterima semua',
                            'role' => ['Admin Keu', 'Kabid'],
                            'status' => 'completed',
                        ],
                    ];
                @endphp

                @if (array_key_exists($pengadaan->status, $statusBadges))
                    @php
                        $badge = $statusBadges[$pengadaan->status];

                        // Cek apakah role berupa array atau string
                        $roles = is_array($badge['role']) ? $badge['role'] : [$badge['role']];

                        $log = $pengadaan->approvalLogs
                            ->whereIn('role', $roles)
                            ->where('status', $badge['status'])
                            ->sortByDesc('tanggal_approval')
                            ->first();
                    @endphp

                    @if ($log)
                        <div class="alert alert-{{ $badge['class'] }} py-2 px-3 text-center small fw-semibold rounded-pill shadow-sm mt-3">
                            {{ $badge['text'] }} pada {{ \Carbon\Carbon::parse($log->tanggal_approval)->translatedFormat('d F Y') }}
                        </div>
                    @endif
                @endif
                {{-- Status Badge --}}
                {{-- @php
                    $statusBadges = [
                        'approved_finance' => ['text' => 'Telah disetujui oleh Finance', 'class' => 'success'],
                        'approved_director' => ['text' => 'Telah disetujui oleh Direktur', 'class' => 'info'],
                        'approved_procurement' => ['text' => 'Telah disetujui oleh Procurement', 'class' => 'primary'],
                        'rejected_finance' => ['text' => 'Pengajuan Ditolak oleh Finance', 'class' => 'danger'],
                        'rejected_director' => ['text' => 'Pengajuan Ditolak oleh Direktur', 'class' => 'danger'],
                        'rejected_procurement' => ['text' => 'Pengajuan Ditolak oleh Procurement', 'class' => 'danger'],
                    ];
                @endphp

                @if (array_key_exists($pengadaan->status, $statusBadges))
                    <div class="alert alert-{{ $statusBadges[$pengadaan->status]['class'] }} py-2 px-3 text-center small fw-semibold rounded-pill shadow-sm mt-3">
                        {{ $statusBadges[$pengadaan->status]['text'] }}
                    </div>
                @endif --}}

                <div class="table-responsive mt-3">
                    <table id="table-barang" class="table table-striped table-bordered align-middle" style="width:100%">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Fungsi</th>
                                <th>Ukuran</th>
                                <th>Type</th>
                                <th>Jumlah</th>
                                <th>Merk</th>
                                <th>Anggaran</th>
                                <th>Total</th>
                                <th>Validasi Finance</th>
                                <th>Validasi Director</th>
                            </tr>
                        </thead>
                        @php
                            $subtotal = 0;
                        @endphp
                        <tbody>
                            @foreach($pengadaan->items as $item)
                                @php
                                    $rab = (int) str_replace('.', '', $item->rab);
                                    $jumlah = (int) $item->jumlah;
                                    $total = $rab * $jumlah;
                                    $subtotal += $total;
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->fungsi }}</td>
                                    <td>{{ $item->ukuran }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>{{ $item->merk }}</td>
                                    <td>Rp {{ number_format(preg_replace('/\D/', '', $item->rab), 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                                    <td>
                                        @if($item->status_finance === 'pending')
                                            @if (in_array(Auth::user()->role, ['Finance', 'Checker']))
                                                <form action="{{ route('pengadaan.approve', $item->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <input type="text" name="catatan" placeholder="Catatan disetujui" class="form-control form-control-sm mb-1" required>
                                                    <button class="btn btn-success btn-sm mb-3">ACC</button>
                                                </form>

                                                <form action="{{ route('pengadaan.reject', $item->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <input type="text" name="catatan" placeholder="Alasan ditolak" class="form-control form-control-sm mb-1" required>
                                                    <button class="btn btn-danger btn-sm">Tolak</button>
                                                </form>
                                            @endif
                                        @else
                                            <span class="badge {{ $item->status_finance === 'checked' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($item->status_finance) }}
                                            </span><br>
                                            <small><strong>Catatan:</strong> {{ $item->catatan_finance }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->status_direktur === 'pending')
                                            @if (Auth::user()->role === 'Director')
                                                <form action="{{ route('pengadaan.approveDirector', $item->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <input type="text" name="catatan" placeholder="Catatan disetujui" class="form-control form-control-sm mb-1" required>
                                                    <button class="btn btn-success btn-sm mb-3">ACC</button>
                                                </form>

                                                <form action="{{ route('pengadaan.rejectDirector', $item->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <input type="text" name="catatan" placeholder="Alasan ditolak" class="form-control form-control-sm mb-1" required>
                                                    <button class="btn btn-danger btn-sm">Tolak</button>
                                                </form>
                                            @endif
                                        @else
                                            <span class="badge {{ $item->status_direktur === 'approved' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($item->status_direktur) }}
                                            </span><br>
                                            <small><strong>Catatan:</strong> {{ $item->catatan_direktur }}</small>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            {{-- Baris subtotal --}}
                            <tr>
                                <td colspan="8" style="text-align: right; font-weight: bold;">Sub Total</td>
                                <td style="font-weight: bold;">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @php
                    $status = $pengadaan->status;
                    $role = auth()->user()->role;
                    $unit = $pengadaan->unit;

                    $isRejected = $status === 'rejected';
                @endphp

                {{-- Approval Buttons --}}
                <div class="mt-4 d-flex justify-content-end gap-2">
                    @if (!$isRejected)
                        @php
                            $tanggalPengajuan = \Carbon\Carbon::parse($pengadaan->tanggal_pengajuan);
                            $batasWaktuFinance = $tanggalPengajuan->copy()->addDays(7);
                        @endphp
                        @if($role === 'Kepala Sekolah' && $status === 'pending')
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="alert alert-warning small p-2 mb-0 me-3 flex-grow-1">
                                    <div class="d-flex align-items-start">
                                        <i class="bi bi-exclamation-circle-fill me-2 mt-1"></i>
                                        <div>
                                            Anda memiliki waktu <strong>7 hari</strong> sejak pengajuan untuk melakukan validasi pengajuan.
                                            <div>Batas waktu: <strong>{{ $batasWaktuFinance->translatedFormat('d F Y') }}</strong></div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <a href="{{ route('approvalFinance', $pengadaan->id) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-search"></i> Proses Validasi Finance
                                </a> --}}
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalKepsek">
                                    <i class="bi bi-search"></i>Proses Validasi Kepala Sekolah
                                </button>
                            </div>
                        @elseif ($role === 'Finance')
                            @if (in_array($unit, ['Pre School Gajahmada', 'Pre School Tanah Mas', 'Elementary', 'Junior High School', 'Senior High School']))
                                @if ($status === 'validated_kepsek')
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="alert alert-warning small p-2 mb-0 me-3 flex-grow-1">
                                            <div class="d-flex align-items-start">
                                                <i class="bi bi-exclamation-circle-fill me-2 mt-1"></i>
                                                <div>
                                                    Anda memiliki waktu <strong>7 hari</strong> sejak pengajuan untuk melakukan validated unit selain um Finance.
                                                    <div>Batas waktu: <strong>{{ $batasWaktuFinance->translatedFormat('d F Y') }}</strong></div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <a href="{{ route('approvalFinance', $pengadaan->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-search"></i> Proses Validasi Finance
                                        </a> --}}
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <i class="bi bi-search"></i>Proses Validasi Finance
                                        </button>
                                    </div>
                                @elseif($status === 'pending')
                                    <div class="alert alert-warning p-2 py-1 m-0">
                                        Menunggu review dari kepala sekolah terlebih dahulu.
                                    </div>
                                @endif
                            @else
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="alert alert-warning small p-2 mb-0 me-3 flex-grow-1">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-exclamation-circle-fill me-2 mt-1"></i>
                                            <div>
                                                Anda memiliki waktu <strong>7 hari</strong> sejak pengajuan untuk melakukan validasi Finance.
                                                <div>Batas waktu: <strong>{{ $batasWaktuFinance->translatedFormat('d F Y') }}</strong></div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <a href="{{ route('approvalFinance', $pengadaan->id) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-search"></i> Proses Validasi Finance
                                    </a> --}}
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <i class="bi bi-search"></i>Proses Validasi Finance
                                    </button>
                                </div>
                            @endif
                        @elseif ($role === 'Director')
                            @if ($status === 'validated_finance')
                                @php
                                    $logFinance = $pengadaan->approvalLogs
                                        ->where('status', 'validated')
                                        ->where('role', 'Finance')
                                        ->sortByDesc('tanggal_approval')
                                        ->first();
                                    $batasWaktu = $logFinance ? \Carbon\Carbon::parse($logFinance->tanggal_approval)->addDays(7) : null;
                                @endphp

                                @if ($batasWaktu)
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="alert alert-warning small p-2 mb-0 me-3 flex-grow-1">
                                            <div class="d-flex align-items-start">
                                                <i class="bi bi-exclamation-circle-fill me-2 mt-1"></i>
                                                <div>
                                                    Batas waktu untuk melakukan approval adalah <strong>7 hari</strong> sejak disetujui oleh finance.
                                                    <div>Batas waktu: <strong>{{ $batasWaktu->translatedFormat('d F Y') }}</strong></div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <a href="{{ route('approvalDirektur', $pengadaan->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-search"></i> Proses Approval Direktur
                                        </a> --}}
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalDirektur">
                                            <i class="bi bi-search"></i>Proses Approval Direktur
                                        </button>
                                    </div>
                                @endif
                            @elseif($status === 'pending')
                                <div class="alert alert-info p-2 py-1 m-0">
                                    Menunggu persetujuan dari Finance terlebih dahulu.
                                </div>
                            @endif
                        @elseif ($role === 'Procurement')
                            @if ($status === 'approved_director')
                                @php
                                    $logDirector = $pengadaan->approvalLogs
                                        ->where('status', 'approved')
                                        ->where('role', 'Director')
                                        ->sortByDesc('tanggal_approval')
                                        ->first();
                                    $batasWaktu = $logDirector ? \Carbon\Carbon::parse($logDirector->tanggal_approval)->addDays(7) : null;
                                @endphp

                                @if ($batasWaktu)
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="alert alert-warning small p-2 mb-0 me-3 flex-grow-1">
                                            <div class="d-flex align-items-start">
                                                <i class="bi bi-exclamation-circle-fill me-2 mt-1"></i>
                                                <div>
                                                    Batas waktu untuk melakukan review adalah <strong>7 hari</strong> sejak disetujui oleh direktur.
                                                    <div>Batas waktu: <strong>{{ $batasWaktu->translatedFormat('d F Y') }}</strong></div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <a href="{{ route('approvalProcurement', $pengadaan->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-search"></i> Proses Approval Procurement
                                        </a> --}}
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalProcurement">
                                            <i class="bi bi-search"></i>Finish Preview
                                        </button>
                                    </div>
                                @endif
                            @elseif($status === 'pending')
                                <div class="alert alert-info p-2 py-1 m-0">
                                    Menunggu validasi dari Finance terlebih dahulu.
                                </div>
                            @elseif($status === 'validated_finance')
                                <div class="alert alert-info p-2 py-1 m-0">
                                    Menunggu persetujuan dari Direktur terlebih dahulu.
                                </div>
                            @endif
    
                            {{-- @if ($status === 'approved_director')
                                <a href="{{ route('approvalProcurement', $pengadaan->id) }}" class="btn btn-primary btn-sm shadow-sm">
                                    <i class="bi bi-search"></i> Proses Approval Procurement
                                </a>
                            @elseif ($status === 'draft')
                                <div class="alert alert-info p-2 py-1 m-0">
                                    Menunggu persetujuan dari Finance & Direktur terlebih dahulu.
                                </div>
                            @elseif($status === 'approved_finance')
                                <div class="alert alert-info p-2 py-1 m-0">
                                    Menunggu persetujuan dari Direktur terlebih dahulu.
                                </div>
                            @endif --}}
                        @endif
                    @else
                        <div class="alert alert-danger p-2 py-1 m-0">
                            Pengadaan telah ditolak. Proses approval dihentikan.
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>
</div>
<!-- Modal Kepsek -->
<div class="modal fade" id="exampleModalKepsek" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Validasi Kepala Sekolah</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('approvalKepsekProses', $pengadaan->id) }}">
            @csrf

            <div class="mb-3">
                <label for="status" class="form-label fw-semibold">Status Persetujuan</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="validated">Validasi Oke</option>
                    <option value="rejected">Tolak</option>
                </select>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success rounded-pill px-4">Submit Validation</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal Finance -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Validasi Finance</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('approvalFinanceProses', $pengadaan->id) }}">
            @csrf

            <div class="mb-3">
                <label for="status" class="form-label fw-semibold">Validation Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="">-- Select Status --</option>
                    <option value="validated">Validation OK</option>
                    <option value="rejected">Reject</option>
                </select>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success rounded-pill px-4">Save</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal Direktur -->
<div class="modal fade" id="exampleModalDirektur" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Approval Director</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('approvalDirekturProses', $pengadaan->id) }}">
            @csrf

            <div class="mb-3">
                <label for="status" class="form-label fw-semibold">Approval Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="">-- Select Status --</option>
                    <option value="approved">Approve</option>
                </select>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success rounded-pill px-4">Save</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal Procurement -->
<div class="modal fade" id="exampleModalProcurement" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Review Procurement</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('approvalProcurementProses', $pengadaan->id) }}">
            @csrf

            <div class="mb-3">
                <label for="status" class="form-label fw-semibold">Review Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="">-- Select Status --</option>
                    <option value="Finish Review">Finish Review</option>
                </select>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success rounded-pill px-4">Save</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('prepend-style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
@endpush

@push('addon-script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#table-barang').DataTable({
                responsive: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    }
                }
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


{{-- @elseif ($role === 'Procurement')
                            @if ($status === 'approved_director')
                                @php
                                    $logDirector = $pengadaan->approvalLogs
                                        ->where('status', 'approved')
                                        ->where('role', 'Director')
                                        ->sortByDesc('tanggal_approval')
                                        ->first();
                                    $batasWaktu = $logDirector ? \Carbon\Carbon::parse($logDirector->tanggal_approval)->addDays(7) : null;
                                @endphp

                                @if ($batasWaktu)
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="alert alert-warning small p-2 mb-0 me-3 flex-grow-1">
                                            <div class="d-flex align-items-start">
                                                <i class="bi bi-exclamation-circle-fill me-2 mt-1"></i>
                                                <div>
                                                    Batas waktu untuk melakukan approval adalah <strong>7 hari</strong> sejak disetujui oleh direktur.
                                                    <div>Batas waktu: <strong>{{ $batasWaktu->translatedFormat('d F Y') }}</strong></div>
                                                </div>
                                            </div>
                                        </div> --}}

                                        {{-- <a href="{{ route('approvalProcurement', $pengadaan->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-search"></i> Proses Approval Procurement
                                        </a> --}}
                                        {{-- <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalProcurement">
                                            <i class="bi bi-search"></i>Proses Validasi Procurement
                                        </button>
                                    </div>
                                @endif
                            @elseif($status === 'pending')
                                <div class="alert alert-info p-2 py-1 m-0">
                                    Menunggu persetujuan dari Finance terlebih dahulu.
                                </div>
                            @elseif($status === 'validated_finance')
                                <div class="alert alert-info p-2 py-1 m-0">
                                    Menunggu persetujuan dari Direktur terlebih dahulu.
                                </div>
                            @endif --}}
    
                            {{-- @if ($status === 'approved_director')
                                <a href="{{ route('approvalProcurement', $pengadaan->id) }}" class="btn btn-primary btn-sm shadow-sm">
                                    <i class="bi bi-search"></i> Proses Approval Procurement
                                </a>
                            @elseif ($status === 'draft')
                                <div class="alert alert-info p-2 py-1 m-0">
                                    Menunggu persetujuan dari Finance & Direktur terlebih dahulu.
                                </div>
                            @elseif($status === 'approved_finance')
                                <div class="alert alert-info p-2 py-1 m-0">
                                    Menunggu persetujuan dari Direktur terlebih dahulu.
                                </div>
                            @endif --}}
                        {{-- @endif --}}