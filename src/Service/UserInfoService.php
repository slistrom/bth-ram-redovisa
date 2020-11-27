<?php

namespace Lii\Service;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * A service class that is injected with di.
 */
class UserInfoService implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

//     public function useService() : string
//     {
//         return "DI contains " . count($this->di->getServices()) . " services.";
//     }

    public function getUserIP() : string
    {
        $request = $this->di->get("request");
        $userIP = $request->getServer("HTTP_X_FORWARDED_FOR", "x.x.x.x");

        return $userIP;
    }
}
