<?php

namespace Lii\Model;

/**
 * A mock class.
 */
class WeatherReportMock extends WeatherReport
{
    public function fetchAllWeather($lat, $long)
    {
        $currentWeather = [];
        $currentWeather["weather"][0]["description"] = "Cloudy";
        $currentWeather["main"]["temp"] = 1.1;
        $currentWeather["wind"]["speed"] = 2.2;

        $forecastWeather = [];
        $forecastWeather["daily"][0]["dt"] = "1606503600";
        $forecastWeather["daily"][0]["weather"][0]["main"] = "Sunny";
        $forecastWeather["daily"][0]["temp"]["day"] = 3.3;
        $forecastWeather["daily"][0]["wind_speed"] = 4.4;

        return  [$currentWeather, $forecastWeather];
    }

    public function getHistoricWeather($days, $lat, $long)
    {
        $historicWeather = [];
        $historicWeather[0]["current"]["dt"] = "1606384800";
        $historicWeather[0]["current"]["weather"][0]["main"] = "Sunny";
        $historicWeather[0]["current"]["temp"] = 5.5;
        $historicWeather[0]["current"]["wind_speed"] = 6.6;

        return  $historicWeather;
    }

    public function getJsonWeather($days, $lat, $long)
    {
        $jsonWeather = [];

        return  $jsonWeather;
    }
}
