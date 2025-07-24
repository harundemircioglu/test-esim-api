<?php

namespace App\Http\Controllers;

use App\Services\CountryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function index(Request $request)
    {
        if (Cache::has('esim_data')) {
            Cache::forget('esim_data');
        }

        if (Cache::has('sold_data')) {
            Cache::forget('sold_data');
        }

        $filterData = [
            'dataAmount' => $request->query('dataAmount'),
            'validityPeriod' => $request->query('validityPeriod'),
            'countryCode' => $request->query('countryCode', 'eur'),
        ];

        $countries = $this->countryService->getCountries();
        $coverages = $this->countryService->getCountryCoverages($filterData);

        return view('index', [
            'countries' => $countries,
            'coverages' => $coverages,
        ]);
    }
}
