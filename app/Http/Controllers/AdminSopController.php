<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\TemplateProcessor;

class AdminSopController extends Controller
{
    public function index()
    {
        if (session('role') !== 'admin_p2mpp') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Admin P2MPP.');
        }

        $sops = DB::table('sops')
            ->join('units', 'sops.unit_id', '=', 'units.id')
            ->join('jenis_sop', 'sops.jenis_sop_id', '=', 'jenis_sop.id')
            ->select(
                'sops.*',
                'units.kode_unit',
                'units.nama_unit',
                'jenis_sop.kode_jenis',
                'jenis_sop.nama_jenis'
            )
            ->where('sops.status', 'diajukan')
            ->orderBy('sops.created_at', 'desc')
            ->get();

        return view('admin.verifikasi-sop', [
            'title' => 'Verifikasi SOP',
            'sops' => $sops
        ]);
    }

    public function detail($id)
    {
        if (session('role') !== 'admin_p2mpp') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Admin P2MPP.');
        }

        $sop = DB::table('sops')
            ->join('units', 'sops.unit_id', '=', 'units.id')
            ->join('jenis_sop', 'sops.jenis_sop_id', '=', 'jenis_sop.id')
            ->select(
                'sops.*',
                'units.kode_unit',
                'units.nama_unit',
                'jenis_sop.kode_jenis',
                'jenis_sop.nama_jenis'
            )
            ->where('sops.id', $id)
            ->first();

        if (!$sop) {
            return redirect()->route('admin.verifikasi')->with('error', 'Data SOP tidak ditemukan.');
        }

        $catatans = DB::table('catatans')
            ->join('users', 'catatans.user_id', '=', 'users.id')
            ->select('catatans.*', 'users.name')
            ->where('catatans.sop_id', $id)
            ->orderBy('catatans.created_at', 'desc')
            ->get();

        return view('admin.detail-verifikasi-sop', [
            'title' => 'Detail Verifikasi SOP',
            'sop' => $sop,
            'catatans' => $catatans
        ]);
    }

    public function verifikasi($id)
    {
        if (session('role') !== 'admin_p2mpp') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Admin P2MPP.');
        }

        $sop = DB::table('sops')->where('id', $id)->first();

        if (!$sop) {
            return redirect()->route('admin.verifikasi')->with('error', 'Data SOP tidak ditemukan.');
        }

        if ($sop->status !== 'diajukan') {
            return redirect()->route('admin.verifikasi')->with('error', 'Hanya SOP berstatus diajukan yang bisa diverifikasi.');
        }

        DB::table('sops')
            ->where('id', $id)
            ->update([
                'status' => 'diverifikasi_admin',
                'updated_at' => now()
            ]);

        return redirect()->route('admin.verifikasi')->with('success', 'SOP berhasil diverifikasi admin.');
    }

    public function kembalikan(Request $request, $id)
    {
        if (session('role') !== 'admin_p2mpp') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Admin P2MPP.');
        }

        $request->validate([
            'isi_catatan' => 'required|string'
        ]);

        $sop = DB::table('sops')->where('id', $id)->first();

        if (!$sop) {
            return redirect()->route('admin.verifikasi')->with('error', 'Data SOP tidak ditemukan.');
        }

        DB::table('sops')
            ->where('id', $id)
            ->update([
                'status' => 'dikembalikan_admin',
                'updated_at' => now()
            ]);

        DB::table('catatans')->insert([
            'sop_id' => $id,
            'user_id' => session('user_id'),
            'jenis_catatan' => 'verifikasi_admin',
            'isi_catatan' => $request->isi_catatan,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.verifikasi')->with('success', 'SOP dikembalikan ke unit.');
    }

public function penomoran(Request $request)
{
    if (session('role') !== 'admin_p2mpp') {
        return redirect()->route('login')->with('error', 'Silakan login sebagai Admin P2MPP.');
    }

    $statusFilter = $request->get('status');

    $allowedStatuses = [
        'diverifikasi_admin',
        'nomor_booking',
        'disetujui_kepala',
        'nomor_final',
        'dikirim_ke_umum',
        'dikirim_ke_direktur'
    ];

    $statusLabels = [
        'diverifikasi_admin' => 'Diverifikasi Admin',
        'nomor_booking' => 'Nomor Booking',
        'disetujui_kepala' => 'Disetujui Kepala',
        'nomor_final' => 'Nomor Final',
        'dikirim_ke_umum' => 'Dikirim ke Umum',
        'dikirim_ke_direktur' => 'Dikirim ke Direktur',
    ];

    $belumDinomori = DB::table('sops')
        ->join('units', 'sops.unit_id', '=', 'units.id')
        ->join('jenis_sop', 'sops.jenis_sop_id', '=', 'jenis_sop.id')
        ->leftJoin('nomor_sops', 'sops.id', '=', 'nomor_sops.sop_id')
        ->select(
            'sops.*',
            'units.kode_unit',
            'units.nama_unit',
            'jenis_sop.kode_jenis',
            'jenis_sop.nama_jenis',
            'nomor_sops.nomor_sop',
            'nomor_sops.status_nomor'
        )
        ->where('sops.status', 'diverifikasi_admin')
        ->whereNull('nomor_sops.id')
        ->orderBy('sops.updated_at', 'desc')
        ->get();

    $query = DB::table('sops')
        ->join('units', 'sops.unit_id', '=', 'units.id')
        ->join('jenis_sop', 'sops.jenis_sop_id', '=', 'jenis_sop.id')
        ->leftJoin('nomor_sops', 'sops.id', '=', 'nomor_sops.sop_id')
        ->select(
            'sops.*',
            'units.kode_unit',
            'units.nama_unit',
            'jenis_sop.kode_jenis',
            'jenis_sop.nama_jenis',
            'nomor_sops.nomor_sop',
            'nomor_sops.status_nomor',
            'nomor_sops.tanggal_booking',
            'nomor_sops.tanggal_finalisasi'
        )
        ->whereIn('sops.status', $allowedStatuses);

    if ($statusFilter && in_array($statusFilter, $allowedStatuses)) {
        $query->where('sops.status', $statusFilter);
    }

    $sops = $query->orderBy('sops.updated_at', 'desc')->get();

    return view('admin.penomoran-sop', [
        'title' => 'Penomoran SOP',
        'sops' => $sops,
        'belumDinomori' => $belumDinomori,
        'statusFilter' => $statusFilter,
        'statusLabel' => $statusFilter && isset($statusLabels[$statusFilter])
            ? $statusLabels[$statusFilter]
            : 'Semua Status'
    ]);
}

    public function bookingNomor($id)
    {
        if (session('role') !== 'admin_p2mpp') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Admin P2MPP.');
        }

        $sop = DB::table('sops')
            ->join('units', 'sops.unit_id', '=', 'units.id')
            ->join('jenis_sop', 'sops.jenis_sop_id', '=', 'jenis_sop.id')
            ->select(
                'sops.*',
                'units.kode_unit',
                'jenis_sop.kode_jenis'
            )
            ->where('sops.id', $id)
            ->first();

        if (!$sop) {
            return redirect()->route('admin.penomoran')->with('error', 'SOP tidak ditemukan.');
        }

        if ($sop->status !== 'diverifikasi_admin') {
            return redirect()->route('admin.penomoran')->with('error', 'Hanya SOP berstatus diverifikasi admin yang bisa dibooking.');
        }

        $sudahAda = DB::table('nomor_sops')->where('sop_id', $id)->first();
        if ($sudahAda) {
            return redirect()->route('admin.penomoran')->with('error', 'Nomor SOP sudah pernah dibuat.');
        }

        $lastUrut = DB::table('nomor_sops')
            ->join('sops', 'nomor_sops.sop_id', '=', 'sops.id')
            ->where('sops.unit_id', $sop->unit_id)
            ->where('sops.jenis_sop_id', $sop->jenis_sop_id)
            ->where('sops.tahun_berlaku', $sop->tahun_berlaku)
            ->max('nomor_sops.nomor_urut');

        $nextUrut = $lastUrut ? $lastUrut + 1 : 1;

        $nomorSop = 'SOP/' .
            $sop->kode_unit . '/' .
            $sop->kode_jenis . '/' .
            $sop->tahun_berlaku . '/' .
            str_pad($nextUrut, 3, '0', STR_PAD_LEFT);

        DB::table('nomor_sops')->insert([
            'sop_id' => $sop->id,
            'nomor_sop' => $nomorSop,
            'nomor_urut' => $nextUrut,
            'status_nomor' => 'booking',
            'tanggal_booking' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('sops')
            ->where('id', $sop->id)
            ->update([
                'status' => 'nomor_booking',
                'updated_at' => now()
            ]);

        return redirect()->route('admin.penomoran')->with('success', 'Nomor SOP berhasil dibooking: ' . $nomorSop);
    }

    public function finalisasiNomor($id)
    {
        if (session('role') !== 'admin_p2mpp') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Admin P2MPP.');
        }

        $sop = DB::table('sops')->where('id', $id)->first();

        if (!$sop) {
            return redirect()->route('admin.penomoran')->with('error', 'SOP tidak ditemukan.');
        }

        if ($sop->status !== 'disetujui_kepala') {
            return redirect()->route('admin.penomoran')->with('error', 'Nomor hanya bisa difinalisasi setelah disetujui Kepala Pusat.');
        }

        $nomor = DB::table('nomor_sops')->where('sop_id', $id)->first();

        if (!$nomor) {
            return redirect()->route('admin.penomoran')->with('error', 'Nomor SOP belum dibooking.');
        }

        if ($nomor->status_nomor === 'final') {
            return redirect()->route('admin.penomoran')->with('error', 'Nomor SOP sudah difinalisasi.');
        }

        DB::table('nomor_sops')
            ->where('sop_id', $id)
            ->update([
                'status_nomor' => 'final',
                'tanggal_finalisasi' => now(),
                'updated_at' => now()
            ]);

        DB::table('sops')
            ->where('id', $id)
            ->update([
                'status' => 'nomor_final',
                'updated_at' => now()
            ]);

        return redirect()->route('admin.penomoran')->with('success', 'Nomor SOP berhasil difinalisasi.');
    }

public function bukaDokumen($id)
{
    if (session('role') !== 'admin_p2mpp') {
        return redirect()->route('login')->with('error', 'Silakan login sebagai Admin P2MPP.');
    }

    $sop = DB::table('sops')
        ->leftJoin('nomor_sops', 'sops.id', '=', 'nomor_sops.sop_id')
        ->select('sops.*', 'nomor_sops.nomor_sop')
        ->where('sops.id', $id)
        ->first();

    if (!$sop) {
        return redirect()->route('admin.penomoran')->with('error', 'Data SOP tidak ditemukan.');
    }

    if (!empty($sop->file_final)) {
        $pathFinal = storage_path('app/public/' . $sop->file_final);
        if (file_exists($pathFinal) && !is_dir($pathFinal)) {
            $downloadName = $this->makeSafeDocxFilename($sop->nama_sop, $sop->nomor_sop, 'SOP-FINAL');
            return response()->download($pathFinal, $downloadName);
        }
    }

    if (!empty($sop->file_bernomor)) {
        $pathBernomor = storage_path('app/public/' . $sop->file_bernomor);
        if (file_exists($pathBernomor) && !is_dir($pathBernomor)) {
            $downloadName = $this->makeSafeDocxFilename($sop->nama_sop, $sop->nomor_sop, 'SOP-BERNOMOR');
            return response()->download($pathBernomor, $downloadName);
        }
    }

    return redirect()->route('admin.penomoran')->with(
        'error',
        'Dokumen resmi belum tersedia. Silakan generate dokumen bernomor terlebih dahulu.'
    );
}


public function downloadBernomor($id)
{
    if (session('role') !== 'admin_p2mpp') {
        return redirect()->route('login')->with('error', 'Silakan login sebagai Admin P2MPP.');
    }

    $sop = DB::table('sops')
        ->leftJoin('nomor_sops', 'sops.id', '=', 'nomor_sops.sop_id')
        ->select('sops.*', 'nomor_sops.nomor_sop')
        ->where('sops.id', $id)
        ->first();

    if (!$sop) {
        return redirect()->route('admin.penomoran')->with('error', 'Data SOP tidak ditemukan.');
    }

    if (!empty($sop->file_bernomor)) {
        $path = storage_path('app/public/' . $sop->file_bernomor);

        if (file_exists($path) && !is_dir($path)) {
            $downloadName = $this->makeSafeDocxFilename($sop->nama_sop, $sop->nomor_sop, 'SOP-BERNOMOR');

            return response()->download(
                $path,
                $downloadName,
                [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                ]
            );
        }
    }

    return back()->with('error', 'File belum tersedia.');
}


public function generateDokumenBernomor($id)
{
    if (session('role') !== 'admin_p2mpp') {
        return redirect()->route('login')->with('error', 'Silakan login sebagai Admin P2MPP.');
    }

    $sop = DB::table('sops')
        ->join('units', 'sops.unit_id', '=', 'units.id')
        ->join('jenis_sop', 'sops.jenis_sop_id', '=', 'jenis_sop.id')
        ->leftJoin('nomor_sops', 'sops.id', '=', 'nomor_sops.sop_id')
        ->select(
            'sops.*',
            'units.kode_unit',
            'units.nama_unit',
            'jenis_sop.kode_jenis',
            'jenis_sop.nama_jenis',
            'nomor_sops.nomor_sop',
            'nomor_sops.status_nomor'
        )
        ->where('sops.id', $id)
        ->first();

    if (!$sop) {
        return redirect()->route('admin.penomoran')->with('error', 'Data SOP tidak ditemukan.');
    }

    if ($sop->status !== 'nomor_final') {
        return redirect()->route('admin.penomoran')->with('error', 'Dokumen bernomor hanya bisa dibuat setelah nomor final.');
    }

    if (!$sop->nomor_sop) {
        return redirect()->route('admin.penomoran')->with('error', 'Nomor SOP belum tersedia.');
    }

    if (empty($sop->file_draft)) {
        return redirect()->route('admin.penomoran')->with('error', 'File draft tidak tersedia di database.');
    }

    $templatePath = storage_path('app/public/' . $sop->file_draft);

    if (!file_exists($templatePath) || is_dir($templatePath)) {
        return redirect()->route('admin.penomoran')->with('error', 'File draft tidak ditemukan atau path tidak valid.');
    }

    $extension = strtolower(pathinfo($templatePath, PATHINFO_EXTENSION));
    if ($extension !== 'docx') {
        return redirect()->route('admin.penomoran')->with('error', 'File draft harus berformat DOCX agar dapat digenerate.');
    }

    try {
        $templateProcessor = new TemplateProcessor($templatePath);

        $templateProcessor->setValue('nomor_sop', $sop->nomor_sop ?? '');
        $templateProcessor->setValue('tanggal_pembuatan', $sop->tanggal_pembuatan ?? '');
        $templateProcessor->setValue('tanggal_revisi', $sop->tanggal_revisi ? $sop->tanggal_revisi : '');
        $templateProcessor->setValue('nama_sop', $sop->nama_sop ?? '');

        $folderPath = storage_path('app/public/bernomor');
        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $fileName = $this->makeSafeDocxFilename($sop->nama_sop, $sop->nomor_sop, 'SOP-BERNOMOR');
        $savePath = $folderPath . DIRECTORY_SEPARATOR . $fileName;

        $templateProcessor->saveAs($savePath);

        DB::table('sops')
            ->where('id', $id)
            ->update([
                'file_bernomor' => 'bernomor/' . $fileName,
                'updated_at' => now()
            ]);

        return redirect()->route('admin.penomoran')->with('success', 'Dokumen bernomor berhasil digenerate.');
    } catch (\Throwable $e) {
        return redirect()->route('admin.penomoran')->with('error', 'Gagal generate dokumen: ' . $e->getMessage());
    }
}


    public function kirimKeUmum($id)
    {
        if (session('role') !== 'admin_p2mpp') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Admin P2MPP.');
        }

        $sop = DB::table('sops')->where('id', $id)->first();

        if (!$sop) {
            return redirect()->route('admin.penomoran')->with('error', 'SOP tidak ditemukan.');
        }

        if ($sop->status !== 'nomor_final') {
            return redirect()->route('admin.penomoran')->with('error', 'Hanya SOP dengan nomor final yang bisa dikirim ke Bagian Umum.');
        }

        if (empty($sop->file_bernomor)) {
            return redirect()->route('admin.penomoran')->with('error', 'Generate dokumen bernomor terlebih dahulu sebelum dikirim ke Bagian Umum.');
        }

        DB::table('sops')
            ->where('id', $id)
            ->update([
                'status' => 'dikirim_ke_umum',
                'updated_at' => now()
            ]);

        return redirect()->route('admin.penomoran')->with('success', 'SOP berhasil dikirim ke Bagian Umum.');
    }

    public function arsipkan($id)
    {
        if (!in_array(session('role'), ['admin_p2mpp', 'bagian_umum'])) {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }

        $sop = DB::table('sops')->where('id', $id)->first();

        if (!$sop) {
            return back()->with('error', 'Data SOP tidak ditemukan.');
        }

        if ($sop->status !== 'ditandatangani') {
            return back()->with('error', 'Hanya SOP yang sudah ditandatangani yang bisa diarsipkan.');
        }

        DB::table('sops')
            ->where('id', $id)
            ->update([
                'status' => 'diarsipkan',
                'archived_by' => session('user_id'),
'archived_at' => now('Asia/Jakarta'),
'updated_at' => now('Asia/Jakarta')
            ]);

        return back()->with('success', 'SOP berhasil diarsipkan.');
    }

public function arsip()
{
    if (!in_array(session('role'), ['admin_p2mpp', 'bagian_umum'])) {
        return redirect()->route('login')->with('error', 'Akses ditolak.');
    }

    $sops = DB::table('sops')
        ->leftJoin('users', 'sops.archived_by', '=', 'users.id')
        ->leftJoin('nomor_sops', 'sops.id', '=', 'nomor_sops.sop_id')
        ->leftJoin('units', 'sops.unit_id', '=', 'units.id') // ✅ TAMBAH
        ->select(
            'sops.*',
            'users.name as archived_by_name',
            'nomor_sops.nomor_sop',
            'units.nama_unit' // ✅ TAMBAH
        )
        ->where('sops.status', 'diarsipkan')
        ->orderBy('sops.updated_at', 'desc')
        ->get();

    return view('admin.arsip-sop', [
        'title' => 'Arsip SOP',
        'sops' => $sops
    ]);
}

    public function dashboard()
    {
        if (session('role') !== 'admin_p2mpp') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Admin P2MPP.');
        }

        $tahunSekarang = now()->year;

        $totalSop = DB::table('sops')->count();

        $jumlahVerifikasi = DB::table('sops')
            ->where('status', 'diajukan')
            ->count();

$jumlahPenomoran = DB::table('sops')
    ->whereIn('status', [
        'diverifikasi_admin',
        'nomor_booking',
        'disetujui_kepala',
        'nomor_final',
        'dikirim_ke_umum',
        'dikirim_ke_direktur'
    ])
    ->count();

        $jumlahBelumDiberiNomor = DB::table('sops')
            ->whereIn('status', [
                'diverifikasi_admin',
                'nomor_booking'
            ])
            ->count();

        $jumlahSelesai = DB::table('sops')
            ->whereIn('status', [
                'dikirim_ke_umum',
                'ditandatangani',
                'diarsipkan'
            ])
            ->count();

        $jumlahArsip = DB::table('sops')
            ->where('status', 'diarsipkan')
            ->count();

        $statusCounts = [
            'diajukan' => DB::table('sops')->where('status', 'diajukan')->count(),
            'diverifikasi_admin' => DB::table('sops')->where('status', 'diverifikasi_admin')->count(),
            'nomor_booking' => DB::table('sops')->where('status', 'nomor_booking')->count(),
            'disetujui_kepala' => DB::table('sops')->where('status', 'disetujui_kepala')->count(),
            'nomor_final' => DB::table('sops')->where('status', 'nomor_final')->count(),
            'dikirim_ke_umum' => DB::table('sops')->where('status', 'dikirim_ke_umum')->count(),
            'ditandatangani' => DB::table('sops')->where('status', 'ditandatangani')->count(),
            'diarsipkan' => DB::table('sops')->where('status', 'diarsipkan')->count(),
        ];

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        $monthlyRaw = DB::table('sops')
            ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $tahunSekarang)
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->pluck('total', 'bulan')
            ->toArray();

        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[] = isset($monthlyRaw[$i]) ? (int) $monthlyRaw[$i] : 0;
        }

        $informasiAdmin = [
            [
                'judul' => 'Monitoring Verifikasi',
                'status' => 'Aktif',
                'keterangan' => 'Pantau SOP yang masuk dan pastikan proses verifikasi berjalan dengan baik.'
            ],
            [
                'judul' => 'Monitoring Penomoran',
                'status' => 'Aktif',
                'keterangan' => 'Kelola SOP yang sudah lolos verifikasi dan siap diberi nomor.'
            ],
            [
                'judul' => 'Monitoring Arsip',
                'status' => 'Aktif',
                'keterangan' => 'Pastikan SOP yang telah selesai diproses masuk ke tahap arsip dengan tertib.'
            ]
        ];

        return view('admin.dashboard', [
            'title' => 'Dashboard Admin',
            'tahunSekarang' => $tahunSekarang,
            'totalSop' => $totalSop,
            'jumlahVerifikasi' => $jumlahVerifikasi,
            'jumlahPenomoran' => $jumlahPenomoran,
            'jumlahBelumDiberiNomor' => $jumlahBelumDiberiNomor,
            'jumlahSelesai' => $jumlahSelesai,
            'jumlahArsip' => $jumlahArsip,
            'statusCounts' => $statusCounts,
            'months' => $months,
            'monthlyData' => $monthlyData,
            'informasiAdmin' => $informasiAdmin
        ]);
    }

    public function finalDirektur()
    {
        if (session('role') !== 'admin_p2mpp') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Admin P2MPP.');
        }

        $data = DB::table('sops')
            ->join('units', 'sops.unit_id', '=', 'units.id')
            ->join('jenis_sop', 'sops.jenis_sop_id', '=', 'jenis_sop.id')
            ->leftJoin('nomor_sops', 'sops.id', '=', 'nomor_sops.sop_id')
            ->select(
                'sops.*',
                'units.kode_unit',
                'units.nama_unit',
                'jenis_sop.kode_jenis',
                'jenis_sop.nama_jenis',
                'nomor_sops.nomor_sop',
                'nomor_sops.status_nomor'
            )
            ->whereIn('sops.status', ['ditandatangani', 'diarsipkan'])
            ->orderBy('sops.updated_at', 'desc')
            ->get();

        return view('admin.final', [
            'title' => 'SOP Final Direktur',
            'data' => $data
        ]);
    }

public function lihatDraft($id)
{
    if (session('role') !== 'admin_p2mpp') {
        return redirect()->route('login')->with('error', 'Silakan login sebagai Admin P2MPP.');
    }

    $sop = DB::table('sops')->where('id', $id)->first();

    if (!$sop || empty($sop->file_draft)) {
        return back()->with('error', 'File draft tidak ditemukan.');
    }

    $path = storage_path('app/public/' . $sop->file_draft);

    if (!file_exists($path) || is_dir($path)) {
        return back()->with('error', 'File draft tidak ditemukan di storage.');
    }

    $ext = pathinfo($path, PATHINFO_EXTENSION);

    $namaSop = $sop->nama_sop ?? 'TANPA-NAMA';
    $namaSop = preg_replace('/[^A-Za-z0-9\s\-]/', '', $namaSop);
    $namaSop = trim(preg_replace('/\s+/', ' ', $namaSop));
    $namaSop = str_replace(' ', '-', $namaSop);

    $downloadName = 'SOP_' . $namaSop . '.' . strtolower($ext);

    return response()->download($path, $downloadName);
}

public function lihatSurat($id)
{
    if (session('role') !== 'admin_p2mpp') {
        return redirect()->route('login')->with('error', 'Silakan login sebagai Admin P2MPP.');
    }

    $sop = DB::table('sops')->where('id', $id)->first();

    if (!$sop || empty($sop->file_surat_permohonan)) {
        return back()->with('error', 'File surat permohonan tidak ditemukan.');
    }

    $path = storage_path('app/public/' . $sop->file_surat_permohonan);

    if (!file_exists($path) || is_dir($path)) {
        return back()->with('error', 'File surat tidak ditemukan di storage.');
    }

    $ext = pathinfo($path, PATHINFO_EXTENSION);

    $namaSop = $sop->nama_sop ?? 'TANPA-NAMA';
    $namaSop = preg_replace('/[^A-Za-z0-9\s\-]/', '', $namaSop);
    $namaSop = trim(preg_replace('/\s+/', ' ', $namaSop));
    $namaSop = str_replace(' ', '-', $namaSop);

    $downloadName = 'SURAT_' . $namaSop . '.' . strtolower($ext);

    return response()->download($path, $downloadName);
}


        private function makeSafeDocxFilename($namaSop, $nomorSop = null, $prefix = 'SOP')
{
    $namaSop = $namaSop ?? 'TANPA-NAMA';
    $namaSop = preg_replace('/[^A-Za-z0-9\s\-]/', '', $namaSop);
    $namaSop = trim(preg_replace('/\s+/', ' ', $namaSop));
    $namaSop = str_replace(' ', '-', $namaSop);
    $namaSop = strtoupper($namaSop);

    $parts = [$prefix, $namaSop];

    if (!empty($nomorSop)) {
        $nomorSop = str_replace('/', '-', $nomorSop);
        $nomorSop = preg_replace('/[^A-Za-z0-9\-]/', '', $nomorSop);
        $parts[] = strtoupper($nomorSop);
    }

    return implode('-', $parts) . '.docx';
}
}
