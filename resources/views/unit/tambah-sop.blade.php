@extends('layouts.unit')

@section('content')
<style>
    .sop-form-page {
        background: #2d3272;
        min-height: calc(100vh - 72px);
        padding: 14px 18px 28px;
        color: #fff;
    }

    .sop-form-wrap {
        width: 100%;
        margin: 0 auto;
    }

    .sop-form-breadcrumb {
        font-size: 12px;
        font-weight: 700;
        color: rgba(255,255,255,0.92);
        margin-bottom: 12px;
    }

    .sop-form-panel {
        background: #252b63;
        border: 1px solid rgba(255,255,255,0.05);
        padding: 22px 26px 24px;
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.02);
    }

    .sop-form-title {
        font-size: 18px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 4px;
    }

    .sop-form-subtitle {
        font-size: 12px;
        color: rgba(255,255,255,0.65);
        margin-bottom: 18px;
        line-height: 1.6;
    }

    .form-label-navy {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 6px;
    }

    .form-control-navy,
    .form-select-navy,
    .form-textarea-navy {
        width: 100%;
        min-height: 40px;
        background: #f3f4f6;
        border: 1px solid rgba(255,255,255,0.14);
        color: #1f2937;
        border-radius: 3px;
        padding: 8px 10px;
        font-size: 12px;
        outline: none;
        box-shadow: none;
    }

    .form-textarea-navy {
        min-height: 72px;
        resize: vertical;
    }

    .form-control-navy:focus,
    .form-select-navy:focus,
    .form-textarea-navy:focus {
        border-color: #60a5fa;
        box-shadow: 0 0 0 3px rgba(96,165,250,0.10);
    }

    .form-control-navy[readonly] {
        background: #eef2f7;
        color: #475569;
    }

    .hint-navy {
        font-size: 11px;
        color: rgba(255,255,255,0.58);
        margin-top: 5px;
        line-height: 1.5;
    }

    .block-space {
        margin-top: 18px;
    }

    .table-mini-dark {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 8px;
    }

    .table-mini-dark thead th {
        font-size: 12px;
        font-weight: 700;
        color: #ffffff;
        text-align: left;
        padding: 10px 8px;
        border-top: 1px solid rgba(255,255,255,0.16);
        border-bottom: 1px solid rgba(255,255,255,0.16);
    }

    .table-mini-dark tbody td {
        font-size: 12px;
        color: #ffffff;
        padding: 10px 8px;
        border-bottom: 1px solid rgba(255,255,255,0.10);
        vertical-align: middle;
    }

    .empty-mini {
        color: rgba(255,255,255,0.65);
        text-align: center;
    }

    .file-input-dark {
        width: 100%;
        background: #1d234e;
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 4px;
        color: #ffffff;
        font-size: 12px;
        padding: 6px 8px;
    }

    .file-input-dark::file-selector-button {
        background: #f3f4f6;
        color: #111827;
        border: none;
        border-radius: 3px;
        padding: 7px 10px;
        margin-right: 10px;
        cursor: pointer;
        font-size: 12px;
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

    .btn-ui {
        border: none;
        border-radius: 6px;
        padding: 9px 14px;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
        color: #fff;
    }

    .btn-ui:hover {
        color: #fff;
        filter: brightness(0.95);
    }

    .btn-back-ui {
        background: #6b7280;
    }

    .btn-draft-ui {
        background: #2563eb;
    }

    .btn-submit-ui {
        background: #16a34a;
    }

    .alert-ui {
        border: 0;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 14px;
    }

    .error-list {
        margin: 0;
        padding-left: 18px;
    }

    .error-list li {
        margin-bottom: 4px;
    }

    @media (max-width: 992px) {
        .sop-form-panel {
            padding: 18px;
        }
    }
</style>

<div class="container-fluid sop-form-page">
    <div class="sop-form-wrap">
        <div class="sop-form-breadcrumb">
            SOP Saya - Tambah SOP
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-ui">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-ui">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-ui">
                <div class="fw-bold mb-2">
                    <i class="bi bi-exclamation-octagon-fill me-2"></i>Periksa kembali data yang diinput:
                </div>
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="sop-form-panel">
            <div class="sop-form-title">Form Tambah SOP</div>
            <div class="sop-form-subtitle">
                Lengkapi data dan dokumen SOP baru sebelum disimpan sebagai draft atau diajukan.
            </div>

            <form action="{{ route('unit.simpan') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label-navy">Jenis SOP</label>
                        <select name="jenis_sop_id" class="form-select-navy" required>
                            <option value="">-- Pilih --</option>
                            @foreach ($jenis as $j)
                                <option value="{{ $j->id }}" {{ old('jenis_sop_id') == $j->id ? 'selected' : '' }}>
                                    {{ $j->kode_jenis }} - {{ $j->nama_jenis }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label-navy">Tahun Berlaku</label>
                        <input type="number" name="tahun_berlaku" class="form-control-navy"
                               value="{{ old('tahun_berlaku') }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label-navy">Nama SOP</label>
                        <textarea name="nama_sop" class="form-textarea-navy" required>{{ old('nama_sop') }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label-navy">Tanggal Pembuatan</label>
                        <input type="date" class="form-control-navy" value="{{ now()->toDateString() }}" readonly>
                        <div class="hint-navy">Otomatis diisi oleh sistem saat SOP disimpan.</div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label-navy">Tanggal Revisi</label>
                        <input type="text" class="form-control-navy" value="Otomatis saat revisi" readonly>
                        <div class="hint-navy">Akan otomatis diisi sistem saat SOP direvisi.</div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label-navy">Tanggal Efektif</label>
                        <input type="text" class="form-control-navy" value="Otomatis saat disahkan direktur" readonly>
                        <div class="hint-navy">Tidak diisi oleh unit.</div>
                    </div>
                </div>

                <div class="row g-4 block-space">
                    <div class="col-md-6">
                        <table class="table-mini-dark">
                            <thead>
                                <tr>
                                    <th>Dokumen SOP</th>
                                    <th style="width:120px;">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>File Draft SOP</td>
                                    <td class="empty-mini">Upload baru</td>
                                </tr>
                            </tbody>
                        </table>

                        <label class="form-label-navy">Masukkan Dokumen SOP</label>
                        <input type="file" name="file_draft" class="file-input-dark" required>
                        <div class="hint-navy">Unggah file draft SOP sesuai format yang ditentukan oleh sistem.</div>
                    </div>

                    <div class="col-md-6">
                        <table class="table-mini-dark">
                            <thead>
                                <tr>
                                    <th>Surat Permohonan</th>
                                    <th style="width:120px;">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>File Surat Permohonan</td>
                                    <td class="empty-mini">Upload baru</td>
                                </tr>
                            </tbody>
                        </table>

                        <label class="form-label-navy">Masukkan Surat Pendukung</label>
                        <input type="file" name="file_surat_permohonan" class="file-input-dark" required>
                        <div class="hint-navy">Unggah surat permohonan sebagai dokumen pendukung pengajuan SOP.</div>
                    </div>
                </div>

                <div class="btn-row">
                    <div class="btn-left">
                        <a href="{{ route('unit.sop') }}" class="btn-ui btn-back-ui">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <div class="btn-right">
                        <button type="submit" name="aksi" value="draft" class="btn-ui btn-draft-ui">
                            <i class="bi bi-save2"></i> Simpan Draft
                        </button>

                        <button type="submit" name="aksi" value="ajukan" class="btn-ui btn-submit-ui">
                            <i class="bi bi-send-check"></i> Ajukan SOP
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection