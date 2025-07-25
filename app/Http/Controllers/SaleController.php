<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SaleController extends Controller
{
    public function index(array $esim_data = [])
    {
        return view('sale', [
            'esim_data' => Cache::get('esim_data', $esim_data),
        ]);
    }

    public function confirm(array $sold_data = [])
    {
        return view('confirm', [
            'sold_data' => Cache::get('sold_data', $sold_data),
        ]);
    }

    public function confirmSale(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'kartCvv' => ['required', 'digits:3'],
            'kartNo' => ['required', 'digits:16'],
            'kartSonKullanmaTarihi' => ['required', 'date', 'after:today'],
            'kartSahibi' => 'required',
            'taksitSayisi' => ['required', 'integer', 'min:1', 'max:12'],
        ], [
            'kartCvv.required' => 'Kart CVV kodu zorunludur.',
            'kartCvv.digits' => 'Kart CVV kodu 3 rakamdan oluşmalıdır.',

            'kartNo.required' => 'Kart numarası zorunludur.',
            'kartNo.digits' => 'Kart numarası 16 rakamdan oluşmalıdır.',

            'kartSonKullanmaTarihi.required' => 'Kart son kullanma tarihi zorunludur.',
            'kartSonKullanmaTarihi.date' => 'Geçerli bir tarih giriniz.',
            'kartSonKullanmaTarihi.after' => 'Kart son kullanma tarihi bugünden sonraki bir tarih olmalıdır.',

            'kartSahibi.required' => 'Kart sahibi adı zorunludur.',

            'taksitSayisi.required' => 'Taksit sayısı zorunludur.',
            'taksitSayisi.integer' => 'Taksit sayısı bir sayı olmalıdır.',
            'taksitSayisi.min' => 'Taksit sayısı en az 1 olmalıdır.',
            'taksitSayisi.max' => 'Taksit sayısı en fazla 12 olabilir.',
        ]);

        $baseUrl = config('app.base_url');
        $token = config('app.token');

        try {
            $response = Http::withHeader('token', $token)->post("{$baseUrl}/partner/v1/esim/confirm", [
                'id' => $request->input('id'),
                'kartCvv' => $request->input('kartCvv'),
                'kartNo' => $request->input('kartNo'),
                'kartSonKullanmaTarihi' => $request->input('kartSonKullanmaTarihi'),
                'kartSahibi' => $request->input('kartSahibi'),
                'taksitSayisi' => $request->input('taksitSayisi'),
            ]);

            if ($response->successful() && isset($response['status']) && $response['status'] == true) {
                if (isset($response['sold_esim'])) {
                    Cache::put('sold_data', $response['sold_esim'], 3600);

                    return redirect()->route('sale.confirm')->with([
                        'success' => $response['message'] ?? 'Ödeme işlemi başarılı.',
                    ]);
                }
            } else {
                return redirect()->back()->with([
                    'error' => $response['message'] ?? 'Ödeme işlemi başarısız.',
                ]);
            }
        } catch (\Throwable $th) {
            Log::error('Error confirming eSIM purchase: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Beklenmeyen bir hata ile karşılaşıldı.');
        }
    }
}
