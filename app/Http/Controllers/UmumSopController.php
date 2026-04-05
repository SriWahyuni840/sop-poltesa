<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UmumSopController extends Controller
{
    public function index()
    {
        if (session('role') !== 'bagian_umum') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Bagian Umum.');
        }

        $sops = DB::table('sops')
            ->join('units', 'sops.unit_id', '=', 'units.id')
            ->join('jenis_sop', 'sops.jenis_sop_id', '=', 'jenis_sop.id')
            ->leftJoin('nomor_sops', 'sops.id', '=', 'nomor_sops.sop_id')
            ->select(
                'sops.*',
                'units.kode_unit',
                'units.nama_unit',
                'jenis_sop.kode_jenis',
                'jenis_sop.nama_jenis',
                'nomor_sops.nomor_sop'
            )
            ->whereIn('sops.status', [
                'dikirim_ke_umum',
                'dikirim_ke_direktur',
                'ditandatangani'
            ])
            ->orderBy('sops.updated_at', 'desc')
            ->get();

        return view('umum.sop-masuk', [
            'title' => 'SOP Masuk Bagian Umum',
            'sops' => $sops
        ]);
    }

    public function dashboard()
{
    if (session('role') !== 'bagian_umum') {
        return redirect()->route('login')->with('error', 'Silakan login sebagai Bagian Umum.');
    }

    $tahun = now()->year;

    $totalSopMasuk = DB::table('sops')
        ->whereIn('status', ['dikirim_ke_umum', 'dikirim_ke_direktur', 'ditandatangani'])
        ->count();

    $jumlahPerluDikirim = DB::table('sops')
        ->where('status', 'dikirim_ke_umum')
        ->count();

    $jumlahSudahKeDirektur = DB::table('sops')
        ->where('status', 'dikirim_ke_direktur')
        ->count();

    $jumlahSudahDitandatangani = DB::table('sops')
        ->where('status', 'ditandatangani')
        ->count();

    $chartStatus = [
        'Dikirim ke Umum' => $jumlahPerluDikirim,
        'Dikirim ke Direktur' => $jumlahSudahKeDirektur,
        'Ditandatangani' => $jumlahSudahDitandatangani,
    ];

    $rawBulanan = DB::table('sops')
        ->selectRaw('MONTH(updated_at) as bulan, COUNT(*) as total')
        ->whereYear('updated_at', $tahun)
        ->whereIn('status', ['dikirim_ke_umum', 'dikirim_ke_direktur', 'ditandatangani'])
        ->groupByRaw('MONTH(updated_at)')
        ->orderByRaw('MONTH(updated_at)')
        ->pluck('total', 'bulan')
        ->toArray();

    $labelBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    $dataBulanan = [];

    for ($i = 1; $i <= 12; $i++) {
        $dataBulanan[] = $rawBulanan[$i] ?? 0;
    }

    return view('umum.dashboard', [
        'title' => 'Dashboard Bagian Umum',
        'tahun' => $tahun,
        'totalSopMasuk' => $totalSopMasuk,
        'jumlahPerluDikirim' => $jumlahPerluDikirim,
        'jumlahSudahKeDirektur' => $jumlahSudahKeDirektur,
        'jumlahSudahDitandatangani' => $jumlahSudahDitandatangani,
        'chartStatus' => $chartStatus,
        'labelBulan' => $labelBulan,
        'dataBulanan' => $dataBulanan,
    ]);
}



    public function kirimKeDirektur($id)
    {
        if (session('role') !== 'bagian_umum') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Bagian Umum.');
        }

        $sop = DB::table('sops')->where('id', $id)->first();

        if (!$sop) {
            return redirect()->route('umum.sop')->with('error', 'SOP tidak ditemukan.');
        }

        if ($sop->status !== 'dikirim_ke_umum') {
            return redirect()->route('umum.sop')->with('error', 'Hanya SOP yang sudah dikirim ke Bagian Umum yang bisa diteruskan ke Direktur.');
        }

        if (empty($sop->file_bernomor)) {
            return redirect()->route('umum.sop')->with('error', 'File bernomor belum tersedia.');
        }

        DB::table('sops')
            ->where('id', $id)
            ->update([
                'status' => 'dikirim_ke_direktur',
                'updated_at' => now()
            ]);

        return redirect()->route('umum.sop')->with('success', 'SOP berhasil dikirim ke Direktur.');
    }

    public function downloadDokumen($id)
    {
        if (session('role') !== 'bagian_umum') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Bagian Umum.');
        }

        $sop = DB::table('sops')->where('id', $id)->first();

        if (!$sop) {
            return redirect()->route('umum.sop')->with('error', 'SOP tidak ditemukan.');
        }

        if (!empty($sop->file_final)) {
            $pathFinal = storage_path('app/public/' . $sop->file_final);

            if (file_exists($pathFinal) && !is_dir($pathFinal)) {
                return response()->download($pathFinal);
            }
        }

        if (!empty($sop->file_bernomor)) {
            $pathBernomor = storage_path('app/public/' . $sop->file_bernomor);

            if (file_exists($pathBernomor) && !is_dir($pathBernomor)) {
                return response()->download($pathBernomor);
            }
        }

        return redirect()->route('umum.sop')->with('error', 'File dokumen tidak ditemukan.');
    }
}