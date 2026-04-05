<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SopController;
use App\Http\Controllers\AdminSopController;
use App\Http\Controllers\KepalaSopController;
use App\Http\Controllers\UmumSopController;
use App\Http\Controllers\DirekturSopController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\UnitController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// =====================
// UNIT
// =====================
// =====================
// UNIT
// =====================
Route::prefix('unit')->group(function () {

Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
    if (session('role') !== 'unit') {
        return redirect()->route('login')->with('error', 'Silakan login sebagai Unit.');
    }

    $keyword = trim($request->keyword ?? '');
    $status = trim($request->status ?? '');
    $filter = trim($request->filter ?? '');

    $statusRevisi = [
        'dikembalikan_admin',
        'dikembalikan_kepala',
        'ditolak_direktur'
    ];

    $notifikasi = DB::table('sops')
        ->leftJoin('catatans', 'sops.id', '=', 'catatans.sop_id')
        ->leftJoin('users', 'catatans.user_id', '=', 'users.id')
        ->select(
            'sops.id',
            'sops.nama_sop',
            'sops.status',
            'catatans.isi_catatan',
            'catatans.created_at as tanggal_catatan',
            'users.name as nama_pemberi_catatan'
        )
        ->where('sops.unit_id', session('unit_id'))
        ->whereIn('sops.status', $statusRevisi)
        ->orderBy('catatans.created_at', 'desc')
        ->limit(5)
        ->get();

    $jumlahNotifikasi = DB::table('sops')
        ->where('unit_id', session('unit_id'))
        ->whereIn('status', $statusRevisi)
        ->count();

    $totalSop = DB::table('sops')
        ->where('unit_id', session('unit_id'))
        ->count();

    $jumlahDraft = DB::table('sops')
        ->where('unit_id', session('unit_id'))
        ->where('status', 'draft')
        ->count();

    $jumlahProses = DB::table('sops')
        ->where('unit_id', session('unit_id'))
        ->whereIn('status', [
            'diajukan',
            'diverifikasi_admin',
            'nomor_booking',
            'nomor_final',
            'dikirim_ke_umum',
            'ditandatangani'
        ])
        ->count();

    $jumlahArsip = DB::table('sops')
        ->where('unit_id', session('unit_id'))
        ->where('status', 'diarsipkan')
        ->count();

    return view('unit.dashboard', [
        'title' => 'Beranda Sistem SOP',
        'notifikasi' => $notifikasi,
        'jumlahNotifikasi' => $jumlahNotifikasi,
        'totalSop' => $totalSop,
        'jumlahDraft' => $jumlahDraft,
        'jumlahProses' => $jumlahProses,
        'jumlahArsip' => $jumlahArsip,
    ]);
})->name('unit.dashboard');
Route::get('/revisi-sop', function () {
    if (session('role') !== 'unit') {
        return redirect()->route('login')->with('error', 'Silakan login sebagai Unit.');
    }

    $statusRevisi = [
        'dikembalikan_admin',
        'dikembalikan_kepala',
        'ditolak_direktur'
    ];

    $sops = DB::table('sops')
        ->join('jenis_sop', 'sops.jenis_sop_id', '=', 'jenis_sop.id')
        ->join('units', 'sops.unit_id', '=', 'units.id')
        ->select(
            'sops.*',
            'jenis_sop.kode_jenis',
            'jenis_sop.nama_jenis',
            'units.kode_unit'
        )
        ->where('sops.unit_id', session('unit_id'))
        ->whereIn('sops.status', $statusRevisi)
        ->orderBy('sops.updated_at', 'desc')
        ->get();

    return view('unit.revisi-sop', [
        'title' => 'Revisi SOP',
        'sops' => $sops
    ]);
})->name('unit.revisi');




Route::get('/sop-saya', function () {
    if (session('role') !== 'unit') {
        return redirect()->route('login')->with('error', 'Silakan login sebagai Unit.');
    }

    $sops = DB::table('sops')
        ->join('jenis_sop', 'sops.jenis_sop_id', '=', 'jenis_sop.id')
        ->join('units', 'sops.unit_id', '=', 'units.id')
        ->select(
            'sops.*',
            'jenis_sop.kode_jenis',
            'jenis_sop.nama_jenis',
            'units.kode_unit'
        )
        ->where('sops.unit_id', session('unit_id'))
        ->orderBy('sops.created_at', 'desc')
        ->get();

    $jenis = DB::table('jenis_sop')
        ->orderBy('kode_jenis')
        ->get();

    return view('unit.sop-saya', [
        'title' => 'SOP Saya',
        'sops' => $sops,
        'jenis' => $jenis
    ]);
})->name('unit.sop');


    

    Route::get('/tambah-sop', function () {
        if (session('role') !== 'unit') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Unit.');
        }

        $jenis = DB::table('jenis_sop')->orderBy('kode_jenis')->get();

        return view('unit.tambah-sop', [
            'title' => 'Tambah SOP',
            'jenis' => $jenis
        ]);
    })->name('unit.tambah');

    Route::post('/simpan-sop', [SopController::class, 'simpan'])->name('unit.simpan');
    Route::get('/sop/{id}/detail', [SopController::class, 'detail'])->name('unit.sop.detail');
    Route::get('/sop/{id}/edit', [SopController::class, 'edit'])->name('unit.sop.edit');
    Route::post('/sop/{id}/update', [SopController::class, 'update'])->name('unit.sop.update');
    Route::get('/arsip', [UnitController::class, 'arsip'])->name('unit.arsip');
    Route::get('/sop/{id}/lihat-final', [SopController::class, 'lihatFinal'])->name('unit.sop.lihatFinal');
    Route::get('/sop/{id}/lihat-draft', [SopController::class, 'lihatDraft'])->name('unit.sop.lihatDraft');
Route::get('/sop/{id}/lihat-surat', [SopController::class, 'lihatSurat'])->name('unit.sop.lihatSurat');
});



////////////
// ADMIN/////////////////
/////////////////

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminSopController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/verifikasi-sop', [AdminSopController::class, 'index'])->name('admin.verifikasi');
    Route::get('/verifikasi-sop/{id}', [AdminSopController::class, 'detail'])->name('admin.verifikasi.detail');
    Route::post('/verifikasi-sop/{id}/verifikasi', [AdminSopController::class, 'verifikasi'])->name('admin.verifikasi.setujui');
    Route::post('/verifikasi-sop/{id}/kembalikan', [AdminSopController::class, 'kembalikan'])->name('admin.verifikasi.kembalikan');
    Route::get('/verifikasi-sop/{id}/lihat-draft', [AdminSopController::class, 'lihatDraft'])->name('admin.verifikasi.lihatDraft');
    Route::get('/verifikasi-sop/{id}/lihat-surat', [AdminSopController::class, 'lihatSurat'])->name('admin.verifikasi.lihatSurat');

    Route::get('/penomoran-sop', [AdminSopController::class, 'penomoran'])->name('admin.penomoran');
    Route::post('/penomoran-sop/{id}/booking', [AdminSopController::class, 'bookingNomor'])->name('admin.penomoran.booking');
    Route::post('/penomoran-sop/{id}/finalisasi', [AdminSopController::class, 'finalisasiNomor'])->name('admin.penomoran.finalisasi');
    Route::post('/penomoran-sop/{id}/generate-file', [AdminSopController::class, 'generateDokumenBernomor'])->name('admin.penomoran.generateFile');
    Route::get('/penomoran-sop/{id}/buka', [AdminSopController::class, 'bukaDokumen'])->name('admin.penomoran.buka');
    Route::get('/penomoran-sop/{id}/download', [AdminSopController::class, 'downloadBernomor'])->name('admin.penomoran.download');

    Route::post('/penomoran-sop/{id}/kirim-umum', [AdminSopController::class, 'kirimKeUmum'])->name('admin.kirim.umum');

    Route::post('/arsip-sop/{id}', [AdminSopController::class, 'arsipkan'])->name('sop.arsip');
    Route::get('/arsip-sop', [AdminSopController::class, 'arsip'])->name('admin.arsip');
    Route::get('/final-sop', [AdminSopController::class, 'finalDirektur'])->name('admin.final');
});



///////////////
//KEPALA///////////
/////////////////

Route::prefix('kepala')->group(function () {
    Route::get('/dashboard', function () {
        if (session('role') !== 'kepala_pusat') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Kepala Pusat.');
        }

        return view('kepala.dashboard', ['title' => 'Dashboard Kepala Pusat']);
    })->name('kepala.dashboard');

    Route::get('/review-sop', [KepalaSopController::class, 'index'])->name('kepala.review');
    Route::get('/review-sop/{id}', [KepalaSopController::class, 'detail'])->name('kepala.review.detail');
    Route::get('/review-sop/{id}/lihat-draft', [KepalaSopController::class, 'lihatDraft'])->name('kepala.review.lihatDraft');
    Route::get('/review-sop/{id}/lihat-surat', [KepalaSopController::class, 'lihatSurat'])->name('kepala.review.lihatSurat');
    Route::post('/review-sop/{id}/setujui', [KepalaSopController::class, 'setujui'])->name('kepala.review.setujui');
    Route::post('/review-sop/{id}/kembalikan', [KepalaSopController::class, 'kembalikan'])->name('kepala.review.kembalikan');
});


// =====================
// BAGIAN UMUM
// =====================
// =====================
// BAGIAN UMUM
// =====================
Route::prefix('umum')->group(function () {
    Route::get('/dashboard', [UmumSopController::class, 'dashboard'])->name('umum.dashboard');
    Route::get('/sop-masuk', [UmumSopController::class, 'index'])->name('umum.sop');
    Route::post('/sop/{id}/kirim-direktur', [UmumSopController::class, 'kirimKeDirektur'])->name('umum.kirim.direktur');
    Route::get('/sop/{id}/download', [UmumSopController::class, 'downloadDokumen'])->name('umum.download');
});


// =====================
// DIREKTUR
// =====================
Route::prefix('direktur')->group(function () {
    Route::get('/dashboard', [DirekturSopController::class, 'dashboard'])->name('direktur.dashboard');
    Route::get('/persetujuan', [DirekturSopController::class, 'index'])->name('direktur.sop');
    Route::get('/persetujuan/{id}', [DirekturSopController::class, 'detail'])->name('direktur.sop.detail');
    Route::get('/persetujuan/{id}/download', [DirekturSopController::class, 'downloadDokumen'])->name('direktur.download');
    Route::post('/persetujuan/{id}/sahkan', [DirekturSopController::class, 'sahkan'])->name('direktur.sop.sahkan');
});