<?php

namespace Lii\Model;

/**
 * Get weather reports for a specific location.
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @SuppressWarnings(PHPMD.UnusedPrivateField)
 * @SuppressWarnings(PHPMD.StaticAccess)
*/
class WeatherReport
{

    // Global variables
    private $accessKey = '';

    public function __construct($apiKey)
    {
        $this->accessKey = $apiKey;
    }

//     public function checkWeather($lat, $long)
//     {
//             // Initialize CURL:
//             $cRes = curl_init('api.openweathermap.org/data/2.5/weather?lat='.$lat.'&lon='.$long.'&units=metric&appid='.$this->accessKey.'');
//             curl_setopt($cRes, CURLOPT_RETURNTRANSFER, true);
//
//             // Store the data:
//             $json = curl_exec($cRes);
//             curl_close($cRes);
//
//             // Decode JSON response:
//             $result = json_decode($json, true);
//
//         return $result;
//     }

    public function fetchAllWeather($lat, $long)
    {
        // build the individual requests, but do not execute them
        $ch1 = curl_init('api.openweathermap.org/data/2.5/weather?lat='.$lat.'&lon='.$long.'&units=metric&appid='.$this->accessKey.'');
        $ch2 = curl_init('https://api.openweathermap.org/data/2.5/onecall?lat='.$lat.'&lon='.$long.'&exclude=hourly,minutely,current&units=metric&appid='.$this->accessKey.'');
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);

        // build the multi-curl handle, adding both $ch
        $mh1 = curl_multi_init();
        curl_multi_add_handle($mh1, $ch1);
        curl_multi_add_handle($mh1, $ch2);

        // execute all queries simultaneously, and continue when all are complete
        $running = null;
        do {
            curl_multi_exec($mh1, $running);
        } while ($running);

        //close the handles
        curl_multi_remove_handle($mh1, $ch1);
        curl_multi_remove_handle($mh1, $ch2);
        curl_multi_close($mh1);

        // all of our requests are done, we can now access the results
        $result1 = curl_multi_getcontent($ch1);
        $currentWeather = json_decode($result1, true);
        $result2 = curl_multi_getcontent($ch2);
        $forecastWeather = json_decode($result2, true);

        return  [$currentWeather, $forecastWeather];
    }

    public function getHistoricDates()
    {
        $dates = [];
        $date = date_create(date("Y-m-d", time()));
        date_modify($date, "-1 days");
        $date1 = date_create(date("Y-m-d", date_format($date, "U")));
        date_modify($date, "-1 days");
        $date2 = date_create(date("Y-m-d", date_format($date, "U")));
        date_modify($date, "-1 days");
        $date3 = date_create(date("Y-m-d", date_format($date, "U")));
        date_modify($date, "-1 days");
        $date4 = date_create(date("Y-m-d", date_format($date, "U")));
        array_push($dates, date_format($date1, "U"), date_format($date2, "U"), date_format($date3, "U"), date_format($date4, "U"));

        return $dates;
    }

    public function getHistoricWeather($days, $lat, $long)
    {
        $url = 'https://api.openweathermap.org/data/2.5/onecall/timemachine?lat='.$lat.'&lon='.$long.'&units=metric&appid='.$this->accessKey.'&dt=';

        $options = [
            CURLOPT_RETURNTRANSFER => true,
        ];

        // Add all curl handlers and remember them
        // Initiate the multi curl handler
        $mh1 = curl_multi_init();
        $chAll = [];
        foreach ($days as $day) {
            $ch1 = curl_init("$url$day");
            curl_setopt_array($ch1, $options);
            curl_multi_add_handle($mh1, $ch1);
            $chAll[] = $ch1;
        }

        // Execute all queries simultaneously,
        // and continue when all are complete
        $running = null;
        do {
            curl_multi_exec($mh1, $running);
        } while ($running);

        // Close the handles
        foreach ($chAll as $ch1) {
            curl_multi_remove_handle($mh1, $ch1);
        }
        curl_multi_close($mh1);

        // All of our requests are done, we can now access the results
        $response = [];
        foreach ($chAll as $ch1) {
            $data = curl_multi_getcontent($ch1);
            $response[] = json_decode($data, true);
        }

        return $response;
    }

    public function getJsonWeather($days, $lat, $long)
    {
        $allWeather = $this->fetchAllWeather($lat, $long);
        $historicWeather = $this->getHistoricWeather($days, $lat, $long);

//         var_dump($historicWeather);

        $json = [
            "city" => "{$allWeather[0]['name']}",
            "current" => [
                            "weather" => "{$allWeather[0]['weather'][0]['description']}",
                            "temp" => "{$allWeather[0]['main']['temp']}",
                            "wind_speed" => "{$allWeather[0]['wind']['speed']}",
                            ],
            "forecast" => [
                            [
                                "date" => "{$allWeather[1]['daily'][0]['dt']}",
                                "weather" => "{$allWeather[1]['daily'][0]['weather'][0]['main']}",
                                "temp" => "{$allWeather[1]['daily'][0]['temp']['day']}",
                                "wind_speed" => "{$allWeather[1]['daily'][0]['wind_speed']}",
                            ],
                            [
                                "date" => "{$allWeather[1]['daily'][1]['dt']}",
                                "weather" => "{$allWeather[1]['daily'][1]['weather'][0]['main']}",
                                "temp" => "{$allWeather[1]['daily'][1]['temp']['day']}",
                                "wind_speed" => "{$allWeather[1]['daily'][1]['wind_speed']}",
                            ],
                            [
                                "date" => "{$allWeather[1]['daily'][2]['dt']}",
                                "weather" => "{$allWeather[1]['daily'][2]['weather'][0]['main']}",
                                "temp" => "{$allWeather[1]['daily'][2]['temp']['day']}",
                                "wind_speed" => "{$allWeather[1]['daily'][2]['wind_speed']}",
                            ],
                            [
                                "date" => "{$allWeather[1]['daily'][3]['dt']}",
                                "weather" => "{$allWeather[1]['daily'][3]['weather'][0]['main']}",
                                "temp" => "{$allWeather[1]['daily'][3]['temp']['day']}",
                                "wind_speed" => "{$allWeather[1]['daily'][3]['wind_speed']}",
                            ],
                            [
                                "date" => "{$allWeather[1]['daily'][4]['dt']}",
                                "weather" => "{$allWeather[1]['daily'][4]['weather'][0]['main']}",
                                "temp" => "{$allWeather[1]['daily'][4]['temp']['day']}",
                                "wind_speed" => "{$allWeather[1]['daily'][4]['wind_speed']}",
                            ],
                            [
                                "date" => "{$allWeather[1]['daily'][5]['dt']}",
                                "weather" => "{$allWeather[1]['daily'][5]['weather'][0]['main']}",
                                "temp" => "{$allWeather[1]['daily'][5]['temp']['day']}",
                                "wind_speed" => "{$allWeather[1]['daily'][5]['wind_speed']}",
                            ],
                            [
                                "date" => "{$allWeather[1]['daily'][6]['dt']}",
                                "weather" => "{$allWeather[1]['daily'][6]['weather'][0]['main']}",
                                "temp" => "{$allWeather[1]['daily'][6]['temp']['day']}",
                                "wind_speed" => "{$allWeather[1]['daily'][6]['wind_speed']}",
                            ],
                            [
                                "date" => "{$allWeather[1]['daily'][7]['dt']}",
                                "weather" => "{$allWeather[1]['daily'][7]['weather'][0]['main']}",
                                "temp" => "{$allWeather[1]['daily'][7]['temp']['day']}",
                                "wind_speed" => "{$allWeather[1]['daily'][7]['wind_speed']}",
                            ]
                        ],
            "historical" => [
                            [
                                "date" => "{$historicWeather[0]['current']['dt']}",
                                "weather" => "{$historicWeather[0]['current']['weather'][0]['main']}",
                                "temp" => "{$historicWeather[0]['current']['temp']}",
                                "wind_speed" => "{$historicWeather[0]['current']['wind_speed']}",
                            ],
                            [
                                "date" => "{$historicWeather[1]['current']['dt']}",
                                "weather" => "{$historicWeather[1]['current']['weather'][0]['main']}",
                                "temp" => "{$historicWeather[1]['current']['temp']}",
                                "wind_speed" => "{$historicWeather[1]['current']['wind_speed']}",
                            ],
                            [
                                "date" => "{$historicWeather[2]['current']['dt']}",
                                "weather" => "{$historicWeather[2]['current']['weather'][0]['main']}",
                                "temp" => "{$historicWeather[2]['current']['temp']}",
                                "wind_speed" => "{$historicWeather[2]['current']['wind_speed']}",
                            ],
                            [
                                "date" => "{$historicWeather[3]['current']['dt']}",
                                "weather" => "{$historicWeather[3]['current']['weather'][0]['main']}",
                                "temp" => "{$historicWeather[3]['current']['temp']}",
                                "wind_speed" => "{$historicWeather[3]['current']['wind_speed']}",
                            ],
                        ]
        ];

        return [$json];
    }
}
