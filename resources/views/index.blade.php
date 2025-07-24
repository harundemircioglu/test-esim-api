@extends('layouts.master')

@section('content')
    <div>
        <div>
            <select name="countryCode" id="countryCode">
                @foreach ($countries as $country)
                    <option @if (request()->query('countryCode', 'eur') == $country['ulkeKodu']) selected @endif value="{{ $country['ulkeKodu'] }}">
                        {{ $country['ulkeAd'] }}</option>
                @endforeach
            </select>
        </div>
        <div>
            @php
                $dataAmounts = [
                    '' => 'Tüm Paketler',
                    1 => '1 GB',
                    2 => '2 GB',
                    5 => '5 GB',
                    10 => '10 GB',
                    20 => '20 GB',
                    50 => '50 GB',
                ];
            @endphp
            <select name="dataAmount" id="dataAmount">
                @foreach ($dataAmounts as $value => $amount)
                    <option @if (request()->query('dataAmount') == $value) selected @endif value="{{ $value }}">{{ $amount }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            @php
                $validityPeriods = [
                    '' => 'Tüm Paketler',
                    7 => '7 Gün',
                    15 => '15 Gün',
                    30 => '30 Gün',
                ];
            @endphp
            <select name="validityPeriod" id="validityPeriod">
                @foreach ($validityPeriods as $value => $period)
                    <option @if (request()->query('validityPeriod') == $value) selected @endif value="{{ $value }}">{{ $period }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div>
        @foreach ($coverages as $coverage)
            <div>
                <form action="{{ route('createESim') }}" method="POST">
                    @csrf
                    <h3>{{ $coverage['coverage'] }}</h3>
                    <p>{{ $coverage['data_amount'] }} GB</p>
                    <p>{{ $coverage['validity_period'] }} Gün</p>
                    <p>{{ $coverage['amount'] }} {{ $coverage['currency'] }}</p>
                    <input type="text" name="gsm_no" placeholder="GSM No" value="{{ old('gsm_no') }}">
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                    <button type="submit" name="api_id" value="{{ $coverage['api_id'] }}">Sepete Ekle</button>
                </form>
            </div>
        @endforeach
    </div>
@endsection

@push('scripts')
    <script>
        let countryCode = $('#countryCode');
        let dataAmount = $('#dataAmount');
        let validityPeriod = $('#validityPeriod');

        countryCode.on('change', function() {
            window.location.href = "?countryCode=" + $(this).val() + "&dataAmount=" + dataAmount.val() +
                "&validityPeriod=" + validityPeriod.val();
        })

        dataAmount.on('change', function() {
            window.location.href = "?countryCode=" + countryCode.val() + "&dataAmount=" + $(this).val() +
                "&validityPeriod=" + validityPeriod.val();
        });

        validityPeriod.on('change', function() {
            window.location.href = "?countryCode=" + countryCode.val() + "&dataAmount=" + dataAmount.val() +
                "&validityPeriod=" + $(this).val();
        });
    </script>
@endpush
