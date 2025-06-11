<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\TaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PengadaanController;
use App\Http\Controllers\Admin\FormvendorController;
use App\Http\Controllers\Admin\KebutuhantaController;
use App\Http\Controllers\Admin\PerintahorderController;

// Route::get('/', function () {
//     return view('welcome');
// });

// AUTH
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/prosLogin', [LoginController::class, 'prosLogin'])->name('prosLogin');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('admin')
    ->namespace('')
    ->group(function(){
        Route::group(['middleware' => ['auth']], function() {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

            // TAHUN AJARAN
            Route::resource('ta', TaController::class);

            // KATEGORI
            Route::resource('kategori', KategoriController::class)->middleware('UserAkses:Admin,Procurement,Staff Procurement');

            // VENDOR
            Route::resource('vendor', VendorController::class)->middleware('UserAkses:Admin,Procurement,Staff Procurement');

            // USER
            Route::resource('user', UserController::class);

            // APROVAL
            // KEPSEK
            Route::get('pengadaan/{id}/approvalKepsek', [PengadaanController::class, 'approvalKepsek'])->name('approvalKepsek');
            Route::post('pengadaan/{id}/approvalKepsekProses', [PengadaanController::class, 'approvalKepsekProses'])->name('approvalKepsekProses');

            // FINANCE
            Route::get('pengadaan/{id}/approvalFinance', [PengadaanController::class, 'approvalFinance'])->name('approvalFinance');
            Route::post('pengadaan/{id}/approvalFinanceProses', [PengadaanController::class, 'approvalFinanceProses'])->name('approvalFinanceProses');

            // APROVAL FINANCE / ITEM
            Route::post('/pengadaan/approve/{id}', [PengadaanController::class, 'approve'])->name('pengadaan.approve');
            Route::post('/pengadaan/reject/{id}', [PengadaanController::class, 'reject'])->name('pengadaan.reject');

            // APROVAL DIRECTOR / ITEM
            Route::post('/pengadaan/approveDirector/{id}', [PengadaanController::class, 'approveDirector'])->name('pengadaan.approveDirector');
            Route::post('/pengadaan/rejectDirector/{id}', [PengadaanController::class, 'rejectDirector'])->name('pengadaan.rejectDirector');

            // DIREKTUR
            Route::get('pengadaan/{id}/approvalDirektur', [PengadaanController::class, 'approvalDirektur'])->name('approvalDirektur');
            Route::post('pengadaan/{id}/approvalDirekturProses', [PengadaanController::class, 'approvalDirekturProses'])->name('approvalDirekturProses');
            
            // PROCUREMENT
            Route::get('pengadaan/{id}/approvalProcurement', [PengadaanController::class, 'approvalProcurement'])->name('approvalProcurement');
            Route::post('pengadaan/{id}/approvalProcurementProses', [PengadaanController::class, 'approvalProcurementProses'])->name('approvalProcurementProses');

            // PENGADAAN
            Route::get('pengadaan/data', [PengadaanController::class, 'getData'])->name('pengadaan.data');
            Route::resource('pengadaan', PengadaanController::class);

            // PENGADAAN PRE ORDER
            Route::get('/perintahorders/barang/{pengadaanId}/{vendorId}', [PerintahorderController::class, 'getBarangByPengadaanAndVendor']);
            Route::get('/perintahorders/vendors/{pengadaan_id}', [PerintahorderController::class, 'getVendorsByPengadaan']);
            Route::get('perintahorder/data', [PerintahorderController::class, 'getData'])->name('perintahorder.data')->middleware('UserAkses:Admin,Procurement,Staff Procurement');
            Route::get('generatePdf/{id}', [PerintahorderController::class, 'generatePdf'])->name('generatePdf')->middleware('UserAkses:Admin,Procurement,Staff Procurement');
            Route::resource('perintahorder', PerintahorderController::class)->middleware('UserAkses:Admin,Procurement,Staff Procurement');

            Route::post('/pengadaan/{id}/status/{status}', [PengadaanController::class, 'updateStatus'])->name('pengadaan.updateStatus');
            Route::post('/pengadaan/{id}/status-with-note/{status}', [PengadaanController::class, 'updateStatusWithNote'])->name('pengadaan.updateStatusWithNote');
        });
    });
