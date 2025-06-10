<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Perintah Order</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 10px; }
        .table, .table th, .table td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 4px;
        }
        .no-border { border: none !important; }
        .footer-table td {
            padding-top: 10px;
            vertical-align: top;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ public_path('logo.png') }}" style="float:left; height: 50px;">
        <h3 style="margin: 0;">Management Unit<br>Daniel Creative School</h3>
        <p style="margin: 0; font-size: 10px;">
            Jl. Madukoro Raya, No. 3-4, Kompleks Semarang Indah, Blok F,<br>
            Tawang Mas, Kec. Semarang Barat, Kota Semarang 50144<br>
            Telp. (024) 7643 - 7781, (024) 7643 -7449 www.dcs.sch.id
        </p>
        <hr>
        <h4>SURAT PERINTAH ORDER</h4>
        <p>No: ..............................................</p>
    </div>

    <table width="100%" class="no-border" style="margin-bottom: 10px;">
        <tr>
            <td><strong>INFORMASI VENDOR</strong></td>
            <td><strong>INFORMASI PEMESAN</strong></td>
        </tr>
        <tr>
            <td>
                Nama Vendor: {{ $vendor['nama'] ?? '.........................' }}<br>
                Alamat: {{ $vendor['alamat'] ?? '..............................' }}<br>
                No Telp: {{ $vendor['telp'] ?? '....................' }}<br>
                Contact Person: {{ $vendor['cp'] ?? '....................' }}<br>
                Email: {{ $vendor['email'] ?? '....................' }}
            </td>
            <td>
                Nama Pemesan: {{ $pemesan['nama'] ?? '.........................' }}<br>
                Alamat Pengiriman Barang: {{ $pemesan['alamat'] ?? '..............................' }}<br>
                No Telp: {{ $pemesan['telp'] ?? '....................' }}<br>
                Contact Person: {{ $pemesan['cp'] ?? '....................' }}<br>
                Email: {{ $pemesan['email'] ?? '....................' }}
            </td>
        </tr>
    </table>

    <table width="100%" class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Keterangan</th>
                <th>Unit</th>
                <th>Qty</th>
                <th>Harga/Unit</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['keterangan'] }}</td>
                    <td>{{ $item['unit'] }}</td>
                    <td>{{ $item['qty'] }}</td>
                    <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6"><strong>Catatan Tambahan:</strong><br>{{ $pemesan['catatan'] ?? '' }}</td>
            </tr>
        </tbody>
    </table>

    <table width="100%" class="no-border" style="margin-top: 10px;">
        <tr>
            <td width="50%">
                Subtotal: Rp {{ number_format($subtotal, 0, ',', '.') }}<br>
                PPN ({{ $ppn }}%): Rp {{ number_format($subtotal * ($ppn/100), 0, ',', '.') }}<br>
                Diskon ({{ $diskon }}%): Rp {{ number_format($subtotal * ($diskon/100), 0, ',', '.') }}<br>
                <strong>TOTAL: Rp {{ number_format($total, 0, ',', '.') }}</strong>
            </td>
            <td width="50%" class="footer-table">
                Tanggal: {{ \Carbon\Carbon::now()->format('d-m-Y') }}<br><br>
                Disetujui Oleh: ..................................<br>
                Diperiksa Oleh: ..................................<br>
                Diajukan Oleh: ..................................
            </td>
        </tr>
    </table>

    <table width="100%" class="no-border" style="margin-top: 20px;">
        <tr>
            <td>Nama: Sarah Suryawati, SH, MBA<br>Jabatan: Direktur</td>
            <td>Nama: Ratnawati, SE<br>Jabatan: PJS Kabid Keuangan</td>
            <td>Nama: Rita Tirza<br>Jabatan: Kabid Pengadaan</td>
        </tr>
    </table>

</body>
</html>
