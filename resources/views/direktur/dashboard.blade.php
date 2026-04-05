@extends('layouts.admin')

@section('content')
    <h4>Dashboard Direktur</h4>
    <p>Silakan sahkan SOP yang sudah dikirim.</p>

    <div class="mt-3">
        <div class="alert alert-info">
            Jumlah SOP menunggu persetujuan: <strong>{{ $jumlahSop }}</strong>
        </div>

        <a href="{{ route('direktur.sop') }}" class="btn btn-primary">
            Lihat SOP untuk Disahkan
        </a>
    </div>
@endsection