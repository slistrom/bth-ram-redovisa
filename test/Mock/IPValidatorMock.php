<?php

namespace Lii\Model;

/**
 * A mock class.
 */
class IPValidatorMock extends IPValidator
{
    /**
     * Mock function to avoid asking the live IP API during testing.
     *
     * @param string $inputIP   The IP-address to validate.
     *
     * @return string with information about the IP-address.
     */

    public function locateIP($inputIP)
    {
        $result = "Not valid IP-address.";

        if ($this->validateIPv4($inputIP) || $this->validateIPv6($inputIP)) {
            $result = [
                "ip" => "{$inputIP}",
                "ipv4" => "",
                "ipv6" => "",
                "domain" => "",
                "country" => "",
                "city" => "",
                "latitude" => "1.1",
                "longitude" => "2.2",
                "maplink" => "",
                "country_name" => "",
            ];
        }

        return $result;
    }
}
