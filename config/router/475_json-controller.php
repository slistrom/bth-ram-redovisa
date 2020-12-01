<?php
/**
 * Load the ip validator as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "JSON API.",
            "mount" => "api",
            "handler" => "\Lii\Controller\JsonController",
        ],
    ]
];
