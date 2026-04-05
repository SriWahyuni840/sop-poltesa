@extends('layouts.admin')

@section('content')
<style>
    .sidinar-shell {
        background: #202552;
        border: 1px solid rgba(255,255,255,0.08);
        padding: 14px 14px 10px;
        color: #fff;
    }

    .sidinar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }

    .sidinar-title {
        font-size: 16px;
        font-weight: 700;
        color: #fff;
        margin: 0;
    }

    .sidinar-subtitle {
        font-size: 12px;
        color: rgba(255,255,255,0.75);
        margin-top: 3px;
    }

    .sidinar-tools {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .entries-box {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        color: #fff;
    }

    .entries-box select {
        background: #1a1f46;
        border: 1px solid rgba(255,255,255,0.15);
        color: #fff;
        height: 30px;
        border-radius: 4px;
        font-size: 11px;
        padding: 4px 8px;
    }

    .search-input {
        background: #1a1f46;
        border: 1px solid rgba(255,255,255,0.15);
        color: #fff;
        height: 30px;
        border-radius: 4px;
        font-size: 11px;
        padding: 4px 10px;
        width: 160px;
        outline: none;
    }

    .search-input::placeholder {
        color: rgba(255,255,255,0.5);
    }

    .table-wrap {
        overflow-x: auto;
    }

    .sidinar-table {
        width: 100%;
        min-width: 1260px;
        border-collapse: collapse;
        color: #fff;
    }

    .sidinar-table thead th {
        font-size: 12px;
        font-weight: 700;
        color: #fff;
        padding: 10px 8px;
        border-bottom: 1px solid rgba(255,255,255,0.14);
        white-space: nowrap;
        vertical-align: middle;
    }

    .sidinar-table tbody td {
        font-size: 12px;
        color: #fff;
        padding: 10px 8px;
        border-bottom: 1px solid rgba(255,255,255,0.14);
        vertical-align: middle;
        line-height: 1.45;
    }

    .sidinar-table tbody tr:hover td {
        background: rgba(255,255,255,0.02);
    }

    .text-center {
        text-align: center;
    }

    .nama-sop-cell {
        min-width: 240px;
        font-weight: 600;
        font-size: 13px;
        color: #fff;
    }

    .nomor-sop-cell {
        white-space: nowrap;
        min-width: 180px;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 700;
        line-height: 1.2;
        white-space: nowrap;
        border: none;
    }

    .badge-arsip {
        background: #22c55e;
        color: #fff;
    }

    .alert {
        font-size: 12px;
        padding: 8px 10px;
        border-radius: 4px;
    }

    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        padding-top: 10px;
        font-size: 11px;
        color: #fff;
    }

    .empty-state {
        text-align: center;
        padding: 24px 12px;
        color: rgba(255,255,255,0.8);
        font-size: 12px;
    }

    .file-icon-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 44px;
        line-height: 1;
        transition: transform 0.15s ease;
    }

    .file-icon-link:hover {
        transform: scale(1.1);
    }

    .empty-file {
        font-size: 11px;
        color: rgba(255,255,255,0.65);
    }

    @media (max-width: 991px) {
        .sidinar-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .sidinar-tools {
            width: 100%;
            justify-content: space-between;
        }
    }
</style>

<div class="sidinar-shell">
    @if(session('success'))
        <div class="alert alert-success mb-2">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mb-2">{{ session('error') }}</div>
    @endif

    <div class="sidinar-header">
        <div>
            <h5 class="sidinar-title">Arsip SOP</h5>
            <div class="sidinar-subtitle">Daftar SOP yang sudah masuk tahap arsip</div>
        </div>

        <div class="sidinar-tools">
            <div class="entries-box">
                <select id="entriesPerPage">
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span>entri per halaman</span>
            </div>

            <input
                type="text"
                id="tableSearch"
                class="search-input"
                placeholder="Pencarian">
        </div>
    </div>

    <div class="table-wrap">
        <table class="sidinar-table" id="arsipTable">
            <thead>
                <tr>
                    <th width="45" class="text-center">No.</th>
                    <th width="200">Nomor SOP</th>
                    <th>Nama SOP</th>
                    <th width="200">Unit Kerja</th>
                    <th width="120">Tahun Berlaku</th>
                    <th width="120">Status</th>
                    <th width="180">Diarsipkan Oleh</th>
                    <th width="170">Tanggal Arsip</th>
                    <th width="110" class="text-center">Dokumen</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sops as $index => $sop)
                    @php
                        $dokumenPath = !empty($sop->file_final) ? $sop->file_final : (!empty($sop->file_bernomor) ? $sop->file_bernomor : '');
                        $extDokumen = !empty($dokumenPath) ? strtolower(pathinfo($dokumenPath, PATHINFO_EXTENSION)) : '';
                    @endphp
                    <tr>
                        <td class="text-center row-number">{{ $index + 1 }}</td>
                        <td class="nomor-sop-cell">{{ $sop->nomor_sop ?? '-' }}</td>
                        <td class="nama-sop-cell">{{ $sop->nama_sop }}</td>
                        <td>{{ $sop->nama_unit ?? '-' }}</td> 
                        <td>{{ $sop->tahun_berlaku ?? '-' }}</td>
                        <td>
                            <span class="badge-status badge-arsip">Diarsipkan</span>
                        </td>
                        <td>{{ $sop->archived_by_name ?? '-' }}</td>
<td>
    {{ $sop->archived_at 
        ? \Carbon\Carbon::parse($sop->archived_at)
            ->timezone('Asia/Jakarta')
            ->translatedFormat('d F Y H:i:s') 
        : '-' }}
</td>
                        <td class="text-center">
                            @if(!empty($dokumenPath))
                                <a href="{{ route('admin.penomoran.buka', $sop->id) }}" target="_blank" class="file-icon-link" title="Buka Dokumen">
                                    @if(in_array($extDokumen, ['doc', 'docx']))
                                        <i class="bi bi-file-earmark-word-fill text-primary"></i>
                                    @elseif($extDokumen === 'pdf')
                                        <i class="bi bi-file-earmark-pdf-fill text-danger"></i>
                                    @else
                                        <i class="bi bi-file-earmark text-light"></i>
                                    @endif
                                </a>
                            @else
                                <span class="empty-file">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                Belum ada SOP yang diarsipkan.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <div id="tableInfo">Menampilkan 1 hingga 10 dari {{ count($sops) }} entri</div>
        <div>Total data: {{ count($sops) }}</div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('tableSearch');
    const entriesSelect = document.getElementById('entriesPerPage');
    const table = document.getElementById('arsipTable');
    const tbody = table.querySelector('tbody');
    const allRows = Array.from(tbody.querySelectorAll('tr')).filter(row => !row.querySelector('.empty-state'));
    const tableInfo = document.getElementById('tableInfo');

    let filteredRows = [...allRows];

    function renderTable() {
        const keyword = searchInput.value.toLowerCase().trim();
        const perPage = parseInt(entriesSelect.value, 10);

        filteredRows = allRows.filter(row => row.innerText.toLowerCase().includes(keyword));

        allRows.forEach(row => row.style.display = 'none');

        const visibleRows = filteredRows.slice(0, perPage);
        visibleRows.forEach((row, index) => {
            row.style.display = '';
            const noCell = row.querySelector('.row-number');
            if (noCell) noCell.textContent = index + 1;
        });

        const total = filteredRows.length;
        const from = total > 0 ? 1 : 0;
        const to = Math.min(perPage, total);

        tableInfo.textContent = `Menampilkan ${from} hingga ${to} dari ${total} entri`;
    }

    searchInput.addEventListener('keyup', renderTable);
    entriesSelect.addEventListener('change', renderTable);

    renderTable();
});
</script>
@endsection