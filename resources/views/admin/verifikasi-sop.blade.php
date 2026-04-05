@extends('layouts.admin')

@section('content')
<style>
    .verifikasi-page {
        background: transparent;
        padding: 0;
    }

    .verifikasi-wrap {
        background: #232a63;
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 0;
        padding: 12px 14px 10px;
        color: #ffffff;
    }

    .verifikasi-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .verifikasi-title {
        font-size: 16px;
        font-weight: 700;
        color: #ffffff;
        margin: 0;
    }

    .verifikasi-tools {
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
        color: #ffffff;
    }

    .entries-box select {
        background: #1d234f;
        border: 1px solid rgba(255,255,255,0.15);
        color: #ffffff;
        font-size: 11px;
        padding: 3px 18px 3px 6px;
        border-radius: 3px;
        height: 28px;
    }

    .search-box input {
        background: #1d234f;
        border: 1px solid rgba(255,255,255,0.18);
        color: #ffffff;
        font-size: 11px;
        padding: 5px 8px;
        border-radius: 3px;
        height: 28px;
        width: 140px;
        outline: none;
    }

    .search-box input::placeholder {
        color: rgba(255,255,255,0.55);
    }

    .table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .table-verifikasi {
        width: 100%;
        min-width: 1180px;
        border-collapse: collapse;
        color: #ffffff;
    }

    .table-verifikasi thead th {
        font-size: 12px;
        font-weight: 700;
        color: #ffffff;
        padding: 10px 8px;
        border-bottom: 1px solid rgba(255,255,255,0.14);
        text-align: left;
        white-space: nowrap;
        vertical-align: middle;
    }

    .table-verifikasi tbody td {
        font-size: 12px;
        color: #ffffff;
        padding: 10px 8px;
        border-bottom: 1px solid rgba(255,255,255,0.14);
        vertical-align: middle;
        line-height: 1.45;
    }

    .table-verifikasi tbody tr:hover td {
        background: rgba(255,255,255,0.02);
    }

    .col-no {
        width: 50px;
        text-align: center;
    }

    .col-unit {
        width: 90px;
    }

    .col-jenis {
        width: 120px;
    }

    .col-tanggal {
        width: 130px;
        white-space: nowrap;
    }

    .col-file {
        width: 110px;
        text-align: center;
    }

    .col-status {
        width: 125px;
        text-align: center;
    }

    .col-aksi {
        width: 270px;
    }

    .nama-sop {
        min-width: 240px;
        color: #ffffff;
        font-weight: 600;
        font-size: 13px;
        line-height: 1.5;
    }

    .file-link-icon {
        background: transparent;
        border: none;
        padding: 0;
        font-size: 26px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: transform 0.15s ease;
    }

    .file-link-icon:hover {
        transform: scale(1.1);
    }

    .empty-file {
        font-size: 11px;
        color: rgba(255,255,255,0.65);
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        border-radius: 999px;
        padding: 5px 10px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
        line-height: 1.2;
    }

    .badge-diajukan {
        background: #facc15;
        color: #ffffff;
    }

    .aksi-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .btn-verif,
    .btn-tolak {
        width: 100%;
        border: none;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 700;
        padding: 7px 10px;
        line-height: 1.2;
        color: #ffffff;
    }

    .btn-verif {
        background: #22c55e;
    }

    .btn-verif:hover {
        background: #16a34a;
    }

    .btn-tolak {
        background: #ef4444;
    }

    .btn-tolak:hover {
        background: #dc2626;
    }

    .catatan-box {
        width: 100%;
        min-height: 52px;
        resize: vertical;
        border-radius: 4px;
        border: 1px solid rgba(255,255,255,0.14);
        background: #1d234f;
        color: #ffffff;
        font-size: 11px;
        padding: 8px 8px;
        outline: none;
    }

    .catatan-box::placeholder {
        color: rgba(255,255,255,0.5);
    }

    .alert-mini {
        border-radius: 4px;
        font-size: 11px;
        padding: 8px 10px;
        margin-bottom: 8px;
    }

    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        padding-top: 10px;
        font-size: 11px;
        color: #ffffff;
    }

    .empty-state {
        text-align: center;
        padding: 24px 12px;
        color: rgba(255,255,255,0.8);
        font-size: 12px;
    }

    @media (max-width: 768px) {
        .verifikasi-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .verifikasi-tools {
            width: 100%;
            justify-content: space-between;
        }

        .search-box input {
            width: 110px;
        }

        .verifikasi-title {
            font-size: 15px;
        }

        .table-verifikasi thead th,
        .table-verifikasi tbody td {
            font-size: 11px;
        }

        .nama-sop {
            font-size: 12px;
        }

        .file-link-icon {
            font-size: 24px;
        }
    }
</style>

<div class="verifikasi-page">
    <div class="verifikasi-wrap">

        @if(session('success'))
            <div class="alert alert-success alert-mini">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-mini">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-mini">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="verifikasi-header">
            <h5 class="verifikasi-title">Verifikasi SOP</h5>

            <div class="verifikasi-tools">
                <div class="entries-box">
                    <select id="entriesPerPage">
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>entri per halaman</span>
                </div>

                <div class="search-box">
                    <input type="text" id="tableSearch" placeholder="Pencarian">
                </div>
            </div>
        </div>

        <div class="table-wrap">
            <table class="table-verifikasi" id="verifikasiTable">
                <thead>
                    <tr>
                        <th class="col-no">Tidak</th>
                        <th class="col-unit">Unit</th>
                        <th class="col-jenis">Jenis SOP</th>
                        <th>Nama SOP</th>
                        <th class="col-tanggal">Tanggal buat</th>
                        <th class="col-file">SOP</th>
                        <th class="col-file">Surat Permohonan</th>
                        <th class="col-status">Status</th>
                        <th class="col-aksi">Verifikasi / Tolak</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sops as $index => $sop)
                        @php
                            $extDraft = $sop->file_draft ? strtolower(pathinfo($sop->file_draft, PATHINFO_EXTENSION)) : '';
                            $extSurat = $sop->file_surat_permohonan ? strtolower(pathinfo($sop->file_surat_permohonan, PATHINFO_EXTENSION)) : '';
                        @endphp

                        <tr>
                            <td class="col-no row-number">{{ $index + 1 }}</td>
                            <td class="col-unit">{{ $sop->kode_unit }}</td>
                            <td class="col-jenis">{{ $sop->kode_jenis }}</td>
                            <td>
                                <div class="nama-sop">{{ $sop->nama_sop }}</div>
                            </td>
                            <td class="col-tanggal">
                                {{ \Carbon\Carbon::parse($sop->tanggal_pembuatan)->translatedFormat('d-m-Y') }}
                            </td>

                            <td class="col-file">
                                @if($sop->file_draft)
                                    <a href="{{ route('admin.verifikasi.lihatDraft', $sop->id) }}" class="file-link-icon" title="File SOP">
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
                            </td>

                            <td class="col-file">
                                @if($sop->file_surat_permohonan)
                                    <a href="{{ route('admin.verifikasi.lihatSurat', $sop->id) }}" class="file-link-icon" title="Surat Permohonan">
                                        @if(in_array($extSurat, ['doc', 'docx']))
                                            <i class="bi bi-file-earmark-word-fill text-primary"></i>
                                        @elseif($extSurat === 'pdf')
                                            <i class="bi bi-file-earmark-pdf-fill text-danger"></i>
                                        @else
                                            <i class="bi bi-file-earmark text-light"></i>
                                        @endif
                                    </a>
                                @else
                                    <span class="empty-file">-</span>
                                @endif
                            </td>

                            <td class="col-status">
                                <span class="badge-status badge-diajukan">belum diverifikasi</span>
                            </td>

                            <td class="col-aksi">
                                <div class="aksi-group">
                                    <form action="{{ route('admin.verifikasi.setujui', $sop->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-verif">Verifikasi</button>
                                    </form>

                                    <form action="{{ route('admin.verifikasi.kembalikan', $sop->id) }}" method="POST">
                                        @csrf
                                        <textarea
                                            name="isi_catatan"
                                            class="catatan-box"
                                            placeholder="Catatan revisi..."
                                            required></textarea>
                                        <button type="submit" class="btn-tolak mt-1">Tolak + Catatan</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    Belum ada SOP yang diajukan.
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
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('tableSearch');
        const entriesSelect = document.getElementById('entriesPerPage');
        const table = document.getElementById('verifikasiTable');
        const tbody = table.querySelector('tbody');
        const allRows = Array.from(tbody.querySelectorAll('tr')).filter(row => !row.querySelector('.empty-state'));
        const tableInfo = document.getElementById('tableInfo');

        let filteredRows = [...allRows];
        let currentPage = 1;

        function updateNumbers(rowsToShow) {
            rowsToShow.forEach((row, index) => {
                const noCell = row.querySelector('.row-number');
                if (noCell) noCell.textContent = index + 1;
            });
        }

        function renderTable() {
            const perPage = parseInt(entriesSelect.value, 10);
            const keyword = searchInput.value.toLowerCase().trim();

            filteredRows = allRows.filter(row => {
                const text = row.innerText.toLowerCase();
                return text.includes(keyword);
            });

            allRows.forEach(row => row.style.display = 'none');

            const start = (currentPage - 1) * perPage;
            const end = start + perPage;
            const pageRows = filteredRows.slice(start, end);

            pageRows.forEach(row => row.style.display = '');
            updateNumbers(pageRows);

            const total = filteredRows.length;
            const from = total === 0 ? 0 : start + 1;
            const to = Math.min(end, total);

            tableInfo.textContent = `Menampilkan ${from} hingga ${to} dari ${total} entri`;
        }

        searchInput.addEventListener('keyup', function () {
            currentPage = 1;
            renderTable();
        });

        entriesSelect.addEventListener('change', function () {
            currentPage = 1;
            renderTable();
        });

        renderTable();
    });
</script>
@endsection