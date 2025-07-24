@extends('layouts.master')

@section('content')
    <a href="{{ route('home') }}">Anasayfa</a>
    <a href="{{ $sold_data['parameters']['data']['0']['esimDetail']['0']['qr_code'] }}" target="_blank">QR Kod</a>
@endsection
