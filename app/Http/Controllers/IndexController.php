<?php

namespace App\Http\Controllers;

use App\Location;
use App\Temperature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use CountryState;

class IndexController extends Controller
{

    private $weatherServices;

    public function __construct()
    {
        $this->weatherServices = app('MergeWeatherService');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = CountryState::getCountries();

        return view('index', [
            'countries' => $countries
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $locationId = '';
        $location = $request->city.', '.$request->country;

        $this->validateRequest($request);

        // Check for cache
        if(Cache::has($location)){
            $temperature = Cache::get($location);
        }
        else {
            $temperatures = $this->weatherServices->getWeatherResults($location);
            $temperature = $this->getAverageTemperature($temperatures);

            $locationModel = Location::where([
                'country' => $request->country,
                'city' => $request->city
            ])->first();

            $temperatureModel = new Temperature([
                'temperature' => $temperature
            ]);

            if ($locationModel) {
                $locationId = $locationModel->id;
            }
            else{
                // Map location id to temperature
                $temperatureLocation = $temperatureModel->locations()->create([
                    'country' => $request->country,
                    'city' => $request->city
                ]);
                $locationId = $temperatureLocation->id;
            }

            $temperatureModel->location_id = $locationId;
            $temperatureModel->save();

            // BUG: ???, as per doc last parameter is minutes, but seems to fail. Using it as seconds.
            Cache::put($location, $temperature, 60*5);
        }

        return redirect(route('showTemp'))->with([
            'location' => $location,
            'temperature' => $temperature
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            $location = session()->get('location');
            $temperature = session()->get('temperature');

            if(!$location || !$temperature){
                return redirect(route('index'));
            }

            [$city, $country] = explode(",", $location);

            $previousTemperatures = Temperature::whereHas('locations',
                function($query) use($city, $country) {
                    $query->where('city',$city)->orWhere('country', $country);

            })->get();

            return view('show', compact('location','temperature','previousTemperatures'));
        } catch (\Throwable $th) {
            return view('errors.generic',[
                'message' => 'Something went wrong when showing data'
            ]);
        }

    }

    /***
     * Loop all results and get average temperatures
     *
     * @param  array $temperatures
     * @return string
     */
    public function getAverageTemperature($temperatures = [])
    {
        if( !empty($temperatures) ){
            $average = array_sum($temperatures) / sizeof($temperatures);

            return number_format($average, 2);
        }

        return [];
    }

    private function validateRequest($request)
    {
        return $request->validate([
            'country' => 'required',
            'city' => 'required'
        ]);
    }

}
