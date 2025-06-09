<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pengadaan;
use App\Models\ApprovalLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isUnitUser = in_array($user->role, ['Kepala Sekolah']);

        // Filter data berdasarkan unit jika user adalah kepala sekolah
        $pengadaanQuery = $isUnitUser
            ? Pengadaan::where('unit', $user->unit)
            : Pengadaan::query();

        return view('pages.admin.dashboard', [
            'pengadaan' => $pengadaanQuery->get(),
            'totalPengadaan' => $pengadaanQuery->count(),
            'pengadaanDraft' => (clone $pengadaanQuery)->where('status', 'pending')->count(),
            'pengadaanApproved' => (clone $pengadaanQuery)->where('status', 'completed')->count(),
            'pengadaanRejected' => (clone $pengadaanQuery)->whereIn('status', [
                'rejected_director',
                'rejected_finance',
                'rejected_procurement',
            ])->count(),
            'latestPengadaan' => (clone $pengadaanQuery)->latest()->take(5)->get(),

            // Log approval terakhir oleh user login
            'lastLog' => ApprovalLog::whereIn('status', ['approved', 'rejected', 'accepted', 'Finish Review'])
                ->where('user_id', $user->id)
                ->where('role', $user->role)
                ->latest()
                ->first(),

            'lastLogProcurement' => ApprovalLog::where('status', 'accepted')
                ->latest()
                ->first(),

            'lastLogProcurementFinish' => Pengadaan::where('status', 'finish')
                ->latest()
                ->first(),

            // Data untuk role yang sesuai
            'pengadaanMenungguDirektur' => (clone $pengadaanQuery)->where('status', 'approved_finance')->get(),
            'pengadaanMenungguFinance' => (clone $pengadaanQuery)->where('status', 'pending')->get(),
            'pengadaanMenungguProcurement' => (clone $pengadaanQuery)->where('status', 'approved_director')->get(),

            // Notifikasi approval
            'pendingForSupervisor' => (clone $pengadaanQuery)->where('status', 'menunggu-supervisor')->count(),
            'pendingForFinance' => (clone $pengadaanQuery)->whereIn('status', ['validated_kepsek', 'pending'])->count(),
            'pendingForDirektur' => (clone $pengadaanQuery)->where('status', 'validated_finance')->count(),
            'pendingForProcurement' => (clone $pengadaanQuery)->where('status', 'approved_director')->count(),
        ]);
    }

}
