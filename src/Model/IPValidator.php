<?php

namespace Lii\Model;

/**
 * Validate an IP-address in different ways.
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @SuppressWarnings(PHPMD.UnusedPrivateField)
 * @SuppressWarnings(PHPMD.StaticAccess)
*/
class IPValidator
{
    // Global variables
    private $accessKey = '';

    /**
     * Load API access key from private file.
     */
    private function fetchApiKey()
    {
        if (file_exists(ANAX_INSTALL_PATH."/PRIVATE_TOKEN")) {
            $myfile = fopen(ANAX_INSTALL_PATH."/PRIVATE_TOKEN", "r");
            $this->accessKey = fread($myfile, filesize(ANAX_INSTALL_PATH."/PRIVATE_TOKEN"));
            fclose($myfile);
        } else {
            $this->accessKey = $_ENV["API_KEY"];
        }
    }

    /**
     * Validate an IPv4 IP-address.
     *
     * @param string $inputIP   The IP-address to validate.
     *
     * @return boolean based on if IP-address is valid or not.
     */
    public function validateIPv4($inputIP)
    {
        $valid = false;

        if (filter_var($inputIP, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $valid = true;
        }

        return $valid;
    }

    /**
     * Validate an IPv6 IP-address.
     *
     * @param string $inputIP   The IP-address to validate.
     *
     * @return boolean based on if IP-address is valid or not.
     */

    public function validateIPv6($inputIP)
    {
        $valid = false;

        if (filter_var($inputIP, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $valid = true;
        }

        return $valid;
    }

    /**
     * Validate an IP-address and return location.
     *
     * @param string $inputIP   The IP-address to validate.
     *
     * @return string with information about the IP-address.
     */

    public function locateIP($inputIP)
    {
        $result = "Not valid IP-address.";

        if ($this->validateIPv4($inputIP) || $this->validateIPv6($inputIP)) {
            $this->fetchApiKey();

            // Initialize CURL:
            $cRes = curl_init('http://api.ipstack.com/'.$inputIP.'?access_key='.$this->accessKey.'');
            curl_setopt($cRes, CURLOPT_RETURNTRANSFER, true);

            // Store the data:
            $json = curl_exec($cRes);
            curl_close($cRes);

            // Decode JSON response:
            $result = json_decode($json, true);
        }

        return $result;
    }

    /**
     * Check if an IP-address has a registered domain name in DNS.
     *
     * @param string $inputIP   The IP-address to check for a domain name.
     *
     * @return boolean based on if IP-address has an domain name or not.
     */
    public function checkDomain($inputIP)
    {
        $result = false;
        $domain = null;

        $validIP = $this->validateIPv4($inputIP);
        if ($validIP) {
            $domain = gethostbyaddr($inputIP);
        }
        if ($domain != $inputIP) {
            $result = $domain;
        }

        return $result;
    }

    /**
     * Validate an IP-address and return a JSON object with information about the address
     *
     * @return json object
     */
    public function validateIPJSON($inputIP)
    {
        $validationResultIPv4 = $this->validateIPv4($inputIP);
        $validationResultIPv6 = $this->validateIPv6($inputIP);
        $domain = $this->checkDomain($inputIP);

        if ($validationResultIPv4) {
            $ipv4msg = "Valid IPv4 address.";
        } else {
            $ipv4msg = "Not valid IPv4 address.";
        }

        if ($validationResultIPv6) {
            $ipv6msg = "Valid IPv6 address.";
        } else {
            $ipv6msg = "Not valid IPv6 address.";
        }

        if (!$domain) {
            $domain = "No domain name found.";
        }

        $json = [
            "ip" => "{$inputIP}",
            "ipv4" => "{$ipv4msg}",
            "ipv6" => "{$ipv6msg}",
            "domain" => "{$domain}",
        ];
        return [$json];
    }

    /**
     * Validate an IP-address and return a JSON object with information about the address
     *
     * @return json object
     */
    public function locateIPJSON($inputIP)
    {
        $result = [
            "error" => "Not valid IP-address.",
        ];

        if ($this->validateIPv4($inputIP) || $this->validateIPv6($inputIP)) {
            $this->fetchApiKey();
            $domain = $this->checkDomain($inputIP);
            $location = $this->locateIP($inputIP);
            $maplink = "https://www.google.com/maps/search/?api=1&query=".$location['latitude'].",".$location['longitude'];

            if ($this->validateIPv4($inputIP)) {
                $ipv4msg = "Valid IPv4 address.";
            } else {
                $ipv4msg = "Not valid IPv4 address.";
            }

            if ($this->validateIPv6($inputIP)) {
                $ipv6msg = "Valid IPv6 address.";
            } else {
                $ipv6msg = "Not valid IPv6 address.";
            }

            if (!$domain) {
                $domain = "No domain name found.";
            }

            $result = [
                "ip" => "{$inputIP}",
                "ipv4" => "{$ipv4msg}",
                "ipv6" => "{$ipv6msg}",
                "domain" => "{$domain}",
                "country" => "{$location['country_name']}",
                "city" => "{$location['city']}",
                "latitude" => "{$location['latitude']}",
                "longitude" => "{$location['longitude']}",
                "maplink" => "{$maplink}",
            ];
        }

        return [$result];
    }
}
