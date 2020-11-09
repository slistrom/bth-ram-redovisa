<?php

namespace Lii\IP;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Lii\IP\IPValidator;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample JSON controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 */
class JsonIPController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->db = "active";
    }



    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint
     * GET METHOD mountpoint/
     * GET METHOD mountpoint/index
     *
     * @return array
     */
    public function indexActionGet() : array
    {
        // Deal with the action and return a response.
        $json = [
            "message" => __METHOD__ . ", \$db is {$this->db}",
        ];
        return [$json];
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function infoAction() : object
    {
        $page = $this->di->get("page");

        $page->add("Lii/api-info");

        return $page->render([
            "title" => __METHOD__,
        ]);
    }

    /**
     * This is the validate method action, it handles:
     * POST METHOD mountpoint/validate
     *
     * @return object
     */
    public function validateActionPost() : array
    {
        $request = $this->di->get("request");
        $inputIP = $request->getPost("ip");

        $validator = new IPValidator();
        $json = $validator->validateIPJSON($inputIP);

//         $validationResultIPv4 = $validator->validateIPv4($inputIP);
//         $validationResultIPv6 = $validator->validateIPv6($inputIP);
//         $domain = $validator->checkDomain($inputIP);
//
//         if ($validationResultIPv4) {
//             $ipv4msg = "Valid IPv4 address.";
//         } else {
//             $ipv4msg = "Not valid IPv4 address.";
//         }
//
//         if ($validationResultIPv6) {
//             $ipv6msg = "Valid IPv6 address.";
//         } else {
//             $ipv6msg = "Not valid IPv6 address.";
//         }
//
//         if (!$domain) {
//             $domain = "No domain name found.";
//         }
//
//         $json = [
//             "ip" => "{$inputIP}",
//             "ipv4" => "{$ipv4msg}",
//             "ipv6" => "{$ipv6msg}",
//             "domain" => "{$domain}"
//         ];

        return $json;
    }

    /**
     * This is the validate method action, it handles:
     * POST METHOD mountpoint/validate
     *
     * @return object
     */
    public function validateActionGet() : array
    {
        $request = $this->di->get("request");
        $inputIP = $request->getGet("ip");

        $validator = new IPValidator();
        $json = $validator->validateIPJSON($inputIP);

        return $json;
    }
    /**
     * This sample method dumps the content of $di.
     * GET mountpoint/dump-app
     *
     * @return array
     */
//     public function dumpDiActionGet() : array
//     {
//         // Deal with the action and return a response.
//         $services = implode(", ", $this->di->getServices());
//         $json = [
//             "message" => __METHOD__ . "<p>\$di contains: $services",
//             "di" => $this->di->getServices(),
//         ];
//         return [$json];
//     }



    /**
     * Try to access a forbidden resource.
     * ANY mountpoint/forbidden
     *
     * @return array
     */
//     public function forbiddenAction() : array
//     {
//         // Deal with the action and return a response.
//         $json = [
//             "message" => __METHOD__ . ", forbidden to access.",
//         ];
//         return [$json, 403];
//     }
}
