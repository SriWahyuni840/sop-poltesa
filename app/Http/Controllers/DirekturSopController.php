<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\TemplateProcessor;

class DirekturSopController extends Controller
{
    public function dashboard()
    {
        if (session('role') !== 'direktur') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Direktur.');
        }

        $jumlahSop = DB::table('sops')
            ->whereIn('status', ['dikirim_ke_direktur', 'ditandatangani'])
            ->count();

        return view('direktur.dashboard', [
            'title' => 'Dashboard Direktur',
            'jumlahSop' => $jumlahSop
        ]);
    }

    public function index()
    {
        if (session('role') !== 'direktur') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Direktur.');
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
                'dikirim_ke_direktur',
                'ditandatangani'
            ])
            ->orderBy('sops.updated_at', 'desc')
            ->get();

        return view('direktur.list-sop', [
            'title' => 'Persetujuan SOP Direktur',
            'sops' => $sops
        ]);
    }

    public function detail($id)
    {
        if (session('role') !== 'direktur') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Direktur.');
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
                'nomor_sops.nomor_sop'
            )
            ->where('sops.id', $id)
            ->first();

        if (!$sop) {
            return redirect()->route('direktur.sop')->with('error', 'Data SOP tidak ditemukan.');
        }

        return view('direktur.detail-sop', [
            'title' => 'Detail Persetujuan SOP',
            'sop' => $sop
        ]);
    }

    public function downloadDokumen($id)
    {
        if (session('role') !== 'direktur') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Direktur.');
        }

        $sop = DB::table('sops')
            ->leftJoin('nomor_sops', 'sops.id', '=', 'nomor_sops.sop_id')
            ->select('sops.*', 'nomor_sops.nomor_sop')
            ->where('sops.id', $id)
            ->first();

        if (!$sop) {
            return redirect()->route('direktur.sop')->with('error', 'Data SOP tidak ditemukan.');
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

        return redirect()->route('direktur.sop')->with('error', 'File dokumen tidak ditemukan.');
    }

 public function sahkan(Request $request, $id)
{
    if (session('role') !== 'direktur') {
        return redirect()->route('login')->with('error', 'Silakan login sebagai Direktur.');
    }

    $request->validate([
        'pin' => 'required'
    ]);

    if ($request->pin !== '123456') {
        return back()->with('error', 'PIN direktur salah.');
    }

    $sop = DB::table('sops')
        ->leftJoin('nomor_sops', 'sops.id', '=', 'nomor_sops.sop_id')
        ->select('sops.*', 'nomor_sops.nomor_sop')
        ->where('sops.id', $id)
        ->first();

    if (!$sop) {
        return redirect()->route('direktur.sop')->with('error', 'SOP tidak ditemukan.');
    }

    if ($sop->status !== 'dikirim_ke_direktur') {
        return redirect()->route('direktur.sop')->with('error', 'SOP belum siap disahkan.');
    }

    if (empty($sop->file_bernomor)) {
        return redirect()->route('direktur.sop')->with('error', 'Dokumen bernomor belum tersedia.');
    }

    $templatePath = storage_path('app/public/' . $sop->file_bernomor);

    if (!file_exists($templatePath) || is_dir($templatePath)) {
        return redirect()->route('direktur.sop')->with('error', 'File dokumen bernomor tidak ditemukan atau path tidak valid.');
    }

    $qrSource = public_path('qr.png');
    if (!file_exists($qrSource)) {
        return redirect()->route('direktur.sop')->with('error', 'File QR sumber (public/qr.png) tidak ditemukan.');
    }

    $qrFolder = storage_path('app/public/qr');
    if (!is_dir($qrFolder)) {
        mkdir($qrFolder, 0777, true);
    }

    $qrFileName = 'qr-sop-' . $sop->id . '.png';
    $qrPath = $qrFolder . DIRECTORY_SEPARATOR . $qrFileName;

    if (!copy($qrSource, $qrPath)) {
        return redirect()->route('direktur.sop')->with('error', 'Gagal menyalin file QR.');
    }

    $qrRealPath = realpath($qrPath);
    if ($qrRealPath === false) {
        return redirect()->route('direktur.sop')->with('error', 'Path QR tidak valid.');
    }

    try {
        $tanggalEfektif = now('Asia/Jakarta')->toDateString();

        $templateProcessor = new TemplateProcessor($templatePath);
        $templateProcessor->setValue('tanggal_efektif', $tanggalEfektif);

        $templateProcessor->setImageValue('ttd_qr', [
            'path' => $qrRealPath,
            'width' => 90,
            'height' => 90,
            'ratio' => true
        ]);

        $finalFolder = storage_path('app/public/final');
        if (!is_dir($finalFolder)) {
            mkdir($finalFolder, 0777, true);
        }

        $baseFileName = $this->makeSafeDocxFilename($sop->nama_sop, $sop->nomor_sop, 'SOP-FINAL');
        $finalFileName = str_replace('.docx', '-' . time() . '.docx', $baseFileName);
        $finalPath = $finalFolder . DIRECTORY_SEPARATOR . $finalFileName;

        $templateProcessor->saveAs($finalPath);

        DB::table('sops')
            ->where('id', $id)
            ->update([
                'status' => 'ditandatangani',
                'tanggal_efektif' => $tanggalEfektif,
                'qr_code' => 'qr/' . $qrFileName,
                'file_final' => 'final/' . $finalFileName,
                'updated_at' => now('Asia/Jakarta')
            ]);

        return redirect()->route('direktur.sop')->with('success', 'SOP berhasil disahkan oleh Direktur.');
    } catch (\Throwable $e) {
        return redirect()->route('direktur.sop')->with('error', 'Gagal menyisipkan QR ke dokumen: ' . $e->getMessage());
    }
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