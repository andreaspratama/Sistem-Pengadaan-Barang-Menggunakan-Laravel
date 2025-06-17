@php $pengadaan = $row; @endphp
    @if ($pengadaan->status === 'pending')
        <span class="badge bg-warning">Pending</span>
    @elseif($pengadaan->status === 'validated_kepsek')
        <span class="badge bg-info">Validated Kepala Sekolah</span>
    @elseif($pengadaan->status === 'validated_finance')
        <span class="badge bg-warning">Validated Finance</span>
    @elseif($pengadaan->status === 'rejected_finance')
        <span class="badge bg-danger">Rejected Finance</span>
    @elseif($pengadaan->status === 'approved_director')
        <span class="badge bg-success">Approved Director</span>
    @elseif($pengadaan->status === 'rejected_director')
        <span class="badge bg-danger">Rejected Director</span>
    @elseif($pengadaan->status === 'finish_procurement')
        <span class="badge bg-secondary">Finish Review By Procurement</span>
    @elseif($pengadaan->status === 'purchased')
        <span class="badge bg-info">Purchased</span>
    @elseif($pengadaan->status === 'distributed')
        <span class="badge bg-info">Distributed</span>
    @elseif($pengadaan->status === 'accepted')
        <span class="badge bg-info">Accepted</span>
    @elseif($pengadaan->status === 'completed')
        <span class="badge bg-success">Complated</span>
    @elseif($pengadaan->status_rab === 'Ada di RAB')
        <span class="badge bg-success">Ada di RAB</span>
    @elseif($pengadaan->status_rab === 'Tidak Ada di RAB')
        <span class="badge bg-danger">Tidak Ada di RAB</span>
@endif