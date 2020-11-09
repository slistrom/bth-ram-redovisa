<?php
/**
 * Load the ip validator as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Validate IP-address.",
            "mount" => "ip",
            "handler" => "\Lii\IP\IPController",
        ],
    ]
];
