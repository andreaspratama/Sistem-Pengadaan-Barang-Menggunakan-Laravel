@php $pengadaan = $row; @endphp
    @if ($pengadaan->unit === 'Pre School Gajahmada')
        <span class="badge bg-warning">Preschool Gajahmada</span>
    @elseif ($pengadaan->unit === 'Manajemen')
        <span class="badge bg-primary">Manajemen</span>
    @elseif($pengadaan->unit === 'Elementary')
        <span class="badge bg-info">Elementary</span>
    @elseif($pengadaan->unit === 'Junior High School')
        <span class="badge bg-primary">Junior High School</span>
    @elseif($pengadaan->unit === 'Senior High School')
        <span class="badge bg-secondary">Senior High School</span>
    @elseif($pengadaan->unit === 'Pre School Tanah Mas')
        <span class="badge bg-dark">Preschool Tanah Mas</span>
@endif