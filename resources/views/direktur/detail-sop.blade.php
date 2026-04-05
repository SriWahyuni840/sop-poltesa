@extends('layouts.direktur')

@section('content')
    <h4>Detail Persetujuan SOP</h4>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
            <th>Nomor SOP</th>
            <td>{{ $sop->nomor_sop ?? '-' }}</td>
        </tr>
        <tr>
            <th>Dokumen</th>
            <td>
                @if($sop->file_bernomor || $sop->file_final)
                    <a href="{{ route('direktur.download', $sop->id) }}" target="_blank" class="btn btn-sm btn-success">
                        Lihat / Download Dokumen
                    </a>
                @else
                    -
                @endif
            </td>
        </tr>
    </table>

    <hr>

    @if($sop->status == 'dikirim_ke_direktur')
        <h5>Pengesahan Direktur</h5>
        <form action="{{ route('direktur.sop.sahkan', $sop->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Masukkan PIN Direktur</label>
                <input type="password" name="pin" class="form-control" required>
                <small class="text-muted">PIN sementara untuk demo: <strong>123456</strong></small>
            </div>

            <button type="submit" class="btn btn-success">
                Sahkan SOP
            </button>
        </form>
    @elseif($sop->status == 'ditandatangani')
        <div class="alert alert-success">
            SOP ini sudah disahkan oleh Direktur.
        </div>
    @endif
@endsection