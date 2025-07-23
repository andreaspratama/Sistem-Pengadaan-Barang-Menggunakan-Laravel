<?php

namespace App\Http\Controllers\Admin;

use Pdf;
use App\Models\Vendor;
use App\Models\Kategori;
use App\Models\Pengadaan;
use App\Models\ApprovalLog;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Models\PengadaanItem;
use App\Models\Perintahorder;
use App\Models\PerintahorderItem;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PerintahorderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.perintahorder.index');
    }

    public function getData(Request $request)
    {
        $query = Perintahorder::with(['vendor', 'pengadaan'])->orderBy('id', 'desc')->get(); // asumsi relasi

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('vendor', fn($row) => $row->vendor->nama_perusahaan ?? '-') // contoh relasi
            ->addColumn('pengadaan', fn($row) => $row->pengadaan->keterangan ?? '-')
            ->addColumn('action', function($row) {
                $id = $row->id;
                $btn = '<a href="'.route('perintahorder.show', $id).'" class="btn btn-sm btn-info">Show</a> ';
                $btn .= '<a href="'.route('perintahorder.edit', $id).'" class="btn btn-sm btn-warning">Edit</a> ';
                $btn .= '<form action="#" method="POST" style="display:inline-block;">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Yakin hapus data ini?\')">Hapus</button>
                        </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usedPengadaanIds = Perintahorder::pluck('pengadaan_id');
        $pengadaans = Pengadaan::whereNotIn('id', $usedPengadaanIds)
                        ->where('status', 'finish_procurement')
                        ->get();
        $units = Unit::all();

        return view('pages.admin.perintahorder.create', compact('pengadaans', 'units'));
    }

    public function getVendorsByPengadaan($pengadaanId)
    {
        $kategoriIds = PengadaanItem::where('pengadaan_id', $pengadaanId)
            ->pluck('kategori_id')
            ->unique();

        $vendors = Vendor::whereIn('kategori_id', $kategoriIds)->get();

        return response()->json($vendors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getBarangByPengadaanAndVendor($pengadaanId, $vendorId)
    {
        $vendor = Vendor::findOrFail($vendorId);
        $kategoriId = $vendor->kategori_id;

        $items = PengadaanItem::where('pengadaan_id', $pengadaanId)
                    ->where('kategori_id', $kategoriId)
                    ->get()
                    ->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'nama' => $item->nama,
                            'judul_buku' => $item->judul_buku,
                            'jumlah' => $item->jumlah,
                            'rab' => $item->rab,
                            'catatan_finance' => $item->catatan_finance,
                            'catatan_direktur' => $item->catatan_direktur,
                            'status_finance' => $item->status_finance,
                            'status_direktur' => $item->status_direktur,
                        ];
                    });

        return response()->json($items);
    }
    
    public function store(Request $request)
    {
        $now = \Carbon\Carbon::now();
        $year = $now->year;
        $month = $now->month;

        // Format bulan romawi
        $bulanRomawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV',
            5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII',
            9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];

        // Hitung total data yg sudah ada
        $totalData = Perintahorder::count();
        $nextNumber = $totalData + 1;

        // Format: 00001/SPO.UM/Pengadaan/VII/2025
        $noSurat = str_pad($nextNumber, 5, '0', STR_PAD_LEFT)
            . '/SPO.UM/Pengadaan/' . $bulanRomawi[$month] . '/' . $year;


        $request->validate([
            'pengadaan_id' => 'required|exists:pengadaans,id',
            'vendor_id' => 'required|exists:vendors,id',
            'unit_id' => 'required|exists:units,id',
            'nama_pemesan' => 'required|string',
            'alamat_pemesan' => 'required|string',
            'no_telp' => 'required|string',
            'contact_person' => 'required|string',
            'email' => 'required|string',
            'tanggal' => 'required|date',
        ]);
        // dd($request->all());

        DB::beginTransaction();
        try {
            // Simpan ke tabel perintahorders
            $perintahOrder = Perintahorder::create([
                'pengadaan_id'    => $request->pengadaan_id,
                'vendor_id'       => $request->vendor_id,
                'unit_id'         => $request->unit_id,
                'no_surat'        => $noSurat,
                'tanggal'         => $request->tanggal,
                'nama_pemesan'    => $request->nama_pemesan,
                'alamat_pemesan'  => $request->alamat_pemesan,
                'diskon'  => $request->diskon,
                'ppn'  => $request->ppn,
                'no_telp'  => $request->no_telp,
                'contact_person'  => $request->contact_person,
                'email'  => $request->email,
                'catatan'  => $request->catatan,
            ]);

            // Simpan ke tabel perintahorder_items
            foreach ($request->data as $item) {
                PerintahorderItem::create([
                    'perintahorder_id'     => $perintahOrder->id,
                    'pengadaan_item_id'    => $item['pengadaan_item_id'],
                    'qty'                  => $item['qty'],
                    'rab'                  => $item['rab'],
                ]);
            }

            DB::commit();

            return redirect()->route('perintahorder.index')
                ->with('success', 'Perintah Order berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Perintah Order Error', ['message' => $e->getMessage()]);
            return back()->with('error', 'Gagal menyimpan Perintah Order: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $po = Perintahorder::with(['poitem'])->findOrFail($id);

        return view('pages.admin.perintahorder.show', compact('po'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pengadaan = Pengadaan::all();
        $po = Perintahorder::with(['pengadaan', 'vendor'])->findOrFail($id);
        $items = PerintahorderItem::with('items')->where('perintahorder_id', $po->id)->get();
        $units = Unit::all();

        return view('pages.admin.perintahorder.edit', compact('po', 'pengadaan', 'items', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'tanggal' => 'required|date',
            'nama_pemesan' => 'required|string|max:255',
            'alamat_pemesan' => 'required|string|max:255',
            'no_telp' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'contact_person' => 'required|string|max:255',
            'catatan' => 'nullable|string',
            'data' => 'required|array|min:1',
            'data.*.pengadaan_item_id' => 'required|exists:pengadaan_items,id',
            'data.*.qty' => 'required|numeric|min:1',
            'data.*.rab' => 'required|numeric|min:0',
        ]);

        $po = Perintahorder::findOrFail($id);

        // Update data PO
        $po->update([
            'pengadaan_id' => $request->pengadaan_id,
            'vendor_id' => $request->vendor_id,
            'unit_id' => $request->unit_id,
            'tanggal' => $request->tanggal,
            'nama_pemesan' => $request->nama_pemesan,
            'alamat_pemesan' => $request->alamat_pemesan,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'contact_person' => $request->contact_person,
            'catatan' => $request->catatan,
        ]);

        // Hapus item lama dan ganti dengan yang baru
        PerintahorderItem::where('perintahorder_id', $po->id)->delete();

        foreach ($request->data as $item) {
            PerintahorderItem::create([
                'perintahorder_id' => $po->id,
                'pengadaan_item_id' => $item['pengadaan_item_id'],
                'qty' => $item['qty'],
                'rab' => (float) str_replace('.', '', $item['rab']),
            ]);
        }

        return redirect()->route('perintahorder.index')->with('success', 'Perintah Order berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function generatePDF($id)
    {
        $po = Perintahorder::with(['poitem', 'pengadaan.checker'])->findOrFail($id);
        $approvalLogs = ApprovalLog::where('pengadaan_id', $po->pengadaan_id)
                        ->orderBy('tanggal_approval')
                        ->get();

        // Hitung total & diskon
        // $grandTotal = 0;
        // foreach ($po->pengadaan->items as $item) {
        //     $grandTotal += $item->anggaran * $item->jumlah;
        // }

        // $diskonPersen = $po->diskon ?? 0;
        // $nilaiDiskon = $grandTotal * ($diskonPersen / 100);
        // $grandTotalAfterDiskon = $grandTotal - $nilaiDiskon;

        $pdf = PDF::loadView('pages.admin.perintahorder.generatePdf', compact('po', 'approvalLogs'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream();
    }

    // PERBANDINGAN VENDOR
    public function createVendorOffer(Request $request)
    {
        $kategoriId = $request->kategori_id;

        $kategoris = Kategori::all();

        $vendors = collect();
        $items = collect();

        if ($kategoriId) {
            $vendors = Vendor::where('kategori_id', $kategoriId)->get();

            $items = PengadaanItem::with('barang')
                ->whereHas('barang', function ($q) use ($kategoriId) {
                    $q->where('kategori_id', $kategoriId);
                })->get();
        }

        return view('pages.admin.perintahorder.perbandingan', compact('kategoris', 'vendors', 'items', 'kategoriId'));
    }

    public function getItems(Request $request)
    {
        $request->validate([
            'pengadaan_id' => 'required|exists:pengadaans,id',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $pengadaan = Pengadaan::with(['items' => function ($query) use ($request) {
            $query->where('kategori_id', $request->kategori_id);
        }])->findOrFail($request->pengadaan_id);

        $items = $pengadaan->items;

        return response()->json([
            'items' => $items
        ]);
    }
}
