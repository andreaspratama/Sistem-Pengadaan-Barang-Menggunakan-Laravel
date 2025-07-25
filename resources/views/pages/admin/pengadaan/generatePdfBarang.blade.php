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
                <th>COA</th>
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
                    <td>{{$item->coa}}</td>
                    <td>{{$item->nama ?? $item->judul_buku}}</td>
                    <td>{{$pengadaan->unit}}</td>
                    <td>{{$item->jumlah}}</td>
                    <td>{{ number_format($rab, 0, ',', '.') }}</td>
                    <td>{{ number_format($totalItem, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
            <tr>
                <!-- Kolom kiri: Tabel Approval (tetap ada border) -->
                <td style="width: 100%; vertical-align: top;">
                    <strong>Riwayat Persetujuan:</strong>
                    <table style="width: 100%; border-collapse: collapse; font-size: 11px; margin-top: 6px;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid #000;">No</th>
                                <th style="border: 1px solid #000;">Nama</th>
                                <th style="border: 1px solid #000;">Peran</th>
                                <th style="border: 1px solid #000;">Status</th>
                                <th style="border: 1px solid #000;">Tanggal</th>
                                <th style="border: 1px solid #000;">Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- 1. Dibuat oleh --}}
                            <tr>
                                <td style="border: 1px solid #000; text-align: center;">1</td>
                                <td style="border: 1px solid #000;">{{ $pengadaan->user->name ?? '-' }}</td>
                                <td style="border: 1px solid #000;">Pembuat</td>
                                <td style="border: 1px solid #000;">Dibuat</td>
                                <td style="border: 1px solid #000;">
                                    {{ \Carbon\Carbon::parse($pengadaan->created_at)->format('d/m/Y') }}
                                </td>
                                <td style="border: 1px solid #000;">-</td>
                            </tr>

                            {{-- 2. Checker --}}
                            @php $no = 2; @endphp
                            @foreach ($pengadaan->items as $item)
                                @php
                                    $checker = \App\Models\User::find($item->checked);
                                @endphp

                                @if ($checker)
                                    <tr>
                                        <td style="border: 1px solid #000; text-align: center;">{{ $no++ }}</td>
                                        <td style="border: 1px solid #000;">{{ $checker->name }}</td>
                                        <td style="border: 1px solid #000;">Checker</td>
                                        <td style="border: 1px solid #000;">Dicek</td>
                                        <td style="border: 1px solid #000;">
                                            {{ \Carbon\Carbon::parse($item->tanggal_checked)->format('d/m/Y') }}
                                        </td>
                                        <td style="border: 1px solid #000;">{{ $item->catatan_finance ?? '-' }}</td>
                                    </tr>
                                @endif
                            @endforeach

                            {{-- 3. Approval logs --}}
                            @foreach ($approvalLogs as $i => $log)
                                @php
                                    $catatan = '-';

                                    // Ambil item pertama (jika ada)
                                    $firstItem = $pengadaan->items->first();

                                    if ($log->role === 'Direktur') {
                                        $catatan = $firstItem->catatan_direktur ?? '-';
                                    } elseif ($log->role === 'Kepala Sekolah') {
                                        $catatan = $firstItem->catatan_kepsek ?? '-';
                                    }
                                @endphp
                                <tr>
                                    <td style="border: 1px solid #000; text-align: center;">{{ $i + $no }}</td>
                                    <td style="border: 1px solid #000;">{{ $log->user->name ?? '-' }}</td>
                                    <td style="border: 1px solid #000;">{{ $log->role }}</td>
                                    <td style="border: 1px solid #000;">{{ $log->status }}</td>
                                    <td style="border: 1px solid #000;">
                                        {{ \Carbon\Carbon::parse($log->tanggal_approval)->format('d/m/Y') }}
                                    </td>
                                    <td style="border: 1px solid #000;">{{ $catatan }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </td>
            </tr>
        </table>

</body>
</html>
