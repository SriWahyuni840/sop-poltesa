@extends('layouts.unit')

@section('content')
<style>
    .edit-sop-page {
        background: #31376f;
        min-height: calc(100vh - 72px);
        padding: 10px 14px 28px;
        color: #fff;
    }

    .edit-sop-wrap {
        width: 100%;
        margin: 0 auto;
    }

    .edit-sop-breadcrumb {
        font-size: 12px;
        font-weight: 700;
        color: rgba(255,255,255,0.95);
        margin-bottom: 10px;
        padding: 0 2px;
    }

    .edit-sop-panel {
        background: #262c66;
        border: 1px solid rgba(255,255,255,0.04);
        padding: 18px 18px 20px;
    }

    .form-label-dark {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 6px;
    }

    .form-control-dark,
    .form-select-dark,
    .form-textarea-dark {
        width: 100%;
        background: #f1f3f5;
        border: 1px solid rgba(255,255,255,0.10);
        color: #1f2937;
        border-radius: 3px;
        padding: 7px 10px;
        font-size: 12px;
        outline: none;
        box-shadow: none;
    }

    .form-control-dark,
    .form-select-dark {
        min-height: 36px;
    }

    .form-textarea-dark {
        min-height: 64px;
        resize: vertical;
    }

    .form-control-dark:focus,
    .form-select-dark:focus,
    .form-textarea-dark:focus {
        border-color: #60a5fa;
        box-shadow: 0 0 0 3px rgba(96,165,250,0.10);
    }

    .form-control-dark[readonly] {
        background: #e9edf2;
        color: #475569;
    }

    .hint-text {
        font-size: 10px;
        color: rgba(255,255,255,0.62);
        margin-top: 4px;
        line-height: 1.5;
    }

    .section-gap {
        margin-top: 18px;
    }

    .mini-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 8px;
    }

    .mini-table thead th {
        font-size: 11px;
        font-weight: 700;
        color: #ffffff;
        text-align: left;
        padding: 9px 8px;
        border-top: 1px solid rgba(255,255,255,0.14);
        border-bottom: 1px solid rgba(255,255,255,0.14);
    }

    .mini-table tbody td {
        font-size: 11px;
        color: #ffffff;
        padding: 9px 8px;
        border-bottom: 1px solid rgba(255,255,255,0.10);
        vertical-align: middle;
    }

    .empty-text {
        color: rgba(255,255,255,0.7);
        font-size: 11px;
    }

    .file-link {
        color: #ffffff;
        text-decoration: none;
        font-size: 11px;
        font-weight: 700;
    }

    .file-link:hover {
        color: #8ec5ff;
    }

    .file-input-wrap {
        margin-top: 6px;
    }

    .file-dark {
        width: 100%;
        background: #20254f;
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 4px;
        color: #ffffff;
        font-size: 11px;
        padding: 5px 8px;
    }

    .file-dark::file-selector-button {
        background: #f3f4f6;
        color: #111827;
        border: none;
        border-radius: 3px;
        padding: 6px 10px;
        margin-right: 10px;
        cursor: pointer;
        font-size: 11px;
    }

    .btn-row {
        margin-top: 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-left,
    .btn-right {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-custom {
        border: none;
        border-radius: 5px;
        padding: 8px 14px;
        font-size: 11px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        color: #fff;
        line-height: 1;
    }

    .btn-custom:hover {
        color: #fff;
        filter: brightness(0.95);
    }

    .btn-gray {
        background: #7b8494;
    }

    .btn-blue {
        background: #2d7ef7;
    }

    .btn-green {
        background: #16a34a;
    }

    .alert-custom {
        border: 0;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    @media (max-width: 992px) {
        .edit-sop-panel {
            padding: 16px;
        }
    }
</style>

<div class="container-fluid edit-sop-page">
    <div class="edit-sop-wrap">
        <div class="edit-sop-breadcrumb">
            SOP Saya - Edit / Revisi SOP
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-custom">
                <div class="fw-bold mb-2">Periksa kembali data yang diinput:</div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="edit-sop-panel">
            <form action="{{ route('unit.sop.update', $sop->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label-dark">Jenis SOP</label>
                        <select name="jenis_sop_id" class="form-select-dark" required>
                            @foreach ($jenis as $j)
                                <option value="{{ $j->id }}" {{ $sop->jenis_sop_id == $j->id ? 'selected' : '' }}>
                                    {{ $j->kode_jenis }} - {{ $j->nama_jenis }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label-dark">Tahun Berlaku</label>
                        <input type="number"
                               name="tahun_berlaku"
                               class="form-control-dark"
                               value="{{ old('tahun_berlaku', $sop->tahun_berlaku) }}"
                               required>
                    </div>

                    <div class="col-12">
                        <label class="form-label-dark">Nama SOP</label>
                        <textarea name="nama_sop" class="form-textarea-dark" required>{{ old('nama_sop', $sop->nama_sop) }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label-dark">Tanggal Pembuatan</label>
                        <input type="text"
                               class="form-control-dark"
                               value="{{ \Carbon\Carbon::parse($sop->tanggal_pembuatan)->format('d/m/Y') }}"
                               readonly>
                        <div class="hint-text">Otomatis diisi oleh sistem saat SOP disimpan.</div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label-dark">Tanggal Revisi</label>
                        <input type="text"
                               class="form-control-dark"
                               value="{{ now()->format('d/m/Y') }}"
                               readonly>
                        <div class="hint-text">Akan otomatis diisi sistem saat SOP direvisi.</div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label-dark">Tanggal Efektif</label>
                        <input type="text"
                               class="form-control-dark"
                               value="{{ $sop->tanggal_efektif ? \Carbon\Carbon::parse($sop->tanggal_efektif)->format('d/m/Y') : 'Otomatis saat disahkan direktur' }}"
                               readonly>
                        <div class="hint-text">Tidak diisi oleh unit.</div>
                    </div>
                </div>

                <div class="row g-4 section-gap">
                    <div class="col-md-6">
                        <table class="mini-table">
                            <thead>
                                <tr>
                                    <th>Dokumen SOP</th>
                                    <th style="width:120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>File Draft SOP saat ini</td>
                                    <td>
                                        @if(!empty($sop->file_draft))
                                            <a href="{{ route('unit.sop.lihatDraft', $sop->id) }}" target="_blank" class="file-link">
                                                Lihat File
                                            </a>
                                        @else
                                            <span class="empty-text">Tidak ada</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <label class="form-label-dark">Masukkan Dokumen SOP</label>
                        <div class="file-input-wrap">
                            <input type="file" name="file_draft" class="file-dark">
                        </div>
                        <div class="hint-text">Kosongkan jika file draft lama tidak ingin diganti.</div>
                    </div>

                    <div class="col-md-6">
                        <table class="mini-table">
                            <thead>
                                <tr>
                                    <th>Surat Permohonan</th>
                                    <th style="width:120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>File surat permohonan saat ini</td>
                                    <td>
                                        @if(!empty($sop->file_surat_permohonan))
                                            <a href="{{ route('unit.sop.lihatSurat', $sop->id) }}" target="_blank" class="file-link">
                                                Lihat File
                                            </a>
                                        @else
                                            <span class="empty-text">Tidak ada</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <label class="form-label-dark">Masukkan Surat Pendukung</label>
                        <div class="file-input-wrap">
                            <input type="file" name="file_surat_permohonan" class="file-dark">
                        </div>
                        <div class="hint-text">Kosongkan jika file surat lama tidak ingin diganti.</div>
                    </div>
                </div>

                <div class="btn-row">
                    <div class="btn-left">
                        <a href="{{ route('unit.sop') }}" class="btn-custom btn-gray">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <div class="btn-right">
                        <button type="submit" name="aksi" value="draft" class="btn-custom btn-blue">
                            <i class="bi bi-save2"></i> Simpan Draft
                        </button>

                        <button type="submit" name="aksi" value="ajukan" class="btn-custom btn-green">
                            <i class="bi bi-send-check"></i> Ajukan Ulang
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection