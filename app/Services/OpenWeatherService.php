<?php
namespace App\Services;
use App\Interfaces\WeatherDataInterface;
use App\Traits\CallService;

class OpenWeatherService implements WeatherDataInterface {

    use CallService;

    protected $params = [];
    protected $location = [];
    protected $app_url;
    protected $app_key;
    protected $response;

    public function __construct()
    {
        $this->app_url = config('weather.openweather.url');
        $this->app_key = config('weather.openweather.id');
    }

     /***
     * Process/Initialized methods needed to construct result
     *
     * @param String $location
     * @return String
     */
    public function getWeather($location)
    {
        $this->location = $location;
        $this->buildParams();
        $this->response = $this->triggerAndConnect($this->app_url, $this->params);

        if ($this->response->status() === 200) {
            return $this->getResult();
        }
    }

    /***
     *
     * Build the required paramaters (as different API defers) needed for the endpoint
     */
    public function buildParams(){
        $this->params = [
            'appId' => $this->app_key,
            'q' => $this->location,
            'units' => 'metric'
        ];
    }

    /***
     *
     * Get only the desired data of the response
     */
    public function getResult(){
        $result = $this->response->json();
        return $result['main']['temp'];
    }
}
