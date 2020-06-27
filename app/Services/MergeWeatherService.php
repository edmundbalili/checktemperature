<?php
namespace App\Services;

class MergeWeatherService
{
    protected $services;

    /**
     *
     * Use/Consume each services on __construct
     */
    public function __construct(
        OpenWeatherService $openWeatherService,
        WeatherApiService $weatherApiService
        )
    {
        $this->services = [$openWeatherService, $weatherApiService];
    }

    /**
     * Trigger each service with location as input
     * @param String $location
     * @return Array $result
     */
    public function getWeatherResults($location)
    {
        $result = [];

        foreach ($this->services as $service) {
            if ($service->getWeather($location)){
                $result[] = $service->getWeather($location);
            }
        }

        return $result;
    }

}
