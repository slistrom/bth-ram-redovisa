<?php

namespace Lii\Service;

/**
 * A plain service class with no dependencies.
 */
class ApiKeyService
{
//     private $message = null;
    private $ipkey = null;
    private $weatherkey = null;

//     public function setMessage(string $message) : void
//     {
//         $this->message = $message;
//     }

    public function setIpKey(string $ipkey) : void
    {
        $this->ipkey = $ipkey;
    }

    public function setWeatherKey(string $weatherkey) : void
    {
        $this->weatherkey = $weatherkey;
    }

//     public function useService() : string
//     {
//         return "This service loads a message from the config file.<br>&gt; '{$this->message}'";
//     }

    public function getIpKey()
    {
        return $this->ipkey;
    }

    public function getWeatherKey()
    {
        return $this->weatherkey;
    }
}
