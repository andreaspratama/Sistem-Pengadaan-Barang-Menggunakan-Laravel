@php $pengadaan = $row; @endphp
    @if ($pengadaan->status === 'pending')
        <span class="badge bg-warning">Pending</span>
    @elseif($pengadaan->status === 'validated_kepsek')
        <span class="badge bg-info">Validated Kepala Sekolah</span>
    @elseif($pengadaan->status === 'validated_finance')
        <span class="badge bg-warning">Validated Finance</span>
    @elseif($pengadaan->status === 'approved_director')
        <span class="badge bg-success">Approved Director</span>
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
@endif