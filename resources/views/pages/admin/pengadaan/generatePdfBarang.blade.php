<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Perintah Order</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        table { border-collapse: collapse; width: 100%; }
        td, th { border: 1px solid #000; padding: 4px; }
        .no-border td { border: none; }
        .header { text-align: center; font-weight: bold; font-size: 14px; margin-bottom: 20px; }
        .section-title { font-weight: bold; margin-top: 10px; }
        .ttd td { height: 80px; vertical-align: bottom; }
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 13px;
            margin-top: 10px;
        }
        .info-block {
            width: 48%;
        }
        .info-item {
            display: flex;
            margin-bottom: 4px;
        }
        .info-item label {
            width: 40%;
            display: inline-block;
        }
        .info-item span::before {
            content: ": ";
        }

        .ttd-container {
            width: 100%;
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-top: 40px;
        }
        .left-block {
            width: 30%;
            display: flex;
            flex-direction: column;
            /* border: 1px solid red; */ /* untuk debugging */
        }
        .left-block .tanggal {
            margin-bottom: 40px; /* spasi tanda tangan */
        }
        .right-block {
            width: 68%;
            display: flex;
            justify-content: space-between;
            /* border: 1px solid blue; */ /* debugging */
        }
        .right-sub-block {
            width: 48%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .signature-name {
            margin: 0;
            margin-top: 40px;
            line-height: 1.2;
            text-align: center;
        }
        .signature-jabatan {
            margin: 0;
            text-align: center;
        }
    </style>
</head>
<body>

    <table width="100%" cellspacing="0" cellpadding="0" style="border: none; border-collapse: collapse;">
        <tr>
            <td style="width: 150px; border: none;">
                <img src="{{ public_path('logoDcs.png') }}" alt="Logo" style="height: 100px;">
            </td>
            <td style="vertical-align: middle; border: none;">
                <div style="font-size: 15px;">
                    <strong style="font-size: 17px;">Management Unit<br>Daniel Creative School</strong><br>
                    Jl. Madukoro Raya, No. 3–4, Komplek Semarang Indah, Blok F,<br>
                    Tawang Mas, Kec. Semarang Barat, Kota Semarang 50144<br>
                    Telp. (024) 7643 – 7781, (024) 7643 –7449 | www.dcs.sch.id
                </div>
            </td>
        </tr>
    </table>


    {{-- <div style="display: flex; align-items: center;">
        <img src="{{ public_path('logoDcs.png') }}" alt="Logo" style="height: 60px; margin-right: 10px;">
        <div>
            <strong>Management Unit<br>Daniel Creative School</strong><br>
            Jl. Madukoro Raya, No. 3–4, Komplek Semarang Indah, Blok F,<br>
            Tawang Mas, Kec. Semarang Barat, Kota Semarang 50144<br>
            Telp. (024) 7643 – 7781, (024) 7643 –7449 | www.dcs.sch.id
        </div>
    </div> --}}

    <hr>

    <div style="width: 100%; text-align: center; margin-bottom: 10px;">
        <div style="font-size: 16px; font-weight: bold;">LIST BARANG</div>
    </div>

    <br>

    <table>
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
            @foreach ($pengadaan->items as $item)
                @php
                    // Pastikan anggaran dalam bentuk angka
                    $rab = (int) str_replace('.', '', $item->rab);
                    $jumlah = (int) $item->jumlah;
                    $totalItem = $rab * $jumlah;
                @endphp
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->nama ?? $item->judul_buku}}</td>
                    <td>{{$pengadaan->unit}}</td>
                    <td>{{$item->jumlah}}</td>
                    <td>{{ number_format($rab, 0, ',', '.') }}</td>
                    <td>{{ number_format($totalItem, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
