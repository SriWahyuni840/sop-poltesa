<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SopController extends Controller
{
    public function simpan(Request $request)
    {
        if (session('role') !== 'unit') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Unit.');
        }

        $request->validate([
            'jenis_sop_id' => 'required',
            'nama_sop' => 'required|string|max:255',
            'tahun_berlaku' => 'required|digits:4',

            // file draft WAJIB docx karena dipakai sebagai template generate nomor/final
            'file_draft' => 'required|file|mimes:docx|max:5120',

            // surat permohonan tetap boleh pdf/doc/docx
            'file_surat_permohonan' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'aksi' => 'required|in:draft,ajukan',
        ], [
            'file_draft.mimes' => 'File draft SOP wajib berformat DOCX.',
            'file_surat_permohonan.mimes' => 'File surat permohonan harus berformat PDF, DOC, atau DOCX.',
        ]);

        $fileDraft = $request->file('file_draft')->store('drafts', 'public');
        $fileSurat = $request->file('file_surat_permohonan')->store('surat', 'public');

        $status = $request->aksi === 'ajukan' ? 'diajukan' : 'draft';

        DB::table('sops')->insert([
            'unit_id' => session('unit_id'),
            'jenis_sop_id' => $request->jenis_sop_id,
            'nama_sop' => $request->nama_sop,
            'tahun_berlaku' => $request->tahun_berlaku,
            'tanggal_pembuatan' => now()->toDateString(),
            'tanggal_revisi' => null,
            'tanggal_efektif' => null,
            'file_draft' => $fileDraft,
            'file_surat_permohonan' => $fileSurat,
            'status' => $status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('unit.sop')->with('success', 'SOP berhasil disimpan.');
    }

    public function detail($id)
    {
        if (session('role') !== 'unit') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Unit.');
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
            ->where('sops.unit_id', session('unit_id'))
            ->first();

        if (!$sop) {
            return redirect()->route('unit.sop')->with('error', 'Data SOP tidak ditemukan.');
        }

        $catatans = DB::table('catatans')
            ->join('users', 'catatans.user_id', '=', 'users.id')
            ->select('catatans.*', 'users.name')
            ->where('catatans.sop_id', $id)
            ->orderBy('catatans.created_at', 'desc')
            ->get();

        return view('unit.detail-sop', [
            'title' => 'Detail SOP',
            'sop' => $sop,
            'catatans' => $catatans
        ]);
    }

    public function edit($id)
    {
        if (session('role') !== 'unit') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Unit.');
        }

        $sop = DB::table('sops')
            ->where('id', $id)
            ->where('unit_id', session('unit_id'))
            ->first();

        if (!$sop) {
            return redirect()->route('unit.sop')->with('error', 'Data SOP tidak ditemukan.');
        }

        $jenis = DB::table('jenis_sop')->orderBy('kode_jenis')->get();

        return view('unit.edit-sop', [
            'title' => 'Revisi SOP',
            'sop' => $sop,
            'jenis' => $jenis
        ]);
    }

    public function update(Request $request, $id)
    {
        if (session('role') !== 'unit') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Unit.');
        }

        $sop = DB::table('sops')
            ->where('id', $id)
            ->where('unit_id', session('unit_id'))
            ->first();

        if (!$sop) {
            return redirect()->route('unit.sop')->with('error', 'Data SOP tidak ditemukan.');
        }

        $request->validate([
            'jenis_sop_id' => 'required',
            'nama_sop' => 'required|string|max:255',
            'tahun_berlaku' => 'required|digits:4',

            // kalau upload ulang draft, wajib docx
            'file_draft' => 'nullable|file|mimes:docx|max:5120',

            'file_surat_permohonan' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'aksi' => 'required|in:draft,ajukan',
        ], [
            'file_draft.mimes' => 'File draft SOP wajib berformat DOCX.',
            'file_surat_permohonan.mimes' => 'File surat permohonan harus berformat PDF, DOC, atau DOCX.',
        ]);

        $dataUpdate = [
            'jenis_sop_id' => $request->jenis_sop_id,
            'nama_sop' => $request->nama_sop,
            'tahun_berlaku' => $request->tahun_berlaku,
            'tanggal_revisi' => now()->toDateString(),
            'status' => $request->aksi === 'ajukan' ? 'diajukan' : 'draft',
            'updated_at' => now(),
        ];

        if ($request->hasFile('file_draft')) {
            $dataUpdate['file_draft'] = $request->file('file_draft')->store('drafts', 'public');
        }

        if ($request->hasFile('file_surat_permohonan')) {
            $dataUpdate['file_surat_permohonan'] = $request->file('file_surat_permohonan')->store('surat', 'public');
        }

        DB::table('sops')
            ->where('id', $id)
            ->update($dataUpdate);

        return redirect()->route('unit.sop')->with('success', 'SOP berhasil direvisi.');
    }

    public function lihatFinal($id)
    {
        $sop = DB::table('sops')
            ->where('id', $id)
            ->where('unit_id', session('unit_id'))
            ->whereIn('status', ['ditandatangani', 'diarsipkan'])
            ->first();

        if (!$sop) {
            return back()->with('error', 'SOP belum selesai ditandatangani direktur.');
        }

        if (empty($sop->file_final)) {
            return back()->with('error', 'File hasil tanda tangan direktur belum tersedia.');
        }

        $path = storage_path('app/public/' . $sop->file_final);

        if (!file_exists($path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download($path);
    }

    public function lihatDraft($id)
    {
        if (session('role') !== 'unit') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Unit.');
        }

        $sop = DB::table('sops')
            ->where('id', $id)
            ->where('unit_id', session('unit_id'))
            ->first();

        if (!$sop || empty($sop->file_draft)) {
            return back()->with('error', 'File draft tidak ditemukan.');
        }

        $path = storage_path('app/public/' . $sop->file_draft);

        if (!file_exists($path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $fileName = $this->makeSafeFilename('SOP', $sop->nama_sop, $ext);

        return response()->file($path, [
            'Content-Disposition' => 'inline; filename="' . $fileName . '"'
        ]);
    }

    public function lihatSurat($id)
    {
        if (session('role') !== 'unit') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Unit.');
        }

        $sop = DB::table('sops')
            ->where('id', $id)
            ->where('unit_id', session('unit_id'))
            ->first();

        if (!$sop || empty($sop->file_surat_permohonan)) {
            return back()->with('error', 'File surat tidak ditemukan.');
        }

        $path = storage_path('app/public/' . $sop->file_surat_permohonan);

        if (!file_exists($path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $fileName = $this->makeSafeFilename('Surat Permohonan', $sop->nama_sop, $ext);

        return response()->file($path, [
            'Content-Disposition' => 'inline; filename="' . $fileName . '"'
        ]);
    }

    private function makeSafeFilename($prefix, $namaSop, $extension)
    {
        $namaSop = $namaSop ?? 'TANPA-NAMA';
        $namaSop = preg_replace('/[^A-Za-z0-9\s\-]/', '', $namaSop);
        $namaSop = trim(preg_replace('/\s+/', ' ', $namaSop));
        $namaSop = str_replace(' ', '-', $namaSop);

        $prefix = str_replace(' ', '-', $prefix);

        return $prefix . '-' . $namaSop . '.' . strtolower($extension);
    }
}