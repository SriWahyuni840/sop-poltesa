<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KepalaSopController extends Controller
{
    public function index()
    {
        if (session('role') !== 'kepala_pusat') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Kepala Pusat.');
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
                'nomor_sops.nomor_sop',
                'nomor_sops.status_nomor'
            )
            ->where('sops.status', 'nomor_booking')
            ->orderBy('sops.updated_at', 'desc')
            ->get();

        return view('kepala.review-sop', [
            'title' => 'Review SOP Kepala Pusat',
            'sops' => $sops
        ]);
    }

    public function detail($id)
    {
        if (session('role') !== 'kepala_pusat') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Kepala Pusat.');
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
            return redirect()->route('kepala.review')->with('error', 'Data SOP tidak ditemukan.');
        }

        $catatans = DB::table('catatans')
            ->join('users', 'catatans.user_id', '=', 'users.id')
            ->select('catatans.*', 'users.name')
            ->where('catatans.sop_id', $id)
            ->orderBy('catatans.created_at', 'desc')
            ->get();

        return view('kepala.detail-review-sop', [
            'title' => 'Detail Review SOP',
            'sop' => $sop,
            'catatans' => $catatans
        ]);
    }

    public function lihatDraft($id)
    {
        if (session('role') !== 'kepala_pusat') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Kepala Pusat.');
        }

        $sop = DB::table('sops')->where('id', $id)->first();

        if (!$sop || empty($sop->file_draft)) {
            return back()->with('error', 'File draft tidak ditemukan.');
        }

        $path = storage_path('app/public/' . $sop->file_draft);

        if (!file_exists($path) || is_dir($path)) {
            return back()->with('error', 'File draft tidak ditemukan di storage.');
        }

        return response()->file($path);
    }

    public function lihatSurat($id)
    {
        if (session('role') !== 'kepala_pusat') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Kepala Pusat.');
        }

        $sop = DB::table('sops')->where('id', $id)->first();

        if (!$sop || empty($sop->file_surat_permohonan)) {
            return back()->with('error', 'File surat permohonan tidak ditemukan.');
        }

        $path = storage_path('app/public/' . $sop->file_surat_permohonan);

        if (!file_exists($path) || is_dir($path)) {
            return back()->with('error', 'File surat tidak ditemukan di storage.');
        }

        return response()->file($path);
    }

    public function setujui($id)
    {
        if (session('role') !== 'kepala_pusat') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Kepala Pusat.');
        }

        $sop = DB::table('sops')->where('id', $id)->first();

        if (!$sop) {
            return redirect()->route('kepala.review')->with('error', 'Data SOP tidak ditemukan.');
        }

        if ($sop->status !== 'nomor_booking') {
            return redirect()->route('kepala.review')->with('error', 'Hanya SOP berstatus nomor booking yang bisa direview.');
        }

        DB::table('sops')
            ->where('id', $id)
            ->update([
                'status' => 'disetujui_kepala',
                'updated_at' => now()
            ]);

        return redirect()->route('kepala.review')->with('success', 'SOP disetujui oleh Kepala Pusat.');
    }

    public function kembalikan(Request $request, $id)
    {
        if (session('role') !== 'kepala_pusat') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Kepala Pusat.');
        }

        $request->validate([
            'isi_catatan' => 'required|string'
        ]);

        $sop = DB::table('sops')->where('id', $id)->first();

        if (!$sop) {
            return redirect()->route('kepala.review')->with('error', 'Data SOP tidak ditemukan.');
        }

        if ($sop->status !== 'nomor_booking') {
            return redirect()->route('kepala.review')->with('error', 'Hanya SOP berstatus nomor booking yang bisa dikembalikan.');
        }

        DB::table('sops')
            ->where('id', $id)
            ->update([
                'status' => 'dikembalikan_kepala',
                'updated_at' => now()
            ]);

        DB::table('catatans')->insert([
            'sop_id' => $id,
            'user_id' => session('user_id'),
            'jenis_catatan' => 'review_kepala',
            'isi_catatan' => $request->isi_catatan,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('kepala.review')->with('success', 'SOP dikembalikan oleh Kepala Pusat.');
    }
}