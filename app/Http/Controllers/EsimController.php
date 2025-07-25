<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EsimController extends Controller
{
    public function createESim(Request $request)
    {
        $request->validate([
            'api_id' => 'required',
            'gsm_no' => ['required', 'digits:10'],
            'email' => ['required', 'email'],
        ], [
            'gsm_no.required' => 'Cep telefonu numarası zorunludur.',
            'gsm_no.digits' => 'Cep telefonu numarası 10 rakamdan oluşmalıdır.',

            'email.required' => 'E-posta adresi zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
        ]);

        $baseUrl = config('app.base_url');
        $token = config('app.token');

        try {
            $response = Http::withHeader('token', $token)->post("{$baseUrl}/partner/v1/esim/create", [
                'api_id' => $request->input('api_id'),
                'gsm_no' => $request->input('gsm_no'),
                'email' => $request->input('email'),
            ]);

            if ($response->successful() && isset($response['status']) && $response['status'] == true) {
                if (isset($response['sold_esim'])) {
                    Cache::put('esim_data', $response['sold_esim'], 3600);

                    return redirect()->route('sale.index')->with([
                        'success' => $response['message'] ?? 'Sepete ekleme işlemi başarılı.',
                    ]);
                }
            } else {
                return redirect()->back()->with([
                    'error' => $response['message'] ?? 'Sepete ekleme işlemi başarısız.',
                ]);
            }
        } catch (\Throwable $th) {
            Log::error('Error creating eSIM: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Beklenmeyen bir hata ile karşılaşıldı.');
        }
    }
}
