<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CountryService
{
    public function getCountries()
    {
        $baseUrl = config('app.base_url');
        $token = config('app.token');

        $response = Http::withHeader('token', $token)->get("{$baseUrl}/partner/v1/esim/countries");

        if ($response->successful() && isset($response['status']) && $response['status'] == true) {
            $data = collect($response['data']);

            return $data->values();
        }
    }

    public function getCountryCoverages(Request $request, string $countryCode)
    {
        $baseUrl = config('app.base_url');
        $token = config('app.token');

        $dataAmount = $request->query('dataAmount');
        $validityPeriod = $request->query('validityPeriod');

        $response = Http::withHeader('token', $token)->get("{$baseUrl}/partner/v1/esim/coverages/{$countryCode}");

        if ($response->successful() && isset($response['status']) && $response['status'] == true) {

            $data = collect($response['coverages']);

            if ($dataAmount !== null) {
                $data = $data->where('data_amount', $dataAmount);
            }

            if ($validityPeriod !== null) {
                $data = $data->where('validity_period', $validityPeriod);
            }

            return $data->values();
        }
    }
}
