@extends('layouts.unit')

@section('content')
<style>
    .detail-page {
        background: #f4f7fb;
        padding-top: 10px;
        padding-bottom: 28px;
    }

    .detail-page-inner {
        max-width: 1180px;
        margin: 0 auto;
    }

    .detail-shell {
        background: #ffffff;
        border: 1px solid #e4ebf3;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.05);
    }

    .detail-head {
        padding: 26px 26px 18px;
        background: linear-gradient(135deg, #f8fbff 0%, #eef5ff 100%);
        border-bottom: 1px solid #e7edf5;
    }

    .detail-head-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        flex-wrap: wrap;
    }

    .detail-title {
        font-size: 28px;
        font-weight: 900;
        color: #0f2b5b;
        margin-bottom: 6px;
        line-height: 1.2;
    }

    .detail-subtitle {
        font-size: 14px;
        color: #64748b;
        line-height: 1.8;
        margin: 0;
        max-width: 760px;
    }

    .detail-status-box {
        min-width: 220px;
        background: #ffffff;
        border: 1px solid #dbe6f2;
        border-radius: 18px;
        padding: 14px 18px;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
    }

    .detail-status-label {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 8px;
    }

    .detail-body {
        padding: 22px 26px 26px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1.15fr 0.85fr;
        gap: 22px;
    }

    .detail-card {
        background: #ffffff;
        border: 1px solid #e6edf5;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.03);
    }

    .detail-card-header {
        padding: 16px 20px;
        background: linear-gradient(180deg, #f8d764 0%, #f2ca45 100%);
        color: #1f2937;
        font-size: 15px;
        font-weight: 800;
    }

    .detail-card-body {
        padding: 20px;
    }

    .detail-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden;
        border: 1px solid #edf2f7;
        border-radius: 16px;
    }

    .detail-table th,
    .detail-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #edf2f7;
        vertical-align: top;
        font-size: 14px;
        line-height: 1.6;
    }

    .detail-table tr:last-child th,
    .detail-table tr:last-child td {
        border-bottom: none;
    }

    .detail-table th {
        width: 34%;
        background: #f8fbff;
        color: #334155;
        font-weight: 800;
    }

    .detail-table td {
        background: #ffffff;
        color: #0f172a;
    }

    .file-box {
        background: #f8fbff;
        border: 1px solid #e2ebf5;
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 14px;
    }

    .file-box:last-child {
        margin-bottom: 0;
    }

    .file-title {
        font-size: 14px;
        font-weight: 800;
        color: #0f2b5b;
        margin-bottom: 6px;
    }

    .file-desc {
        font-size: 13px;
        color: #64748b;
        line-height: 1.7;
        margin-bottom: 12px;
    }

    .btn-file {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 12px;
        background: #1f2f6b;
        color: #ffffff;
        text-decoration: none;
        font-size: 13px;
        font-weight: 800;
        transition: all 0.2s ease;
    }

    .btn-file:hover {
        background: #182454;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
        line-height: 1.3;
        white-space: normal;
    }

    .catatan-list {
        display: grid;
        gap: 14px;
    }

    .catatan-item {
        border: 1px solid #e7edf5;
        background: #f8fbff;
        border-radius: 16px;
        padding: 16px;
    }

    .catatan-name {
        font-size: 14px;
        font-weight: 800;
        color: #0f2b5b;
        margin-bottom: 6px;
    }

    .catatan-text {
        font-size: 14px;
        color: #334155;
        line-height: 1.7;
        margin-bottom: 8px;
    }

    .catatan-date {
        font-size: 12px;
        color: #64748b;
    }

    .detail-actions {
        margin-top: 22px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
        padding-top: 18px;
        border-top: 1px solid #edf2f7;
    }

    .action-note {
        font-size: 13px;
        color: #64748b;
        line-height: 1.7;
    }

    .action-buttons {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-action {
        border-radius: 12px;
        padding: 11px 18px;
        font-weight: 800;
        font-size: 14px;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-action:hover {
        transform: translateY(-1px);
    }

    .btn-back-custom {
        background: #e2e8f0;
        color: #1f2937;
    }

    .btn-back-custom:hover {
        background: #d5dde7;
        color: #111827;
    }

    .btn-revisi-custom {
        background: #f2ca45;
        color: #1f2937;
    }

    .btn-revisi-custom:hover {
        background: #e6bc2e;
        color: #111827;
    }

    @media (max-width: 992px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .detail-head {
            padding: 22px 18px 16px;
        }

        .detail-body {
            padding: 18px;
        }

        .detail-head-top {
            flex-direction: column;
            align-items: flex-start;
        }

        .detail-status-box {
            min-width: 100%;
        }

        .detail-table th,
        .detail-table td {
            display: block;
            width: 100%;
        }

        .detail-table th {
            border-bottom: none;
            padding-bottom: 6px;
        }

        .detail-table td {
            padding-top: 0;
        }

        .detail-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .action-buttons {
            width: 100%;
        }

        .action-buttons .btn-action {
            flex: 1 1 100%;
            justify-content: center;
        }
    }
</style>

<div class="container-fluid detail-page">
    <div class="detail-page-inner">
        <div class="detail-shell">

            <div class="detail-head">
                <div class="detail-head-top">
                    <div>
                        <div class="detail-title">Detail SOP</div>
                        <p class="detail-subtitle">
                            Informasi lengkap dokumen SOP, lampiran file, status proses, dan catatan tindak lanjut.
                        </p>
                    </div>

                    <div class="detail-status-box">
                        <div class="detail-status-label">Status SOP</div>
                        @if($sop->status == 'draft')
                            <span class="status-pill" style="background:#e5e7eb;color:#374151;">
                                <i class="bi bi-pencil-square"></i> Draft
                            </span>
                        @elseif($sop->status == 'diajukan')
                            <span class="status-pill" style="background:#dbeafe;color:#1d4ed8;">
                                <i class="bi bi-send"></i> Diajukan
                            </span>
                        @elseif($sop->status == 'dikembalikan_admin')
                            <span class="status-pill" style="background:#fef3c7;color:#92400e;">
                                <i class="bi bi-arrow-counterclockwise"></i> Dikembalikan Admin
                            </span>
                        @elseif($sop->status == 'dikembalikan_kepala')
                            <span class="status-pill" style="background:#cffafe;color:#155e75;">
                                <i class="bi bi-arrow-repeat"></i> Dikembalikan Kepala
                            </span>
                        @elseif($sop->status == 'ditolak_direktur')
                            <span class="status-pill" style="background:#fee2e2;color:#b91c1c;">
                                <i class="bi bi-x-octagon"></i> Ditolak Direktur
                            </span>
                        @elseif($sop->status == 'diverifikasi_admin')
                            <span class="status-pill" style="background:#dcfce7;color:#166534;">
                                <i class="bi bi-check-circle"></i> Diverifikasi Admin
                            </span>
                        @elseif($sop->status == 'nomor_booking')
                            <span class="status-pill" style="background:#e0f2fe;color:#075985;">
                                <i class="bi bi-bookmark-check"></i> Nomor Dibooking
                            </span>
                        @elseif($sop->status == 'nomor_final')
                            <span class="status-pill" style="background:#e5e7eb;color:#111827;">
                                <i class="bi bi-hash"></i> Nomor Final
                            </span>
                        @elseif($sop->status == 'dikirim_ke_umum')
                            <span class="status-pill" style="background:#dbeafe;color:#1d4ed8;">
                                <i class="bi bi-box-arrow-right"></i> Dikirim ke Umum
                            </span>
                        @elseif($sop->status == 'ditandatangani')
                            <span class="status-pill" style="background:#dcfce7;color:#166534;">
                                <i class="bi bi-pen"></i> Ditandatangani
                            </span>
                        @elseif($sop->status == 'diarsipkan')
                            <span class="status-pill" style="background:#e5e7eb;color:#374151;">
                                <i class="bi bi-archive"></i> Diarsipkan
                            </span>
                        @else
                            <span class="status-pill" style="background:#f3f4f6;color:#374151;">
                                <i class="bi bi-info-circle"></i> {{ $sop->status }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="detail-body">
                <div class="detail-grid">
                    <div class="detail-card">
                        <div class="detail-card-header">
                            Informasi Detail SOP
                        </div>
                        <div class="detail-card-body">
                            <table class="detail-table">
                                <tr>
                                    <th>Kode Unit</th>
                                    <td>{{ $sop->kode_unit }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Unit</th>
                                    <td>{{ $sop->nama_unit }}</td>
                                </tr>
                                <tr>
                                    <th>Kode Jenis SOP</th>
                                    <td>{{ $sop->kode_jenis }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Jenis SOP</th>
                                    <td>{{ $sop->nama_jenis }}</td>
                                </tr>
                                <tr>
                                    <th>Nama SOP</th>
                                    <td>{{ $sop->nama_sop }}</td>
                                </tr>
                                <tr>
                                    <th>Tahun Berlaku</th>
                                    <td>{{ $sop->tahun_berlaku }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pembuatan</th>
                                    <td>{{ $sop->tanggal_pembuatan }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Revisi</th>
                                    <td>{{ $sop->tanggal_revisi ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Efektif</th>
                                    <td>{{ $sop->tanggal_efektif }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="detail-card">
                        <div class="detail-card-header">
                            File Lampiran & Status
                        </div>
                        <div class="detail-card-body">
                            <div class="file-box">
                                <div class="file-title">File Draft SOP</div>
                                <div class="file-desc">
                                    Dokumen draft SOP yang diunggah pada saat pengajuan.
                                </div>
<a href="{{ route('unit.sop.lihatDraft', $sop->id) }}" target="_blank" class="btn-file">
    <i class="bi bi-box-arrow-up-right"></i> Buka File Draft
</a>
                            </div>

                            <div class="file-box">
                                <div class="file-title">File Surat Permohonan</div>
                                <div class="file-desc">
                                    Dokumen surat permohonan yang menyertai pengajuan SOP.
                                </div>
<a href="{{ route('unit.sop.lihatSurat', $sop->id) }}" target="_blank" class="btn-file">
    <i class="bi bi-box-arrow-up-right"></i> Buka Surat Permohonan
</a>
                            </div>
                        </div>
                    </div>
                </div>

                @if($catatans->count())
                    <div class="detail-card mt-4">
                        <div class="detail-card-header">
                            Catatan Pemeriksa / Admin
                        </div>
                        <div class="detail-card-body">
                            <div class="catatan-list">
                                @foreach($catatans as $catatan)
                                    <div class="catatan-item">
                                        <div class="catatan-name">{{ $catatan->name }}</div>
                                        <div class="catatan-text">{{ $catatan->isi_catatan }}</div>
                                        <div class="catatan-date">{{ $catatan->created_at }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <div class="detail-actions">
                    <div class="action-note">
                        Gunakan halaman ini untuk meninjau detail SOP dan melihat catatan sebelum melakukan revisi jika diperlukan.
                    </div>

                    <div class="action-buttons">
                        <a href="{{ route('unit.sop') }}" class="btn btn-action btn-back-custom">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>

                        @if(in_array($sop->status, ['draft', 'dikembalikan_admin', 'dikembalikan_kepala', 'ditolak_direktur']))
                            <a href="{{ route('unit.sop.edit', $sop->id) }}" class="btn btn-action btn-revisi-custom">
                                <i class="bi bi-pencil-square"></i> Revisi SOP
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection