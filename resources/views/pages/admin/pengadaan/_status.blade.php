@php $pengadaan = $row; @endphp
    @if ($pengadaan->status === 'pending')
        <span class="badge bg-warning">Pending</span>
    @elseif($pengadaan->status === 'validated_finance')
        <span class="badge bg-success">Validated Finance</span>
    @elseif($pengadaan->status === 'rejected_finance')
        <span class="badge bg-danger">Rejected Finance</span>
    @elseif($pengadaan->status === 'approved_director')
        <span class="badge bg-success">Approved Director</span>
    @elseif($pengadaan->status === 'rejected_director')
        <span class="badge bg-danger">Rejected Director</span>
    @elseif($pengadaan->status === 'finish_procurement')
        <span class="badge bg-success">Finish Review By Procurement</span>
    @elseif($pengadaan->status === 'rejected_procurement')
        <span class="badge bg-danger">Rejected Procurement</span>
    @elseif($pengadaan->status === 'purchased')
        <span class="badge bg-success">Purchased</span>
    @elseif($pengadaan->status === 'distributed')
        <span class="badge bg-success">Distributed</span>
    @elseif($pengadaan->status === 'accepted')
        <span class="badge bg-success">Accepted</span>
    @elseif($pengadaan->status === 'completed')
        <span class="badge bg-success">Complated</span>
@endif