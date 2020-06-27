<?php
namespace App\Interfaces;

interface WeatherDataInterface {
    public function buildParams();
    public function getWeather($location);
    public function getResult();
}
