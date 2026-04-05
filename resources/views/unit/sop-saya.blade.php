@extends('layouts.unit')

@section('content')
<style>
    .sop-dark-page {
        background: #2b2f67;
        min-height: calc(100vh - 72px);
        padding: 14px 16px 28px;
        color: #fff;
    }

    .sop-dark-wrap {
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
        color: rgba(255,255,255,0.88);
        font-weight: 600;
    }

    .btn-add-top {
        border: none;
        background: #16a34a;
        color: #fff;
        border-radius: 6px;
        padding: 9px 14px;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-add-top:hover {
        background: #15803d;
        color: #fff;
    }

    .alert-modern {
        border: 0;
        border-radius: 8px;
        padding: 12px 14px;
        font-weight: 600;
        margin-bottom: 14px;
    }

    .sop-card {
        background: #23285d;
        border: 1px solid rgba(255,255,255,0.06);
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.02);
    }

    .sop-card-header {
        padding: 12px 14px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    .sop-card-title {
        font-size: 14px;
        font-weight: 800;
        color: #ffffff;
        margin: 0;
    }

    .sop-card-body {
        padding: 14px;
    }

    .top-tools {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .left-tools,
    .right-tools {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .per-page-select,
    .search-box-dark {
        height: 34px;
        border-radius: 4px;
        border: 1px solid rgba(255,255,255,0.18);
        background: #1d224f;
        color: #fff;
        font-size: 12px;
        outline: none;
    }

    .per-page-select {
        width: 52px;
        padding: 0 6px;
    }

    .search-box-dark {
        width: 200px;
        padding: 0 10px;
    }

    .search-box-dark::placeholder {
        color: rgba(255,255,255,0.55);
    }

    .btn-export-dark {
        border: 1px solid rgba(255,255,255,0.18);
        background: #1d224f;
        color: #fff;
        border-radius: 4px;
        padding: 7px 12px;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-export-dark:hover {
        background: #273069;
        color: #fff;
    }

    .table-wrap-dark {
        width: 100%;
        overflow-x: auto;
        border: 1px solid rgba(255,255,255,0.08);
        background: #202554;
    }

    .table-sop-dark {
        width: 100%;
        min-width: 1320px;
        border-collapse: collapse;
        margin: 0;
    }

    .table-sop-dark thead th {
        color: #ffffff;
        font-size: 12px;
        font-weight: 700;
        text-align: left;
        padding: 10px 10px;
        border-bottom: 1px solid rgba(255,255,255,0.12);
        white-space: nowrap;
        background: #23285d;
    }

    .table-sop-dark tbody td {
        color: #ffffff;
        font-size: 12px;
        padding: 10px 10px;
        border-top: 1px solid rgba(255,255,255,0.10);
        vertical-align: middle;
        background: #23285d;
    }

    .table-sop-dark tbody tr:hover td {
        background: #262c66;
    }

    .text-center-col {
        text-align: center;
    }

    .sop-title-cell {
        font-weight: 700;
        color: #ffffff;
        line-height: 1.5;
    }

    .muted-cell {
        color: rgba(255,255,255,0.72);
    }

    .file-icon-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .file-icon-link.word {
        color: #7cc7ff;
    }

    .file-icon-link.pdf {
        color: #ffb3b3;
    }

    .file-icon-link:hover {
        filter: brightness(1.1);
    }

    .file-icon-link i {
        font-size: 30px;
        line-height: 1;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 800;
        line-height: 1.2;
        white-space: nowrap;
    }

    .badge-red {
        background: #ef4444;
        color: #fff;
    }

    .badge-yellow {
        background: #facc15;
        color: #3b2f00;
    }

    .badge-green {
        background: #22c55e;
        color: #fff;
    }

    .badge-gray {
        background: #64748b;
        color: #fff;
    }

    .aksi-inline {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .aksi-icon-btn {
        border: none;
        background: transparent;
        color: #ffffff;
        padding: 0;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .aksi-icon-btn.edit {
        color: #ffffff;
    }

    .aksi-icon-btn.delete {
        color: #ff5d73;
    }

    .aksi-icon-btn.detail {
        color: #8ec5ff;
    }

    .aksi-icon-btn:hover {
        filter: brightness(1.15);
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

    .pagination-mini {
        display: flex;
        align-items: center;
        gap: 4px;
        flex-wrap: wrap;
    }

    .pagination-mini a,
    .pagination-mini span {
        min-width: 30px;
        height: 30px;
        padding: 0 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        background: #2a315f;
        color: #fff;
        text-decoration: none;
        border: 1px solid rgba(255,255,255,0.08);
        font-size: 12px;
    }

    .pagination-mini .active {
        background: #2563eb;
        border-color: #2563eb;
    }

    .empty-state-dark {
        text-align: center;
        padding: 46px 20px;
        color: rgba(255,255,255,0.72);
    }

    .empty-state-dark i {
        font-size: 40px;
        margin-bottom: 10px;
        color: rgba(255,255,255,0.35);
    }

    .empty-state-dark h6 {
        font-size: 18px;
        font-weight: 800;
        margin-bottom: 6px;
        color: #fff;
    }

    .hidden-row {
        display: none !important;
    }

    @media (max-width: 768px) {
        .sop-dark-page {
            padding: 12px;
        }

        .top-tools,
        .top-line,
        .bottom-bar {
            flex-direction: column;
            align-items: flex-start;
        }

        .right-tools {
            width: 100%;
        }

        .search-box-dark {
            width: 100%;
        }
    }
</style>

@php
    function unitFileIconClass($path) {
        $ext = strtolower(pathinfo((string) $path, PATHINFO_EXTENSION));
        return in_array($ext, ['doc', 'docx']) ? 'word' : (in_array($ext, ['pdf']) ? 'pdf' : 'word');
    }

    function unitFileIconName($path) {
        $ext = strtolower(pathinfo((string) $path, PATHINFO_EXTENSION));
        return in_array($ext, ['pdf']) ? 'bi-file-earmark-pdf-fill' : 'bi-file-earmark-word-fill';
    }
@endphp

<div class="container-fluid sop-dark-page">
    <div class="sop-dark-wrap">

        <div class="top-line">
            <div class="top-line-text">
                Daftar SOP Saya
            </div>

            <a href="{{ route('unit.tambah') }}" class="btn-add-top">
                <i class="bi bi-plus-lg"></i> Tambah Data
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-modern">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-modern">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-modern">
                <div class="fw-bold mb-2">
                    <i class="bi bi-exclamation-octagon-fill me-2"></i>Periksa kembali data yang diinput:
                </div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="sop-card">
            <div class="sop-card-header">
                <h5 class="sop-card-title">SOP Saya</h5>
            </div>

            <div class="sop-card-body">
                <div class="top-tools">
                    <div class="left-tools">
                        <select class="per-page-select" id="perPageSelect">
                            <option selected>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                        <span style="font-size:12px;color:rgba(255,255,255,0.88);">entri per halaman</span>
                    </div>

                    <div class="right-tools">
                        <button type="button" class="btn-export-dark">
                            <i class="bi bi-download"></i> Ekspor
                        </button>
                        <input type="text" id="searchSop" class="search-box-dark" placeholder="Pencarian">
                    </div>
                </div>

                <div class="table-wrap-dark">
                    <table class="table-sop-dark" id="tableSopSaya">
                        <thead>
                            <tr>
                                <th style="width:55px;" class="text-center-col">Tidak</th>
                                <th style="width:120px;">Kode Unit</th>
                                <th style="width:140px;">Jenis SOP</th>
                                <th>Perihal / Nama SOP</th>
                                <th style="width:120px;" class="text-center-col">Tahun</th>
                                <th style="width:145px;" class="text-center-col">Tanggal Buat</th>
                                <th style="width:90px;" class="text-center-col">File SOP</th>
                                <th style="width:90px;" class="text-center-col">Surat</th>
                                <th style="width:120px;" class="text-center-col">Status</th>
                                <th style="width:110px;" class="text-center-col">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($sops as $index => $sop)
                                @php
                                    $status = $sop->status;
                                    $fileDraftClass = unitFileIconClass($sop->file_draft ?? '');
                                    $fileDraftIcon = unitFileIconName($sop->file_draft ?? '');
                                    $fileSuratClass = unitFileIconClass($sop->file_surat_permohonan ?? '');
                                    $fileSuratIcon = unitFileIconName($sop->file_surat_permohonan ?? '');
                                @endphp

                                <tr class="sop-row">
                                    <td class="text-center-col">{{ $index + 1 }}</td>
                                    <td>{{ $sop->kode_unit }}</td>
                                    <td>{{ $sop->nama_jenis ?? $sop->kode_jenis }}</td>
                                    <td>
                                        <div class="sop-title-cell">{{ $sop->nama_sop }}</div>
                                    </td>
                                    <td class="text-center-col">{{ $sop->tahun_berlaku }}</td>
                                    <td class="text-center-col muted-cell">
                                        {{ \Carbon\Carbon::parse($sop->created_at ?? $sop->tanggal_pembuatan)->format('Y-m-d H:i:s') }}
                                    </td>

                                    <td class="text-center-col">
                                        @if(!empty($sop->file_draft))
                                            <a href="{{ route('unit.sop.lihatDraft', $sop->id) }}"
                                               target="_blank"
                                               class="file-icon-link {{ $fileDraftClass }}"
                                               title="Lihat File SOP">
                                                <i class="bi {{ $fileDraftIcon }}"></i>
                                            </a>
                                        @else
                                            <span class="muted-cell">-</span>
                                        @endif
                                    </td>

                                    <td class="text-center-col">
                                        @if(!empty($sop->file_surat_permohonan))
                                            <a href="{{ route('unit.sop.lihatSurat', $sop->id) }}"
                                               target="_blank"
                                               class="file-icon-link {{ $fileSuratClass }}"
                                               title="Lihat Surat">
                                                <i class="bi {{ $fileSuratIcon }}"></i>
                                            </a>
                                        @else
                                            <span class="muted-cell">-</span>
                                        @endif
                                    </td>

                                    <td class="text-center-col">
                                        @if(in_array($status, ['dikembalikan', 'dikembalikan_admin', 'dikembalikan_kepala', 'ditolak_direktur']))
                                            <span class="badge-status badge-red">{{ ucwords(str_replace('_', ' ', $status)) }}</span>
                                        @elseif(in_array($status, ['draft', 'diajukan', 'diverifikasi', 'diverifikasi_admin', 'nomor_booking', 'dikirim_ke_umum']))
                                            <span class="badge-status badge-yellow">{{ ucwords(str_replace('_', ' ', $status)) }}</span>
                                        @elseif(in_array($status, ['nomor_final', 'ditandatangani', 'diarsipkan']))
                                            <span class="badge-status badge-green">{{ ucwords(str_replace('_', ' ', $status)) }}</span>
                                        @else
                                            <span class="badge-status badge-gray">{{ $status }}</span>
                                        @endif
                                    </td>

                                    <td class="text-center-col">
                                        <div class="aksi-inline">
                                            <a href="{{ route('unit.sop.detail', $sop->id) }}"
                                               class="aksi-icon-btn detail"
                                               title="Detail">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>

                                            @if(in_array($sop->status, ['dikembalikan', 'dikembalikan_admin', 'dikembalikan_kepala', 'ditolak_direktur', 'draft']))
                                                <a href="{{ route('unit.sop.edit', $sop->id) }}"
                                                   class="aksi-icon-btn edit"
                                                   title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            @endif

                                            @if(Route::has('unit.sop.hapus'))
                                                <form action="{{ route('unit.sop.hapus', $sop->id) }}"
                                                      method="POST"
                                                      class="m-0"
                                                      onsubmit="return confirm('Yakin ingin menghapus data SOP ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="aksi-icon-btn delete" title="Hapus">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <button type="button"
                                                        class="aksi-icon-btn delete"
                                                        title="Route hapus belum tersedia"
                                                        disabled
                                                        style="opacity:.45;cursor:not-allowed;">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="emptyStaticRow">
                                    <td colspan="10">
                                        <div class="empty-state-dark">
                                            <i class="bi bi-folder2-open"></i>
                                            <h6>Belum Ada Data SOP</h6>
                                            <div>Data SOP unit kerja belum tersedia pada sistem.</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                            <tr id="emptySearchRow" class="hidden-row">
                                <td colspan="10">
                                    <div class="empty-state-dark">
                                        <i class="bi bi-search"></i>
                                        <h6>Data Tidak Ditemukan</h6>
                                        <div>Coba gunakan kata kunci pencarian yang lain.</div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="bottom-bar">
                    <div>
                        Menampilkan 1 hingga {{ count($sops) }} dari {{ count($sops) }} entri
                    </div>

                    <div class="pagination-mini">
                        <span>&laquo;</span>
                        <span>&lsaquo;</span>
                        <span class="active">1</span>
                        <span>2</span>
                        <span>3</span>
                        <span>4</span>
                        <span>&rsaquo;</span>
                        <span>&raquo;</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchSop');
        const rows = document.querySelectorAll('#tableSopSaya tbody tr.sop-row');
        const emptySearchRow = document.getElementById('emptySearchRow');

        if (searchInput) {
            searchInput.addEventListener('keyup', function () {
                const keyword = this.value.toLowerCase().trim();
                let visibleCount = 0;

                rows.forEach(function (row) {
                    const text = row.innerText.toLowerCase();

                    if (text.includes(keyword)) {
                        row.classList.remove('hidden-row');
                        visibleCount++;
                    } else {
                        row.classList.add('hidden-row');
                    }
                });

                if (emptySearchRow) {
                    if (rows.length > 0 && visibleCount === 0) {
                        emptySearchRow.classList.remove('hidden-row');
                    } else {
                        emptySearchRow.classList.add('hidden-row');
                    }
                }
            });
        }
    });
</script>
@endsection