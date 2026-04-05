@extends('layouts.kepala')

@section('content')
    <h4>Detail Review SOP</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="25%">Kode Unit</th>
                    <td>{{ $sop->kode_unit }}</td>
                </tr>
                <tr>
                    <th>Nama Unit</th>
                    <td>{{ $sop->nama_unit }}</td>
                </tr>
                <tr>
                    <th>Jenis SOP</th>
                    <td>{{ $sop->kode_jenis }} - {{ $sop->nama_jenis }}</td>
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
                <tr>
                    <th>Nomor SOP</th>
                    <td>{{ $sop->nomor_sop ?? '-' }}</td>
                </tr>
                <tr>
<tr>
    <th>File Draft</th>
    <td>
        @if($sop->file_draft)
            <a href="{{ route('kepala.review.lihatDraft', $sop->id) }}" target="_blank">Lihat File Draft</a>
        @else
            -
        @endif
    </td>
</tr>
<tr>
    <th>File Surat Permohonan</th>
    <td>
        @if($sop->file_surat_permohonan)
            <a href="{{ route('kepala.review.lihatSurat', $sop->id) }}" target="_blank">Lihat Surat</a>
        @else
            -
        @endif
    </td>
</tr>
                <tr>
                    <th>Status</th>
                    <td><span class="badge bg-warning text-dark">{{ $sop->status }}</span></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="d-flex gap-2 mb-4">
        <form action="{{ route('kepala.review.setujui', $sop->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Setujui SOP</button>
        </form>
    </div>

    <div class="card">
        <div class="card-body">
            <h5>Kembalikan SOP</h5>
            <form action="{{ route('kepala.review.kembalikan', $sop->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Catatan Review</label>
                    <textarea name="isi_catatan" class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-warning">Kembalikan SOP</button>
            </form>
        </div>
    </div>

    @if($catatans->count())
        <div class="card mt-4">
            <div class="card-body">
                <h5>Riwayat Catatan</h5>
                <ul class="list-group">
                    @foreach($catatans as $catatan)
                        <li class="list-group-item">
                            <strong>{{ $catatan->name }}</strong><br>
                            {{ $catatan->isi_catatan }}<br>
                            <small class="text-muted">{{ $catatan->created_at }}</small>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
@endsection