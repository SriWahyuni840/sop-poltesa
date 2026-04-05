@extends('layouts.unit')

@section('content')
<style>
    .revisi-dark-page {
        background: #2b2f67;
        min-height: calc(100vh - 72px);
        padding: 14px 16px 28px;
        color: #fff;
    }

    .revisi-dark-wrap {
        width: 100%;
        margin: 0 auto;
    }

    .top-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .top-line-text {
        font-size: 13px;
        color: rgba(255,255,255,0.9);
        font-weight: 700;
    }

    .revisi-card {
        background: #23285d;
        border: 1px solid rgba(255,255,255,0.06);
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.02);
    }

    .revisi-card-header {
        padding: 14px 16px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    .revisi-card-title {
        font-size: 16px;
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 4px;
    }

    .revisi-card-subtitle {
        font-size: 12px;
        color: rgba(255,255,255,0.62);
        margin: 0;
    }

    .revisi-card-body {
        padding: 14px 16px 18px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .summary-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.08);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
    }

    .summary-total {
        font-size: 12px;
        font-weight: 700;
        color: rgba(255,255,255,0.88);
    }

    .table-wrap-dark {
        width: 100%;
        overflow-x: auto;
        border: 1px solid rgba(255,255,255,0.08);
        background: #202554;
    }

    .table-revisi-dark {
        width: 100%;
        min-width: 980px;
        border-collapse: collapse;
        margin: 0;
    }

    .table-revisi-dark thead th {
        color: #ffffff;
        font-size: 12px;
        font-weight: 700;
        text-align: left;
        padding: 11px 10px;
        border-bottom: 1px solid rgba(255,255,255,0.12);
        background: #23285d;
        white-space: nowrap;
    }

    .table-revisi-dark tbody td {
        color: #ffffff;
        font-size: 12px;
        padding: 11px 10px;
        border-top: 1px solid rgba(255,255,255,0.10);
        vertical-align: middle;
        background: #23285d;
    }

    .table-revisi-dark tbody tr:hover td {
        background: #262c66;
    }

    .text-center-col {
        text-align: center;
    }

    .nama-sop {
        font-weight: 700;
        color: #ffffff;
        line-height: 1.5;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 800;
        line-height: 1.2;
        white-space: nowrap;
    }

    .status-red {
        background: #ef4444;
        color: #fff;
    }

    .status-yellow {
        background: #facc15;
        color: #3b2f00;
    }

    .status-gray {
        background: #64748b;
        color: #fff;
    }

    .aksi-group {
        display: flex;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-aksi {
        border: none;
        border-radius: 6px;
        padding: 8px 12px;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #fff;
    }

    .btn-aksi:hover {
        color: #fff;
        filter: brightness(0.95);
    }

    .btn-detail {
        background: #2563eb;
    }

    .btn-revisi {
        background: #f59e0b;
    }

    .empty-state-dark {
        text-align: center;
        padding: 48px 20px;
        color: rgba(255,255,255,0.72);
    }

    .empty-state-dark i {
        font-size: 42px;
        margin-bottom: 10px;
        color: rgba(255,255,255,0.35);
    }

    .empty-state-dark h6 {
        margin-bottom: 6px;
        font-size: 18px;
        font-weight: 800;
        color: #fff;
    }

    .bottom-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        padding-top: 12px;
        color: rgba(255,255,255,0.86);
        font-size: 12px;
    }

    @media (max-width: 768px) {
        .revisi-dark-page {
            padding: 12px;
        }

        .summary-row,
        .bottom-bar {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="container-fluid revisi-dark-page">
    <div class="revisi-dark-wrap">

        <div class="top-line">
            <div class="top-line-text">
                SOP Saya - Daftar Revisi SOP
            </div>
        </div>

        <div class="revisi-card">
            <div class="revisi-card-header">
                <h5 class="revisi-card-title">Daftar SOP Perlu Revisi</h5>
                <p class="revisi-card-subtitle">
                    Data SOP yang dikembalikan dan memerlukan tindak lanjut dari unit kerja.
                </p>
            </div>

            <div class="revisi-card-body">
                <div class="summary-row">
                    <div class="summary-badge">
                        <i class="bi bi-arrow-repeat"></i> Revisi SOP
                    </div>

                    <div class="summary-total">
                        Total SOP Revisi: {{ count($sops) }}
                    </div>
                </div>

                <div class="table-wrap-dark">
                    <table class="table-revisi-dark">
                        <thead>
                            <tr>
                                <th style="width:70px;">No</th>
                                <th style="width:120px;">Kode Unit</th>
                                <th style="width:120px;">Kode Jenis</th>
                                <th>Nama SOP</th>
                                <th style="width:140px;">Tahun Berlaku</th>
                                <th style="width:190px;">Status</th>
                                <th style="width:190px;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($sops as $index => $sop)
                                <tr>
                                    <td class="text-center-col">{{ $index + 1 }}</td>
                                    <td class="text-center-col">{{ $sop->kode_unit }}</td>
                                    <td class="text-center-col">{{ $sop->kode_jenis }}</td>
                                    <td>
                                        <div class="nama-sop">{{ $sop->nama_sop }}</div>
                                    </td>
                                    <td class="text-center-col">{{ $sop->tahun_berlaku }}</td>
                                    <td class="text-center-col">
                                        @if($sop->status == 'dikembalikan_admin')
                                            <span class="status-pill status-red">
                                                <i class="bi bi-arrow-counterclockwise"></i> Dikembalikan Admin
                                            </span>
                                        @elseif($sop->status == 'dikembalikan_kepala')
                                            <span class="status-pill status-yellow">
                                                <i class="bi bi-arrow-repeat"></i> Dikembalikan Kepala
                                            </span>
                                        @elseif($sop->status == 'ditolak_direktur')
                                            <span class="status-pill status-red">
                                                <i class="bi bi-x-octagon"></i> Ditolak Direktur
                                            </span>
                                        @else
                                            <span class="status-pill status-gray">
                                                <i class="bi bi-info-circle"></i> {{ ucwords(str_replace('_', ' ', $sop->status)) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center-col">
                                        <div class="aksi-group">
                                            <a href="{{ route('unit.sop.detail', $sop->id) }}" class="btn-aksi btn-detail">
                                                <i class="bi bi-eye-fill"></i> Detail
                                            </a>
                                            <a href="{{ route('unit.sop.edit', $sop->id) }}" class="btn-aksi btn-revisi">
                                                <i class="bi bi-pencil-square"></i> Revisi
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state-dark">
                                            <i class="bi bi-folder2-open"></i>
                                            <h6>Belum Ada SOP yang Perlu Revisi</h6>
                                            <div>Seluruh SOP pada unit kerja Anda saat ini belum memiliki catatan revisi.</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bottom-bar">
                    <div>
                        Menampilkan data SOP yang memerlukan tindak lanjut revisi.
                    </div>
                    <div>
                        Total data: {{ count($sops) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection