<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (session('role') === 'unit') {

                $statusRevisi = [
                    'dikembalikan_admin',
                    'dikembalikan_kepala',
                    'ditolak_direktur'
                ];

                $jumlahNotifikasi = DB::table('sops')
                    ->where('unit_id', session('unit_id'))
                    ->whereIn('status', $statusRevisi)
                    ->count();

                $notifikasiDropdown = DB::table('sops')
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

                $view->with('jumlahNotifikasi', $jumlahNotifikasi);
                $view->with('notifikasiDropdown', $notifikasiDropdown);
            }
        });
    }
}