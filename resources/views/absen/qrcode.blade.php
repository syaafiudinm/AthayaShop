@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 text-center">
    <h2 class="text-2xl font-bold mb-4">QR Code Absensi Kamu</h2>
    <div class="inline-block border p-4 bg-white">
        {!! $qrCodeSvg !!}
    </div>
    <p class="mt-4">Scan QR Code ini saat absen. Kamu juga bisa cetak dan simpan kartu ID dengan QR Code ini.</p>
</div>
@endsection
