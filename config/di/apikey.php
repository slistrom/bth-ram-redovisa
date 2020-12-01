<?php
/**
 * Configuration file for DI container.
 */
return [

    // Services to add to the container.
    "services" => [
        "apikeys" => [
            // Is the service shared, true or false
            // Optional, default is true
            "shared" => true,

            // Is the service activated by default, true or false
            // Optional, default is false
            "active" => false,

            // Callback executed when service is activated
            // Create the service, load its configuration (if any)
            // and set it up.
            "callback" => function () {
                $service = new \Lii\Service\ApiKeyService();

                // Load the configuration file(s)
                $cfg = $this->get("configuration");
                $config = $cfg->load("api_keys");
//                 var_dump($config);
                $settings = $config["config"] ?? null;

//                 if ($settings["message"] ?? null) {
//                     $service->setMessage($settings["message"]);
//                 }

                if ($settings["ipstack"] ?? null) {
                    $service->setIpKey($settings["ipstack"]);
                }

                if ($settings["openweather"] ?? null) {
                    $service->setWeatherKey($settings["openweather"]);
                }

                return $service;
            }
        ],
    ],
];
