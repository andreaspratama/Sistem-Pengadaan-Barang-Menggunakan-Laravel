@extends('layouts.admin')

@section('title', 'Input Penawaran Vendor')

@section('content')
<div class="page-heading"><h3>Input Penawaran Vendor</h3></div>
<div class="page-content">
    <form method="GET" action="">
        <div>
            <label>Pilih Kategori:</label>
            <select name="kategori_id" onchange="this.form.submit()">
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    @if($kategoriId && $vendors->count() && $items->count())
    <form method="POST" action="{{ route('vendor-offer.store') }}">
        @csrf
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Barang</th>
                    @foreach($vendors as $vendor)
                        <th>{{ $vendor->nama }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item->barang->nama }}</td>
                    @foreach($vendors as $vendor)
                        <td>
                            <input type="number" step="0.01"
                                   name="offers[{{ $item->id }}][{{ $vendor->id }}]"
                                   placeholder="Harga" />
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <button type="submit">Simpan Penawaran</button>
    </form>
    @elseif($kategoriId)
        <p><strong>Data tidak ditemukan.</strong></p>
    @endif
</div>
@endsection

@push('addon-script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        const pengadaanId = $('#pengadaan_id').val();

        if (pengadaanId) {
            $.ajax({
                url: '/api/kategori-by-pengadaan',
                method: 'GET',
                data: { pengadaan_id: pengadaanId },
                success: function (response) {
                    if (response.kategoris.length > 0) {
                        $('#kategori_id').empty().append('<option value="">Pilih Kategori</option>');
                        $.each(response.kategoris, function (index, kategori) {
                            $('#kategori_id').append(
                                `<option value="${kategori.id}">${kategori.nama}</option>`
                            );
                        });
                    } else {
                        $('#kategori_id').html('<option value="">Tidak ada kategori</option>');
                    }
                },
                error: function (xhr) {
                    console.error('Gagal ambil kategori:', xhr.responseText);
                }
            });
        }
    });

    $('#kategori_id').on('change', function () {
        let pengadaanId = $('#pengadaan_id').val();
        let kategoriId = $(this).val();

        if (pengadaanId && kategoriId) {
            $.post("{{ route('getItems') }}", {
                pengadaan_id: pengadaanId,
                kategori_id: kategoriId,
                _token: '{{ csrf_token() }}'
            }, function (res) {
                let rows = '';
                res.items.forEach(function (item) {
                    rows += `
                        <tr>
                            <td>
                                ${item.nama_barang}<br><small>${item.spesifikasi ?? ''}</small>
                            </td>
                            <td>
                                <input type="number" name="items[${item.id}][harga]" class="form-control" />
                            </td>
                            <td>
                                <input type="text" name="items[${item.id}][catatan]" class="form-control" />
                            </td>
                        </tr>
                    `;
                });

                $('#barang-list').html(rows);
                $('#barang-table').show();
            });
        }
    });
</script>
@endpush
