<?php

namespace App\Http\Controllers;

use CountryState;

class AjaxController extends Controller
{
    public function citiesByCountry()
    {
       $country = request()->country;
       $cities = CountryState::getStates($country);
       return response()->json($cities);
    }
}
