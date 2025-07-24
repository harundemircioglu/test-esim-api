<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class EsimController extends Controller
{
    public function createESim(Request $request)
    {
        $request->validate([
            'api_id' => 'required',
            'gsm_no' => 'required',
            'email' => 'required',
        ]);

        $baseUrl = config('app.base_url');
        $token = config('app.token');

        $response = Http::withHeader('token', $token)->post("{$baseUrl}/partner/v1/esim/create", [
            'api_id' => $request->input('api_id'),
            'gsm_no' => $request->input('gsm_no'),
            'email' => $request->input('email'),
        ]);

        if ($response->successful() && isset($response['status']) && $response['status'] == true) {
            if (isset($response['sold_esim'])) {
                Cache::put('esim_data', $response['sold_esim'], 3600);

                return redirect()->route('sale.index')->with([
                    'success' => 'ESim successfully created and added to cart.',
                ]);
            }
        }
    }
}
