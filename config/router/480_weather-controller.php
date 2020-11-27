<?php
/**
 * Load the ip validator as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Weather report.",
            "mount" => "weather",
            "handler" => "\Lii\Controller\WeatherController",
        ],
    ]
];
