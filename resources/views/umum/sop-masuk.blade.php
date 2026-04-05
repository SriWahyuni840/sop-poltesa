@extends('layouts.umum')

@section('content')
@php
    $sopPerluKirim = $sops->where('status', 'dikirim_ke_umum');
    $sopSudahKeDirektur = $sops->where('status', 'dikirim_ke_direktur');
    $sopSudahDitandatangani = $sops->where('status', 'ditandatangani');
@endphp

<div class="container-fluid py-4 px-4 text-white">
    <div class="mb-4">
        <h4 class="fw-bold mb-1">SOP Masuk - Bagian Umum</h4>
        <p class="mb-0 text-light">
            Daftar SOP dari Admin P2MPP yang siap diteruskan ke Direktur atau sudah kembali final.
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="#perlu-kirim" class="btn btn-sm btn-info text-white fw-semibold">Perlu Kirim ke Direktur</a>
        <a href="#sudah-direktur" class="btn btn-sm btn-warning text-dark fw-semibold">Sudah ke Direktur</a>
        <a href="#sudah-ttd" class="btn btn-sm btn-success fw-semibold">Ditandatangani Direktur</a>
    </div>

    {{-- TABEL 1 --}}
    <div id="perlu-kirim" class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-info text-white fw-bold">
            SOP yang Perlu Dikirim ke Direktur
        </div>
        <div class="card-body bg-white text-dark">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Unit</th>
                            <th>Jenis SOP</th>
                            <th>Tahun</th>
                            <th>Nama SOP</th>
                            <th>Nomor SOP</th>
                            <th>Dokumen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sopPerluKirim->values() as $index => $sop)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $sop->kode_unit }}</td>
                                <td>{{ $sop->kode_jenis }} - {{ $sop->nama_jenis }}</td>
                                <td>{{ $sop->tahun_berlaku }}</td>
                                <td>{{ $sop->nama_sop }}</td>
                                <td>{{ $sop->nomor_sop ?? '-' }}</td>
                                <td>
                                    @if($sop->file_bernomor)
                                        <span class="badge bg-warning text-dark mb-1">Bernomor</span><br>
                                        <a href="{{ route('umum.download', $sop->id) }}" class="btn btn-sm btn-info text-white">
                                            Download Bernomor
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('umum.kirim.direktur', $sop->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-dark">
                                            Kirim ke Direktur
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Belum ada SOP yang perlu dikirim ke Direktur.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- TABEL 2 --}}
    <div id="sudah-direktur" class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-warning text-dark fw-bold">
            SOP yang Sudah Dikirim ke Direktur
        </div>
        <div class="card-body bg-white text-dark">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Unit</th>
                            <th>Jenis SOP</th>
                            <th>Tahun</th>
                            <th>Nama SOP</th>
                            <th>Nomor SOP</th>
                            <th>Dokumen</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sopSudahKeDirektur->values() as $index => $sop)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $sop->kode_unit }}</td>
                                <td>{{ $sop->kode_jenis }} - {{ $sop->nama_jenis }}</td>
                                <td>{{ $sop->tahun_berlaku }}</td>
                                <td>{{ $sop->nama_sop }}</td>
                                <td>{{ $sop->nomor_sop ?? '-' }}</td>
                                <td>
                                    @if($sop->file_bernomor)
                                        <span class="badge bg-warning text-dark mb-1">Bernomor</span><br>
                                        <a href="{{ route('umum.download', $sop->id) }}" class="btn btn-sm btn-info text-white">
                                            Download Bernomor
                                        </a>
                                    @elseif($sop->file_final)
                                        <span class="badge bg-success mb-1">Final + QR</span><br>
                                        <a href="{{ route('umum.download', $sop->id) }}" class="btn btn-sm btn-success">
                                            Download Final
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-dark">Menunggu Direktur</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Belum ada SOP yang sudah dikirim ke Direktur.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- TABEL 3 --}}
    <div id="sudah-ttd" class="card border-0 shadow-sm">
        <div class="card-header bg-success text-white fw-bold">
            SOP yang Sudah Ditandatangani Direktur
        </div>
        <div class="card-body bg-white text-dark">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Unit</th>
                            <th>Jenis SOP</th>
                            <th>Tahun</th>
                            <th>Nama SOP</th>
                            <th>Nomor SOP</th>
                            <th>Dokumen Final</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sopSudahDitandatangani->values() as $index => $sop)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $sop->kode_unit }}</td>
                                <td>{{ $sop->kode_jenis }} - {{ $sop->nama_jenis }}</td>
                                <td>{{ $sop->tahun_berlaku }}</td>
                                <td>{{ $sop->nama_sop }}</td>
                                <td>{{ $sop->nomor_sop ?? '-' }}</td>
                                <td>
                                    @if($sop->file_final)
                                        <span class="badge bg-success mb-1">Final + QR</span><br>
                                        <a href="{{ route('umum.download', $sop->id) }}" class="btn btn-sm btn-success">
                                            Download Final
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-success">Sudah Ditandatangani</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Belum ada SOP yang sudah ditandatangani Direktur.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection