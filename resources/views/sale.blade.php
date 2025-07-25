@extends('layouts.master')

@section('content')
    <div class="my-6">
        <h1 class="font-bold text-xl">PAKET BİLGİLERİ</h1>
        <p>{{ $esim_data['title'] }}</p>
        <p>{{ $esim_data['fiyat'] }}</p>
    </div>

    <form action="{{ route('sale.confirmSale') }}" method="POST" class="bg-gray-100 p-6 rounded-lg shadow-md">
        @csrf
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="kartNo" class="block mb-2 text-sm font-medium text-gray-900">Kart Numarası</label>

                <input type="text" id="kartNo" name="kartNo"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Kart Numarası" maxlength="16" pattern="\d{16}" inputmode="numeric"
                    value="{{ old('kartNo') }}" required />

                @error('kartNo')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}
                    </div>
                @enderror
            </div>
            <div>
                <label for="kartSahibi" class="block mb-2 text-sm font-medium text-gray-900">Kart Sahibi</label>

                <input type="text" id="kartSahibi" name="kartSahibi"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Kart Sahibi" value="{{ old('kartSahibi') }}" required />

                @error('kartSahibi')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}
                    </div>
                @enderror
            </div>
            <div>
                <label for="kartCvv" class="block mb-2 text-sm font-medium text-gray-900">CVV</label>

                <input type="text" id="kartCvv" name="kartCvv"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="CVV" maxlength="3" pattern="\d{3}" inputmode="numeric" value="{{ old('kartCvv') }}"
                    required />

                @error('kartCvv')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}
                    </div>
                @enderror
            </div>
            <div>
                <label for="kartSonKullanmaTarihi" class="block mb-2 text-sm font-medium text-gray-900">Geçerlilik
                    Tarihi</label>

                <input type="date" id="kartSonKullanmaTarihi" name="kartSonKullanmaTarihi"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Geçerlilik Tarihi" value="{{ old('kartSonKullanmaTarihi') }}" required />

                @error('kartSonKullanmaTarihi')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}
                    </div>
                @enderror
            </div>
            <div>
                <label for="taksitSayisi" class="block mb-2 text-sm font-medium text-gray-900">Taksit Sayısı</label>

                <input type="number" id="taksitSayisi" name="taksitSayisi"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Taksit Sayısı" min="1" max="12" value="{{ old('taksitSayisi') }}" required />

                @error('taksitSayisi')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <button type="submit" name="id" value="{{ $esim_data['id'] }}"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Öde</button>
    </form>
@endsection
