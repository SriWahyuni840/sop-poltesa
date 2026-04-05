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
        min-width: 1360px;
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

    .badge-status-blue { background: #3b82f6; color: #fff; }
    .badge-status-yellow { background: #facc15; color: #fff; }
    .badge-status-green { background: #22c55e; color: #fff; }
    .badge-status-cyan { background: #06b6d4; color: #fff; }
    .badge-status-gray { background: #64748b; color: #fff; }
    .badge-status-red { background: #ef4444; color: #fff; }

    .btn-file,
    .btn-aksi {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 6px 10px;
        font-size: 11px;
        font-weight: 700;
        border-radius: 4px;
        text-decoration: none;
        border: none;
        white-space: nowrap;
        color: #fff;
        line-height: 1.2;
    }

    .btn-open {
        background: #3b82f6;
        color: #fff;
    }

    .btn-open:hover {
        background: #2563eb;
        color: #fff;
    }

    .btn-download {
        background: #22c55e;
        color: #fff;
    }

    .btn-download:hover {
        background: #16a34a;
        color: #fff;
    }

    .btn-booking { background: #3b82f6; color: #fff; }
    .btn-final { background: #22c55e; color: #fff; }
    .btn-generate { background: #f59e0b; color: #fff; }
    .btn-kirim { background: #64748b; color: #fff; }
    .btn-arsip { background: #ef4444; color: #fff; }

    .btn-booking:hover,
    .btn-final:hover,
    .btn-generate:hover,
    .btn-kirim:hover,
    .btn-arsip:hover {
        filter: brightness(0.95);
        color: #fff;
    }

    .file-actions,
    .action-group {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .action-group form {
        margin: 0;
    }

    .aksi-text {
        font-size: 11px;
        font-weight: 600;
        color: rgba(255,255,255,0.75);
    }

    .aksi-selesai {
        color: #22c55e;
        font-weight: 700;
        font-size: 11px;
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

    .file-icon-box {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 32px;
    }

    .empty-file {
        font-size: 11px;
        color: rgba(255,255,255,0.65);
    }

    .col-file {
        width: 110px;
        text-align: center;
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

<div class="sidinar-shell mb-3">
    <div class="sidinar-header">
        <div>
            <h5 class="sidinar-title">Daftar SOP yang Belum Diberi Nomor</h5>
            <div class="sidinar-subtitle">Khusus SOP yang sudah diverifikasi admin dan siap dibooking nomor</div>
        </div>

        <div class="sidinar-tools">
            <div class="entries-box">
                <select id="entriesBelumDinomori">
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span>entri per halaman</span>
            </div>

            <input
                type="text"
                id="searchBelumDinomori"
                class="search-input"
                placeholder="Pencarian">
        </div>
    </div>

    <div class="table-wrap">
        <table class="sidinar-table" id="tableBelumDinomori">
            <thead>
                <tr>
                    <th width="45" class="text-center">No.</th>
                    <th width="170">Jenis SOP</th>
                    <th>Nama SOP</th>
                    <th width="110">Klasifikasi</th>
                    <th width="150">Tanggal Dibuat</th>
                    <th width="220">Unit Kerja</th>
                    <th width="150" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($belumDinomori as $index => $item)
                    <tr>
                        <td class="text-center row-number-belum">{{ $index + 1 }}</td>
                        <td>{{ $item->nama_jenis }}</td>
                        <td class="nama-sop-cell">{{ $item->nama_sop }}</td>
                        <td>{{ $item->kode_jenis }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pembuatan)->format('Y-m-d H:i') }}</td>
                        <td>{{ $item->nama_unit }}</td>
                        <td class="text-center">
                            <form action="{{ route('admin.penomoran.booking', $item->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn-aksi btn-booking">Booking Nomor</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada SOP yang belum dinomori</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <div id="infoBelumDinomori">Menampilkan 1 hingga 10 dari {{ count($belumDinomori) }} entri</div>
        <div>Total data: {{ count($belumDinomori) }}</div>
    </div>
</div>

<div class="sidinar-shell">
    @if(session('success'))
        <div class="alert alert-success mb-2">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mb-2">{{ session('error') }}</div>
    @endif

    <div class="sidinar-header">
        <div>
            <h5 class="sidinar-title">Penomoran SOP</h5>
            <div class="sidinar-subtitle">Daftar SOP berdasarkan tahapan proses admin</div>
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
        <table class="sidinar-table" id="penomoranTable">
            <thead>
                <tr>
                    <th width="45" class="text-center">No.</th>
                    <th width="90">Kode Unit</th>
                    <th width="180">Jenis SOP</th>
                    <th>Nama SOP</th>
                    <th width="140">Status SOP</th>
                    <th width="180">Nomor SOP</th>
                    <th width="110">Status Nomor</th>
                    <th class="col-file">Draft SOP</th>
                    <th class="col-file">Dokumen Resmi</th>
                    <th width="240">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sops as $index => $sop)
                    @php
                        $extDraft = !empty($sop->file_draft) ? strtolower(pathinfo($sop->file_draft, PATHINFO_EXTENSION)) : '';
                        $dokumenResmiPath = !empty($sop->file_final) ? $sop->file_final : (!empty($sop->file_bernomor) ? $sop->file_bernomor : '');
                        $extDokumenResmi = !empty($dokumenResmiPath) ? strtolower(pathinfo($dokumenResmiPath, PATHINFO_EXTENSION)) : '';
                    @endphp

                    <tr>
                        <td class="text-center row-number">{{ $index + 1 }}</td>
                        <td>{{ $sop->kode_unit }}</td>
                        <td>{{ $sop->kode_jenis }} - {{ $sop->nama_jenis }}</td>
                        <td class="nama-sop-cell">{{ $sop->nama_sop }}</td>

                        <td>
                            @if($sop->status == 'diverifikasi_admin')
                                <span class="badge-status badge-status-blue">Diverifikasi Admin</span>
                            @elseif($sop->status == 'nomor_booking')
                                <span class="badge-status badge-status-yellow">Nomor Booking</span>
                            @elseif($sop->status == 'disetujui_kepala')
                                <span class="badge-status badge-status-green">Disetujui Kepala</span>
                            @elseif($sop->status == 'nomor_final')
                                <span class="badge-status badge-status-cyan">Nomor Final</span>
                            @elseif($sop->status == 'dikirim_ke_umum')
                                <span class="badge-status badge-status-gray">Dikirim ke Umum</span>
                            @elseif($sop->status == 'dikirim_ke_direktur')
                                <span class="badge-status badge-status-gray">Dikirim ke Direktur</span>
                            @else
                                <span class="badge-status badge-status-gray">{{ $sop->status }}</span>
                            @endif
                        </td>

                        <td class="nomor-sop-cell">{{ $sop->nomor_sop ?? '-' }}</td>

                        <td>
                            @if($sop->status_nomor == 'booking')
                                <span class="badge-status badge-status-yellow">Booking</span>
                            @elseif($sop->status_nomor == 'final')
                                <span class="badge-status badge-status-green">Final</span>
                            @else
                                <span class="aksi-text">-</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <div class="file-icon-box">
                                @if(!empty($sop->file_draft))
                                    <a href="{{ route('admin.verifikasi.lihatDraft', $sop->id) }}" target="_blank" class="file-icon-link" title="Lihat Draft SOP">
                                        @if(in_array($extDraft, ['doc', 'docx']))
                                            <i class="bi bi-file-earmark-word-fill text-primary"></i>
                                        @elseif($extDraft === 'pdf')
                                            <i class="bi bi-file-earmark-pdf-fill text-danger"></i>
                                        @else
                                            <i class="bi bi-file-earmark text-light"></i>
                                        @endif
                                    </a>
                                @else
                                    <span class="empty-file">-</span>
                                @endif
                            </div>
                        </td>

                        <td class="text-center">
                            <div class="file-icon-box">
                                @if(!empty($dokumenResmiPath))
                                    <a href="{{ route('admin.penomoran.buka', $sop->id) }}" target="_blank" class="file-icon-link" title="Buka Dokumen Resmi">
                                        @if(in_array($extDokumenResmi, ['doc', 'docx']))
                                            <i class="bi bi-file-earmark-word-fill text-primary"></i>
                                        @elseif($extDokumenResmi === 'pdf')
                                            <i class="bi bi-file-earmark-pdf-fill text-danger"></i>
                                        @else
                                            <i class="bi bi-file-earmark text-light"></i>
                                        @endif
                                    </a>
                                @else
                                    <span class="empty-file">-</span>
                                @endif
                            </div>
                        </td>

                        <td>
                            <div class="action-group">
                                @if($sop->status == 'diverifikasi_admin')
                                    <form action="{{ route('admin.penomoran.booking', $sop->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-aksi btn-booking">Booking Nomor</button>
                                    </form>
                                @elseif($sop->status == 'nomor_booking')
                                    <span class="aksi-text">Menunggu review Kepala</span>
                                @elseif($sop->status == 'disetujui_kepala')
                                    <form action="{{ route('admin.penomoran.finalisasi', $sop->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-aksi btn-final">Finalisasi Nomor</button>
                                    </form>
                                @elseif($sop->status == 'nomor_final' && empty($sop->file_bernomor))
                                    <form action="{{ route('admin.penomoran.generateFile', $sop->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-aksi btn-generate">Generate Dokumen</button>
                                    </form>
                                @elseif($sop->status == 'nomor_final' && $sop->file_bernomor)
                                    <div class="action-group">
                                        <a href="{{ route('admin.penomoran.download', $sop->id) }}" class="btn-file btn-download">
                                            <i class="bi bi-download"></i> Download
                                        </a>
                                        <form action="{{ route('admin.kirim.umum', $sop->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-aksi btn-kirim">Kirim ke Umum</button>
                                        </form>
                                    </div>
                                @elseif($sop->status == 'dikirim_ke_umum')
                                    <div class="action-group">
                                        <a href="{{ route('admin.penomoran.download', $sop->id) }}" class="btn-file btn-download">
                                            <i class="bi bi-download"></i> Download
                                        </a>
                                        <span class="aksi-text">Sudah dikirim ke Umum</span>
                                    </div>
                                @elseif($sop->status == 'dikirim_ke_direktur')
                                    <div class="action-group">
                                        <a href="{{ route('admin.penomoran.download', $sop->id) }}" class="btn-file btn-download">
                                            <i class="bi bi-download"></i> Download
                                        </a>
                                        <span class="aksi-text">Menunggu Direktur</span>
                                    </div>
                                @else
                                    <span class="aksi-text">-</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">Belum ada data SOP</td>
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
    const table = document.getElementById('penomoranTable');
    const tbody = table.querySelector('tbody');
    const allRows = Array.from(tbody.querySelectorAll('tr')).filter(row => row.children.length > 1);
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

document.addEventListener('DOMContentLoaded', function () {
    const searchInputBelum = document.getElementById('searchBelumDinomori');
    const entriesBelum = document.getElementById('entriesBelumDinomori');
    const tableBelum = document.getElementById('tableBelumDinomori');

    if (searchInputBelum && entriesBelum && tableBelum) {
        const tbodyBelum = tableBelum.querySelector('tbody');
        const allRowsBelum = Array.from(tbodyBelum.querySelectorAll('tr')).filter(row => row.children.length > 1);
        const infoBelum = document.getElementById('infoBelumDinomori');

        let filteredRowsBelum = [...allRowsBelum];

        function renderBelumDinomori() {
            const keyword = searchInputBelum.value.toLowerCase().trim();
            const perPage = parseInt(entriesBelum.value, 10);

            filteredRowsBelum = allRowsBelum.filter(row => row.innerText.toLowerCase().includes(keyword));

            allRowsBelum.forEach(row => row.style.display = 'none');

            const visibleRows = filteredRowsBelum.slice(0, perPage);
            visibleRows.forEach((row, index) => {
                row.style.display = '';
                const noCell = row.querySelector('.row-number-belum');
                if (noCell) noCell.textContent = index + 1;
            });

            const total = filteredRowsBelum.length;
            const from = total > 0 ? 1 : 0;
            const to = Math.min(perPage, total);

            infoBelum.textContent = `Menampilkan ${from} hingga ${to} dari ${total} entri`;
        }

        searchInputBelum.addEventListener('keyup', renderBelumDinomori);
        entriesBelum.addEventListener('change', renderBelumDinomori);

        renderBelumDinomori();
    }
});
</script>
@endsection