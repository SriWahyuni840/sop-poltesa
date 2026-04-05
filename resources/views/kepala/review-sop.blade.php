@extends('layouts.kepala')

@section('content')
    <h4>Review SOP</h4>
    <p>Daftar SOP yang sudah dibooking nomornya dan menunggu review Kepala Pusat.</p>

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
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Kode Unit</th>
                    <th>Kode Jenis</th>
                    <th>Tahun</th>
                    <th>Nama SOP</th>
                    <th>Nomor SOP</th>
                    <th>Status SOP</th>
                    <th>Status Nomor</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sops as $index => $sop)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $sop->kode_unit }}</td>
                        <td>{{ $sop->kode_jenis }}</td>
                        <td>{{ $sop->tahun_berlaku }}</td>
                        <td>{{ $sop->nama_sop }}</td>
                        <td>{{ $sop->nomor_sop ?? '-' }}</td>
                        <td>
                            <span class="badge bg-warning text-dark">Nomor Booking</span>
                        </td>
                        <td>
                            @if($sop->status_nomor == 'booking')
                                <span class="badge bg-warning text-dark">Booking</span>
                            @else
                                <span class="badge bg-secondary">{{ $sop->status_nomor ?? 'Belum Ada' }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('kepala.review.detail', $sop->id) }}" class="btn btn-sm btn-info">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Belum ada SOP yang menunggu review</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection