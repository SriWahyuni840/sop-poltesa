@extends('layouts.direktur')

@section('content')
    <h4>Persetujuan SOP Direktur</h4>
    <p>Daftar SOP yang masuk ke Direktur untuk disahkan atau yang sudah final.</p>

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

    <div class="table-responsive mt-3">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Kode Unit</th>
                    <th>Jenis SOP</th>
                    <th>Nama SOP</th>
                    <th>Nomor SOP</th>
                    <th>Status</th>
                    <th>Dokumen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sops as $index => $sop)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $sop->kode_unit }}</td>
                        <td>{{ $sop->kode_jenis }} - {{ $sop->nama_jenis }}</td>
                        <td>{{ $sop->nama_sop }}</td>
                        <td>{{ $sop->nomor_sop ?? '-' }}</td>

                        <td>
                            @if($sop->status == 'dikirim_ke_direktur')
                                <span class="badge bg-dark">Siap Disahkan</span>
                            @elseif($sop->status == 'ditandatangani')
                                <span class="badge bg-success">Sudah Ditandatangani</span>
                            @else
                                <span class="badge bg-light text-dark">{{ $sop->status }}</span>
                            @endif
                        </td>

                        <td>
                            @if($sop->file_final)
                                <span class="badge bg-success mb-1">Final + QR</span><br>
                                <a href="{{ route('direktur.download', $sop->id) }}" class="btn btn-sm btn-success">
                                    Download Final
                                </a>
                            @elseif($sop->file_bernomor)
                                <span class="badge bg-warning text-dark mb-1">Bernomor</span><br>
                                <a href="{{ route('direktur.download', $sop->id) }}" class="btn btn-sm btn-info">
                                    Download Bernomor
                                </a>
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if($sop->status == 'dikirim_ke_direktur')
                                <a href="{{ route('direktur.sop.detail', $sop->id) }}" class="btn btn-sm btn-primary">
                                    Detail / Sahkan
                                </a>
                            @elseif($sop->status == 'ditandatangani')
                                <span class="text-success">Sudah Final</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada SOP untuk Direktur</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection