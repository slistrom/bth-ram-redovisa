<?php

namespace Lii\IP;

/**
 * Validate an IP-address in different ways.
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 * @SuppressWarnings(PHPMD.UnusedPrivateField)
 * @SuppressWarnings(PHPMD.StaticAccess)
*/
class IPValidator
{

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
     * This is the validate method action, it handles:
     * POST METHOD mountpoint/validate
     *
     * @return object
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
}
