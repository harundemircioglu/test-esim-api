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
            'kartCvv' => 'required',
            'kartNo' => 'required',
            'kartSonKullanmaTarihi' => 'required',
            'kartSahibi' => 'required',
            'taksitSayisi' => 'required',
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
                        'success' => $response['message'] ?? 'eSIM purchase confirmed successfully.',
                    ]);
                }
            } else {
                return redirect()->back()->with([
                    'error' => $response['message'] ?? 'Failed to confirm eSIM purchase.',
                ]);
            }
        } catch (\Throwable $th) {
            Log::error('Error confirming eSIM purchase: ' . $th->getMessage());
            return redirect()->back()->with('error', 'An error occurred while confirming the eSIM purchase.');
        }
    }
}
