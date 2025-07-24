@extends('layouts.master')

@section('content')
    <div>
        <h1>Ödeme Bilgileri</h1>
        <p>{{ $esim_data['title'] }}</p>
        <p>{{ $esim_data['fiyat'] }}</p>
    </div>

    <form action="{{ route('sale.confirmSale') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $esim_data['id'] }}">
        <input type="text" name="kartCvv" value="{{ old('kartCvv') }}">
        <input type="text" name="kartNo" value="{{ old('kartNo') }}">
        <input type="date" name="kartSonKullanmaTarihi" value="{{ old('kartSonKullanmaTarihi') }}">
        <input type="text" name="kartSahibi" value="{{ old('kartSahibi') }}">
        <input type="text" name="taksitSayisi" value="{{ old('taksitSayisi') }}">
        <button>Öde</button>
    </form>
@endsection
