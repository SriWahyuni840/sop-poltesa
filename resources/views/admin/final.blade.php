@extends('layouts.admin')

@section('content')
<style>
    .sidinar-shell {
        background: #202552;
        border: 1px solid rgba(255,255,255,0.08);
        padding: 12px 12px 8px;
        color: #fff;
    }

    .sidinar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }

    .sidinar-title {
        font-size: 15px;
        font-weight: 700;
        color: #fff;
        margin: 0;
    }

    .sidinar-subtitle {
        font-size: 11px;
        color: rgba(255,255,255,0.75);
        margin-top: 2px;
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
        font-size: 10px;
        color: #fff;
    }

    .entries-box select,
    .search-input {
        background: #1a1f46;
        border: 1px solid rgba(255,255,255,0.15);
        color: #fff;
        height: 30px;
        border-radius: 4px;
        font-size: 10px;
        padding: 4px 8px;
    }

    .search-input {
        width: 160px;
    }

    .search-input::placeholder {
        color: rgba(255,255,255,0.5);
    }

    .table-wrap {
        overflow-x: auto;
    }

    .sidinar-table {
        width: 100%;
        min-width: 1250px;
        border-collapse: collapse;
        color: #fff;
    }

    .sidinar-table thead th {
        font-size: 10px;
        font-weight: 700;
        color: #fff;
        padding: 8px 6px;
        border-bottom: 1px solid rgba(255,255,255,0.14);
        white-space: nowrap;
    }

    .sidinar-table tbody td {
        font-size: 10px;
        color: #fff;
        padding: 8px 6px;
        border-bottom: 1px solid rgba(255,255,255,0.14);
        vertical-align: middle;
        line-height: 1.4;
    }

    .sidinar-table tbody tr:hover td {
        background: rgba(255,255,255,0.02);
    }

    .text-center { text-align: center; }

    .badge-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 700;
        white-space: nowrap;
        color: #fff;
    }

    .badge-disahkan { background: #f97316; }
    .badge-arsip { background: #22c55e; }

    .btn-aksi {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        padding: 5px 8px;
        font-size: 10px;
        font-weight: 700;
        border-radius: 4px;
        text-decoration: none;
        border: none;
        white-space: nowrap;
        color: #fff;
        line-height: 1.2;
    }

    .btn-arsip {
        background: #3b82f6;
    }

    .btn-arsip:hover {
        background: #2563eb;
        color: #fff;
    }

    .aksi-selesai {
        color: #22c55e;
        font-weight: 700;
        font-size: 10px;
    }

    .btn-file {
        background: #64748b;
    }

    .btn-file:hover {
        background: #475569;
        color: #fff;
    }

    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        padding-top: 8px;
        font-size: 10px;
        color: #fff;
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
            <h5 class="sidinar-title">Pengesahan dan Arsip SOP</h5>
            <div class="sidinar-subtitle">
                Daftar SOP yang telah memperoleh pengesahan pejabat berwenang dan siap didistribusikan atau diarsipkan
            </div>
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

            <input type="text" id="tableSearch" class="search-input" placeholder="Pencarian">
        </div>
    </div>

    <div class="table-wrap">
        <table class="sidinar-table" id="finalTable">
            <thead>
                <tr>
                    <th width="45" class="text-center">No</th>
                    <th width="180">Nomor SOP</th>
                    <th width="180">Jenis SOP</th>
                    <th>Judul SOP</th>
                    <th width="110">Klasifikasi</th>
                    <th width="140">Tanggal Penetapan</th>
                    <th width="220">Unit Pengusul</th>
                    <th width="120" class="text-center">Status Dokumen</th>
                    <th width="120" class="text-center">Dokumen</th>
                    <th width="120" class="text-center">Tindak Lanjut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $row)
                    <tr>
                        <td class="text-center row-number">{{ $i + 1 }}</td>
                        <td>{{ $row->nomor_sop ?? '-' }}</td>
                        <td>{{ $row->nama_jenis ?? '-' }}</td>
                        <td>{{ $row->nama_sop ?? '-' }}</td>
                        <td>{{ $row->kode_jenis ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->updated_at)->format('Y-m-d') }}</td>
                        <td>{{ $row->nama_unit ?? '-' }}</td>
                        <td class="text-center">
                            @if($row->status == 'ditandatangani')
                                <span class="badge-status badge-disahkan">Telah Disahkan</span>
                            @elseif($row->status == 'diarsipkan')
                                <span class="badge-status badge-arsip">Arsip Final</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if(!empty($row->file_final))
                                <a href="{{ route('admin.penomoran.buka', $row->id) }}" target="_blank" class="btn-aksi btn-file">Lihat</a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center">
                            @if($row->status == 'ditandatangani')
                                <form action="{{ route('sop.arsip', $row->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn-aksi btn-arsip">Tetapkan Arsip</button>
                                </form>
                            @elseif($row->status == 'diarsipkan')
                                <span class="aksi-selesai">Selesai</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada data SOP pengesahan/arsip</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <div id="tableInfo">Menampilkan 1 hingga 10 dari {{ count($data) }} entri</div>
        <div>Total data: {{ count($data) }}</div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('tableSearch');
    const entriesSelect = document.getElementById('entriesPerPage');
    const table = document.getElementById('finalTable');
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
</script>
@endsection