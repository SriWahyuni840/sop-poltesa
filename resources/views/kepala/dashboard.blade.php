@extends('layouts.kepala')

@section('content')
    <h4>Dashboard Kepala Pusat</h4>
    <p>Selamat datang di dashboard Kepala Pusat Penjamin Mutu.</p>

    <div class="mt-3">
        <a href="{{ route('kepala.review') }}" class="btn btn-primary">Review SOP</a>
    </div>
@endsection