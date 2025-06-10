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
        <div style="font-size: 16px; font-weight: bold;">SURAT PERINTAH ORDER</div>
        <div style="margin-top: 2px;">No: {{$po->no_surat}}</div>
    </div>

    <div style="font-weight: bold;">INFORMASI VENDOR</div>
    <div class="info-section">
        <div class="info-block">
            <div class="info-item"><label>Nama Vendor</label><span>{{ $po->vendor->nama_perusahaan }}</span></div>
            <div class="info-item"><label>Alamat</label><span>{{ $po->vendor->alamat_perusahaan }}</span></div>
            <div class="info-item"><label>No Telp</label><span>{{ $po->vendor->no_telp }}</span></div>
        </div>
        <div class="info-block">
            <div class="info-item"><label>Contact Person</label><span>{{ $po->vendor->hp_kontak_utama }}</span></div>
            <div class="info-item"><label>Email</label><span>{{ $po->vendor->email }}</span></div>
        </div>
    </div>

    <div style="font-weight: bold;">INFORMASI PEMESAN</div>
    <div class="info-section">
        <div class="info-block">
            <div class="info-item"><label>Nama Pemesan</label><span>{{ $po->nama_pemesan }}</span></div>
            <div class="info-item"><label>Alamat Pengiriman</label><span>{{ $po->alamat_pemesan }}</span></div>
            <div class="info-item"><label>No Telp</label><span>{{ $po->no_telp }}</span></div>
        </div>
        <div class="info-block">
            <div class="info-item"><label>Contact Person</label><span>{{ $po->contact_person }}</span></div>
            <div class="info-item"><label>Email</label><span>{{ $po->email }}</span></div>
        </div>
    </div>

    {{-- <p class="section-title">INFORMASI VENDOR</p>
    <table class="no-border">
        <tr><td>Nama Vendor</td><td>: {{$po->vendor->nama_perusahaan}}</td><td>Contact Person</td><td>: ....................</td></tr>
        <tr><td>Alamat</td><td colspan="3">: {{$po->vendor->alamat_perusahaan}}</td></tr>
        <tr><td>No Telp</td><td>: {{$po->vendor->no_tlp}}</td><td>Email</td><td>: {{$po->vendor->email}}</td></tr>
    </table>

    <p class="section-title">INFORMASI PEMESAN</p>
    <table class="no-border">
        <tr><td>Nama Pemesan</td><td>: {{$po->nama_pemesan}}</td><td>Contact Person</td><td>: {{$po->contact_person}}</td></tr>
        <tr><td>Alamat Pengiriman</td><td colspan="3">: {{$po->alamat_pemesan}}</td></tr>
        <tr><td>No Telp</td><td>: {{$po->no_telp}}</td><td>Email</td><td>: {{$po->email}}</td></tr>
    </table> --}}

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
            @php
                $hargaSebelumDiskonPPN = 0;
            @endphp
            @foreach ($po->poitem as $item)
                @php
                    // Pastikan anggaran dalam bentuk angka
                    $rab = (int) str_replace('.', '', $item->rab);
                    $qty = (int) $item->qty;
                    $totalItem = $rab * $qty;
                    $hargaSebelumDiskonPPN += $totalItem;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$item->items->nama}}</td>
                    <td>{{$item->qty}}</td>
                    <td>{{$item->qty}}</td>
                    <td>{{ number_format($rab, 0, ',', '.') }}</td>
                    <td>{{ number_format($totalItem, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            @php
                $diskonPersen = (float) ($po->diskon ?? 0); // jika null, jadikan 0
                $nilaiDiskon = $hargaSebelumDiskonPPN * ($diskonPersen / 100);
                $hargaSetelahDiskon = $hargaSebelumDiskonPPN - $nilaiDiskon;

                $ppnPersen = $po->ppn;
                $nilaiPPN = $hargaSetelahDiskon * ($ppnPersen / 100);
                $hargaSetelahDiskonDanPPN = $hargaSetelahDiskon + $nilaiPPN;
            @endphp
        </tbody>
    </table>

    <table style="margin-top: 10px;">
        <tr>
            <td style="width: 60%;">
                <strong>Catatan Tambahan:</strong><br>
                {{$po->catatan}}
            </td>
            <td>
                <table style="width: 100%;">
                    <tr><td>Subtotal</td><td>Rp {{number_format($hargaSebelumDiskonPPN, 0, ',', '.')}}</td></tr>
                    <tr><td>PPN (%)</td><td>{{$po->ppn}}%</td></tr>
                    <tr><td>Diskon (%)</td><td>{{$po->diskon}}%</td></tr>
                    <tr><td><strong>TOTAL</strong></td><td><strong>Rp {{number_format($hargaSetelahDiskonDanPPN, 0, ',', '.')}}</strong></td></tr>
                </table>
            </td>
        </tr>
    </table>

    <br><br>

    <div style="font-family: Arial, sans-serif; font-size: 12px;">
        <div style="margin-bottom: 10px;">
            Tanggal <span style="text-decoration: underline;">.....................................</span>
        </div>

        <div style="margin-bottom: 60px;">
            <div style="display: inline-block; width: 33%;">
                <strong>Disetujui</strong> Oleh :
            </div>
            <div style="display: inline-block; width: 33%;">
                <strong>Mengetahui</strong> Oleh:
            </div>
            <div style="display: inline-block; width: 33%;">
                <strong>Diajukan</strong> Oleh :
            </div>
        </div>

        <div>
            <div style="display: inline-block; width: 33%;">
                Nama : Sarah <span style="text-decoration: underline;">Suryawati</span>, SH, MBA<br>
                <strong>Jabatan</strong> : Direktur
            </div>
            <div style="display: inline-block; width: 33%;">
                Nama : Ratnawati, SE<br>
                <strong>Jabatan</strong> : PJS Kabid Keuangan
            </div>
            <div style="display: inline-block; width: 33%;">
                Nama : Rita Tirza<br>
                <strong>Jabatan</strong> : Kabid Pengadaan
            </div>
        </div>
    </div>


</body>
</html>
