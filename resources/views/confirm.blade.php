@extends('layouts.master')

@section('content')
    <div class="flex flex-col gap-2">
        <a href="{{ route('home') }}">Anasayfa</a>

        <a href="{{ $sold_data['parameters']['data']['0']['esimDetail']['0']['qr_code'] }}" target="_blank">
            <i class="fa-solid fa-qrcode"></i>
            QR Kod</a>
    </div>
@endsection
