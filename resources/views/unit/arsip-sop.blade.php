@extends('layouts.unit')

@section('content')
<style>
    .arsip-page {
        background: #31376f;
        min-height: calc(100vh - 72px);
        padding: 0 18px 22px;
        color: #fff;
    }

    .arsip-shell {
        background: #394081;
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 16px;
        padding: 18px;
    }

    .arsip-inner {
        background: #23285d;
        border: 1px solid rgba(255,255,255,0.06);
        padding: 14px 14px 10px;
    }

    .arsip-title {
        font-size: 18px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 4px;
    }

    .arsip-subtitle {
        font-size: 13px;
        color: rgba(255,255,255,0.76);
        margin-bottom: 14px;
        line-height: 1.6;
    }

    .arsip-tools {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        margin-bottom: 14px;
        flex-wrap: wrap;
    }

    .per-page-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: #fff;
    }

    .per-page-select,
    .search-box-dark {
        height: 30px;
        border-radius: 4px;
        border: 1px solid rgba(255,255,255,0.16);
        background: #1d224f;
        color: #fff;
        font-size: 12px;
        outline: none;
    }

    .per-page-select {
        width: 58px;
        padding: 0 6px;
    }

    .search-box-dark {
        width: 160px;
        padding: 0 10px;
    }

    .search-box-dark::placeholder {
        color: rgba(255,255,255,0.48);
    }

    .table-wrap-dark {
        width: 100%;
        overflow-x: auto;
    }

    .table-arsip {
        width: 100%;
        min-width: 1500px;
        border-collapse: collapse;
        margin: 0;
    }

    .table-arsip thead th {
        color: #ffffff;
        font-size: 12px;
        font-weight: 700;
        text-align: left;
        padding: 12px 10px;
        border-bottom: 1px solid rgba(255,255,255,0.14);
        background: transparent;
        white-space: nowrap;
    }

    .table-arsip tbody td {
        color: #ffffff;
        font-size: 12px;
        padding: 11px 10px;
        border-bottom: 1px solid rgba(255,255,255,0.10);
        vertical-align: middle;
    }

    .table-arsip tbody tr:hover td {
        background: rgba(255,255,255,0.02);
    }

    .text-center-col {
        text-align: center;
    }

    .sop-name {
        font-weight: 700;
        color: #ffffff;
        line-height: 1.5;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 72px;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 800;
        color: #fff;
        background: #22c55e;
        line-height: 1.2;
    }

    .doc-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: #1f78ff;
    }

    .doc-link:hover {
        filter: brightness(1.08);
    }

    .doc-link i {
        font-size: 44px;
        line-height: 1;
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
        color: #ffffff;
        font-size: 12px;
    }

    .hidden-row {
        display: none !important;
    }

    @media (max-width: 768px) {
        .arsip-page {
            padding: 0 10px 14px;
        }

        .arsip-tools,
        .bottom-bar {
            flex-direction: column;
            align-items: flex-start;
        }

        .search-box-dark {
            width: 100%;
        }
    }
</style>

<div class="arsip-page">
    <div class="arsip-shell">
        <div class="arsip-inner">
            <div class="arsip-title">Arsip SOP</div>
            <div class="arsip-subtitle">
                Daftar SOP yang sudah masuk tahap arsip dan telah disahkan direktur.
            </div>

            <div class="arsip-tools">
                <div class="per-page-wrap">
                    <select class="per-page-select">
                        <option selected>10</option>
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                    <span>entri per halaman</span>
                </div>

                <input type="text" id="searchArsip" class="search-box-dark" placeholder="Pencarian">
            </div>

            <div class="table-wrap-dark">
                <table class="table-arsip" id="tableArsip">
                    <thead>
                        <tr>
                            <th style="width:45px;" class="text-center-col">No.</th>
                            <th style="width:190px;">Nomor SOP</th>
                            <th>Nama SOP</th>
                            <th style="width:210px;">Unit Kerja</th>
                            <th style="width:110px;" class="text-center-col">Tahun Berlaku</th>
                            <th style="width:120px;" class="text-center-col">Status</th>
                            <th style="width:170px;">Tanggal Efektif</th>
                            <th style="width:110px;" class="text-center-col">Dokumen</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($sops as $index => $sop)
                            <tr class="arsip-row">
                                <td class="text-center-col">{{ $index + 1 }}</td>
                                <td>{{ $sop->nomor_sop ?? '-' }}</td>
                                <td>
                                    <div class="sop-name">{{ $sop->nama_sop }}</div>
                                </td>
                                <td>{{ $sop->nama_unit }}</td>
                                <td class="text-center-col">{{ $sop->tahun_berlaku }}</td>
                                <td class="text-center-col">
                                    <span class="status-badge">
                                        {{ $sop->status == 'diarsipkan' ? 'Diarsipkan' : 'Disahkan' }}
                                    </span>
                                </td>
                                <td>
                                    {{ $sop->tanggal_efektif ? \Carbon\Carbon::parse($sop->tanggal_efektif)->format('Y-m-d') : '-' }}
                                </td>
                                <td class="text-center-col">
                                    @if(!empty($sop->file_final))
                                        <a href="{{ route('unit.sop.lihatFinal', $sop->id) }}" target="_blank" class="doc-link" title="Lihat Dokumen Final">
                                            <i class="bi bi-file-earmark-word-fill"></i>
                                        </a>
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr id="emptyStaticRow">
                                <td colspan="8">
                                    <div class="empty-state-dark">
                                        <i class="bi bi-folder2-open"></i>
                                        <h6>Belum Ada Arsip SOP</h6>
                                        <div>Dokumen yang sudah disahkan direktur belum tersedia.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                        <tr id="emptySearchRow" class="hidden-row">
                            <td colspan="8">
                                <div class="empty-state-dark">
                                    <i class="bi bi-search"></i>
                                    <h6>Data Tidak Ditemukan</h6>
                                    <div>Coba gunakan kata kunci pencarian lain.</div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="bottom-bar">
                <div>Menampilkan 1 hingga {{ count($sops) }} dari {{ count($sops) }} entri</div>
                <div>Total data: {{ count($sops) }}</div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchArsip');
        const rows = document.querySelectorAll('#tableArsip tbody tr.arsip-row');
        const emptySearchRow = document.getElementById('emptySearchRow');

        if (!searchInput) return;

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
    });
</script>
@endsection