<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    public function arsip()
    {
        if (session('role') !== 'unit') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai Unit.');
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
            ->where('sops.unit_id', session('unit_id'))
            ->whereIn('sops.status', ['ditandatangani', 'diarsipkan'])
            ->whereNotNull('sops.file_final')
            ->orderBy('sops.updated_at', 'desc')
            ->get();

        return view('unit.arsip-sop', [
            'title' => 'Arsip SOP',
            'sops' => $sops
        ]);
    }
}