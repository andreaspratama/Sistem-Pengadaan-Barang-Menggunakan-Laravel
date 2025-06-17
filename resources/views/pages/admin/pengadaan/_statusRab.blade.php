@php $pengadaan = $row; @endphp
    @if($pengadaan->status_rab === 'Ada di RAB')
        <span class="badge bg-success">Ada di RAB</span>
    @elseif($pengadaan->status_rab === 'Tidak Ada di RAB')
        <span class="badge bg-danger">Tidak Ada di RAB</span>
@endif