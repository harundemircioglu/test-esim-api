@extends('layouts.master')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div>
            <label for="countryCode" class="block mb-2 text-sm font-medium text-gray-900">Ülkeler</label>

            <select id="countryCode" name="countryCode"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
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

            <label for="dataAmount" class="block mb-2 text-sm font-medium text-gray-900">İnternet Kotası</label>

            <select id="dataAmount" name="dataAmount"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                @foreach ($dataAmounts as $value => $amount)
                    <option @if (request()->query('dataAmount') == $value) selected @endif value="{{ $value }}">
                        {{ $amount }}
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

            <label for="validityPeriod" class="block mb-2 text-sm font-medium text-gray-900">Gün Sayısı</label>

            <select id="validityPeriod" name="validityPeriod"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                @foreach ($validityPeriods as $value => $period)
                    <option @if (request()->query('validityPeriod') == $value) selected @endif value="{{ $value }}">
                        {{ $period }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-8">
        <div class="flow-root">
            <ul role="list" class="divide-y divide-gray-200">
                @foreach ($coverages as $coverage)
                    <li class="py-3 sm:py-4">
                        <div class="flex items-center">
                            <div class="shrink-0">
                                <i class="fa-solid fa-sim-card w-8 h-8 rounded-full"></i>
                            </div>
                            <div class="flex-1 min-w-0 ms-4">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $coverage['data_amount'] }} GB - {{ $coverage['validity_period'] }} GÜN
                                </p>
                                <p class="text-sm text-gray-500 truncate">
                                    {{ $coverage['coverage'] }}
                                </p>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900">
                                <form action="{{ route('createESim') }}" method="POST">
                                    @csrf
                                    <!-- Modal toggle -->
                                    <button data-modal-target="create-esim-coverage-{{ $coverage['id'] }}"
                                        data-modal-toggle="create-esim-coverage-{{ $coverage['id'] }}"
                                        class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                        type="button">
                                        {{ $coverage['amount'] }} {{ $coverage['currency'] }}
                                    </button>

                                    <!-- Main modal -->
                                    <div id="create-esim-coverage-{{ $coverage['id'] }}" tabindex="-1" aria-hidden="true"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative p-4 w-full max-w-md max-h-full">
                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded-lg shadow-sm p-4">
                                                <!-- Modal header -->
                                                <div
                                                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                                                    <h3 class="text-lg font-semibold text-gray-900">
                                                        {{ $coverage['data_amount'] }}
                                                        GB -
                                                        {{ $coverage['validity_period'] }} Gün
                                                    </h3>
                                                    <button type="button"
                                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                        data-modal-toggle="create-esim-coverage-{{ $coverage['id'] }}">
                                                        <svg class="w-3 h-3" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                </div>
                                                <!-- Modal body -->
                                                <form class="p-4 md:p-5">
                                                    <div class="grid gap-4 mb-4 grid-cols-2">
                                                        <div class="col-span-2">
                                                            <label for="gsm_no-{{ $coverage['id'] }}"
                                                                class="block mb-2 text-sm font-medium text-gray-900">GSM
                                                                No</label>

                                                            <input type="text" name="gsm_no"
                                                                id="gsm_no-{{ $coverage['id'] }}"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                                placeholder="GSM No" value="{{ old('gsm_no') }}"
                                                                required="">

                                                            @error('gsm_no')
                                                                <div class="text-red-600 text-sm mt-1">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-span-2">
                                                            <label for="email-{{ $coverage['id'] }}"
                                                                class="block mb-2 text-sm font-medium text-gray-900">Email</label>

                                                            <input type="email" name="email"
                                                                id="email-{{ $coverage['id'] }}"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                                placeholder="Email" value="{{ old('email') }}"
                                                                required="">

                                                            @error('email')
                                                                <div class="text-red-600 text-sm mt-1">{{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <button type="submit" name="api_id" value="{{ $coverage['api_id'] }}"
                                                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                        Sepete Ekle
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
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
