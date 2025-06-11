<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kategori;
use App\Models\Pengadaan;
use App\Models\ApprovalLog;
use Illuminate\Http\Request;
use App\Models\PengadaanItem;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PengadaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $pengadaans = Pengadaan::with('items', 'approvalLogs')->get();

        return view('pages.admin.pengadaan.index');
    }

    public function getData(Request $request)
    {
        try {
            $user = auth()->user();

            $query = Pengadaan::query();

            if ($request->status) {
                $query->where('status', $request->status);
            }

            if ($request->unit) {
                $query->where('unit', $request->unit);
            }

            if ($request->date_start && $request->date_end) {
                $query->whereBetween('tanggal_pengajuan', [$request->date_start, $request->date_end]);
            }

            if ($user->unit) {
                $query->where('unit', $user->unit);
            }

            $pengadaans = $query->orderBy('id', 'desc')->get();

            return DataTables::of($pengadaans)
                ->addIndexColumn()
                ->addColumn('user_info', function ($row) {
                    return optional($row->user)->name . ' (' . optional($row->user)->role . ')';
                })
                ->addColumn('unit_label', function ($row) {
                    return view('pages.admin.pengadaan._unit', compact('row'))->render();
                })
                ->addColumn('keterangan', fn($row) => $row->keterangan)
                ->addColumn('tanggal_pengajuan', fn($row) => \Carbon\Carbon::parse($row->tanggal_pengajuan)->format('d-m-Y'))
                ->addColumn('status_label', function ($row) {
                    return view('pages.admin.pengadaan._status', compact('row'))->render();
                })
                ->addColumn('action', function ($row) {
                    return view('pages.admin.pengadaan._action', compact('row'))->render();
                })
                ->rawColumns(['status_label', 'action', 'unit_label'])
                ->make(true);

        } catch (\Exception $e) {
            \Log::error('getData error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();

        return view('pages.admin.pengadaan.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'nullable|string',
            'items.*.nama' => 'required|string',
            'items.*.fungsi' => 'string',
            'items.*.ukuran' => 'min:0',
            'items.*.type' => 'string|min:0',
            'items.*.jumlah' => 'required|numeric|min:0',
            'items.*.rab' => 'required|string|min:0',
            'items.*.merk' => 'required|string|min:0',
        ]);
    
        // Simpan pengadaan utama
        $pengadaan = Pengadaan::create([
            'user_id' => auth()->id(),
            'tanggal_pengajuan' => now(),
            'status' => 'pending', // default status awal
            'keterangan' => $request->keterangan,
            'unit' => $request->unit,
        ]);
    
        // Simpan item-itemnya
        foreach ($request->items as $item) {
            $pengadaan->items()->create([
                'nama' => $item['nama'],
                'fungsi' => $item['fungsi'],
                'ukuran' => $item['ukuran'],
                'type' => $item['type'],
                'jumlah' => $item['jumlah'],
                'rab' => $item['rab'],
                'merk' => $item['merk'],
                'kategori_id' => $item['kategori_id'],
            ]);
        }
    
        return redirect()->route('pengadaan.index')->with('success', 'Pengadaan barang berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengadaan = Pengadaan::with('items', 'approvalLogs')->findOrFail($id);

        return view('pages.admin.pengadaan.show', compact('pengadaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // VALIDATED KEPSEK
    public function approvalKepsek($id)
    {
        $pengadaan = Pengadaan::findOrFail($id);

        return view('pages.admin.approval.approvalFinance', compact('pengadaan'));
    }

    public function approvalKepsekProses(Request $request, $id)
    {
        $request->validate([
            'komentar' => 'nullable|string',
            'status' => 'required|in:validated,approved,rejected',
        ]);

        $pengadaan = Pengadaan::findOrFail($id);

        // Tambah ke approval_logs
        ApprovalLog::create([
            'pengadaan_id' => $pengadaan->id,
            'user_id' => Auth::id(),
            'role' => Auth::user()->role, // pastikan role disimpan
            'status' => $request->status,
            'tanggal_approval' => now(),
            'komentar' => $request->komentar,
        ]);

        // Update status akhir di pengadaan
        $statusMap = [
            'Kepala Sekolah' => ['validated' => 'validated_kepsek', 'rejected' => 'rejected_kepsek'],
            'Finance' => ['validated' => 'validated_finance', 'rejected' => 'rejected_finance'],
            'Direktur' => ['approved' => 'approved_director', 'rejected' => 'rejected_director'],
            'Procurement' => ['validated' => 'validated_procurement', 'rejected' => 'rejected_procurement'],
        ];

        $role = Auth::user()->role;
        $pengadaan->update([
            'status' => $statusMap[$role][$request->status],
        ]);

        return redirect()->route('pengadaan.show', $pengadaan->id)->with('success', 'Berhasil disimpan.');
    }

    // VALIDATED FINANCE

    public function approvalFinance($id)
    {
        $pengadaan = Pengadaan::findOrFail($id);

        return view('pages.admin.approval.approvalFinance', compact('pengadaan'));
    }

    public function approvalFinanceProses(Request $request, $id)
    {
        $request->validate([
            'komentar' => 'nullable|string',
            'status' => 'required|in:validated,approved,rejected',
        ]);

        $pengadaan = Pengadaan::findOrFail($id);

        // Tambah ke approval_logs
        ApprovalLog::create([
            'pengadaan_id' => $pengadaan->id,
            'user_id' => Auth::id(),
            'role' => Auth::user()->role, // pastikan role disimpan
            'status' => $request->status,
            'tanggal_approval' => now(),
            'komentar' => $request->komentar,
        ]);

        // Update status akhir di pengadaan
        $statusMap = [
            'Finance' => ['validated' => 'validated_finance', 'rejected' => 'rejected_finance'],
            'Direktur' => ['approved' => 'approved_director', 'rejected' => 'rejected_director'],
            'Procurement' => ['validated' => 'validated_procurement', 'rejected' => 'rejected_procurement'],
        ];

        $role = Auth::user()->role;
        $pengadaan->update([
            'status' => $statusMap[$role][$request->status],
        ]);

        return redirect()->route('pengadaan.show', $pengadaan->id)->with('success', 'Berhasil disimpan.');
    }

    // APPROVED DIREKTUR

    public function approvalDirektur($id)
    {
        $pengadaan = Pengadaan::findOrFail($id);
        return view('pages.admin.approval.approvalDirektur', compact('pengadaan'));
    }

    public function approvalDirekturProses(Request $request, $id)
    {
        $request->validate([
            'komentar' => 'nullable|string',
            'status' => 'required|in:approved,rejected',
        ]);

        $pengadaan = Pengadaan::findOrFail($id);

        // Tambah ke approval_logs
        ApprovalLog::create([
            'pengadaan_id' => $pengadaan->id,
            'user_id' => Auth::id(),
            'role' => Auth::user()->role, // pastikan role disimpan
            'status' => $request->status,
            'tanggal_approval' => now(),
            'komentar' => $request->komentar,
        ]);

        // Update status akhir di pengadaan
        $statusMap = [
            'Finance' => ['validated' => 'validated_finance', 'rejected' => 'rejected_finance'],
            'Director' => ['approved' => 'approved_director', 'rejected' => 'rejected_director'],
            'Procurement' => ['validated' => 'validated_procurement', 'rejected' => 'rejected_procurement'],
        ];

        $role = Auth::user()->role;
        $pengadaan->update([
            'status' => $statusMap[$role][$request->status],
        ]);

        return redirect()->route('pengadaan.show', $pengadaan->id)->with('success', 'Approval berhasil disimpan.');
    }

    // APPROVED PROCUREMENT

    public function approvalProcurement($id)
    {
        $pengadaan = Pengadaan::findOrFail($id);
        return view('pages.admin.approval.approvalProcurement', compact('pengadaan'));
    }

    public function approvalProcurementProses(Request $request, $id)
    {
        $request->validate([
            'komentar' => 'nullable|string',
            'status' => 'required|in:validated,approved,rejected,Finish Review',
        ]);

        $pengadaan = Pengadaan::findOrFail($id);

        // Tambah ke approval_logs
        ApprovalLog::create([
            'pengadaan_id' => $pengadaan->id,
            'user_id' => Auth::id(),
            'role' => Auth::user()->role, // pastikan role disimpan
            'status' => $request->status,
            'tanggal_approval' => now(),
            'komentar' => $request->komentar,
        ]);

        // Update status akhir di pengadaan
        $statusMap = [
            'Finance' => ['validated' => 'validated_finance', 'rejected' => 'rejected_finance'],
            'Director' => ['approved' => 'approved_director', 'rejected' => 'rejected_director'],
            'Procurement' => ['Finish Review' => 'finish_procurement', 'rejected' => 'rejected_procurement'],
        ];

        $role = Auth::user()->role;
        $pengadaan->update([
            'status' => $statusMap[$role][$request->status],
        ]);

        return redirect()->route('pengadaan.show', $pengadaan->id)->with('success', 'Telah direview.');
    }

    // GENERATE SPO PROCUREMENT
    public function generateSPO($id)
    {
        $pengadaan = Pengadaan::with('items')->findOrFail($id);

        return view('pages.admin.spo.index', compact('pengadaan'));
    }

    // UPDATE STATUS
    public function updateStatus(Request $request, $id, $status)
    {
        $pengadaan = Pengadaan::findOrFail($id);

        // Update kolom status utama di tabel pengadaans
        $pengadaan->status = $status;
        $pengadaan->save();

        // Catat juga ke riwayat approval_logs
        ApprovalLog::create([
            'pengadaan_id' => $pengadaan->id,
            'user_id' => Auth::id(),
            'role' => Auth::user()->role, // pastikan kamu punya ini di user
            'status' => $status,
            'tanggal_approval' => now(),
            'komentar' => $request->komentar ?? $this->getKomentarByStatus($status),
        ]);

        return back()->with('success', 'Status updated successfully.');
    }

    private function getKomentarByStatus($status)
    {
        return [
            'purchased' => 'Being purchased by procurement',
            'distributed' => 'Has been distributed by procurement',
            'completed' => 'Has been received by the unit all complete, procurement is complete',
        ][$status] ?? null;
    }

    // UPDATE STATUS ACCEPTED WITH NOTE
    public function updateStatusWithNote(Request $request, $id, $status)
    {
        $pengadaan = Pengadaan::findOrFail($id);

        $pengadaan->status = $status;
        $pengadaan->save();

        ApprovalLog::create([
            'pengadaan_id' => $pengadaan->id,
            'user_id' => Auth::id(),
            'role' => Auth::user()->role,
            'status' => $status,
            'tanggal_approval' => now(),
            'komentar' => $request->komentar ?? $this->getKomentarByStatus($status),
        ]);

        return back()->with('success', 'Status updated successfully.');
    }


    // VALIDATED BY FINANCE / ITEM
    public function approve(Request $request, $id)
    {
        $item = PengadaanItem::findOrFail($id);
        $item->update([
            'status_finance' => 'checked',
            'catatan_finance' => $request->catatan
        ]);

        $this->checkFinanceStatus($item->pengadaan_id); // ✅ pakai pengadaan_id!

        return back()->with('success', 'Item disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $item = PengadaanItem::findOrFail($id);
        $item->update([
            'status_finance' => 'rejected',
            'catatan_finance' => $request->catatan
        ]);

        $this->checkFinanceStatus($item->pengadaan_id); // ✅ pakai pengadaan_id!

        return back()->with('rejected', 'Item tidak disetujui.');
    }

    private function checkFinanceStatus($pengadaanId)
    {
        $items = PengadaanItem::where('pengadaan_id', $pengadaanId)->get();

        // Jangan update status di sini! Cuma validasi saja
        if ($items->whereNull('status_finance')->count() > 0 || $items->where('status_finance', '')->count() > 0) {
            return false; // Masih ada yang belum diperiksa
        }

        return true; // Semua item sudah diperiksa (approved atau rejected)
    }


    // APPROVED BY DIRECTOR / ITEM
    public function approveDirector(Request $request, $id)
    {
        $item = PengadaanItem::findOrFail($id);
        $item->update([
            'status_direktur' => 'approved',
            'catatan_direktur' => $request->catatan
        ]);

        $this->checkDirectorStatus($item->pengadaan_id); // ✅ pakai pengadaan_id!

        return back()->with('success', 'Item disetujui.');
    }

    public function rejectDirector(Request $request, $id)
    {
        $item = PengadaanItem::findOrFail($id);
        $item->update([
            'status_direktur' => 'rejected',
            'catatan_direktur' => $request->catatan
        ]);

        $this->checkDirectorStatus($item->pengadaan_id); // ✅ pakai pengadaan_id!

        return back()->with('rejected', 'Item tidak disetujui.');
    }

    private function checkDirectorStatus($pengadaanId)
    {
        $items = PengadaanItem::where('pengadaan_id', $pengadaanId)->get();

        // Jangan update status di sini! Cuma validasi saja
        if ($items->whereNull('status_direktur')->count() > 0 || $items->where('status_direktur', '')->count() > 0) {
            return false; // Masih ada yang belum diperiksa
        }

        return true; // Semua item sudah diperiksa (approved atau rejected)
    }

}
