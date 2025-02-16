<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rinvex\Country\CountryLoader;
use Illuminate\Http\JsonResponse;

class LanguageController extends Controller
{
    public function getCountries(): JsonResponse
    {
        $countries = CountryLoader::countries(); // Get all countries
    
        return response()->json($countries);
    }
}
