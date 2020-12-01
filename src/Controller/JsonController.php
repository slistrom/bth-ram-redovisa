<?php

namespace Lii\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Lii\Model\IPValidator;
use Lii\Model\WeatherReport;

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
class JsonController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * @var string $db a sample member variable that gets initialised
     */
    public $db = "not active";
    public $validator = null;
    public $report = null;

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
        $service = $this->di->get("apikeys");

        $this->validator = new IPValidator($service->getIpKey());
        $this->report = new WeatherReport($service->getWeatherKey());
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
        $request = $this->di->get("request");
        $userIP = $request->getServer("HTTP_X_FORWARDED_FOR", "x.x.x.x");

        $page = $this->di->get("page");
        $data = [
            "userIP" => $userIP,
        ];

        $page->add("Lii/api-info", $data);

        return $page->render([
            "title" => __METHOD__,
        ]);
    }

    /**
     * This is the validate method action, it handles:
     * POST METHOD mountpoint/validate
     *
     * @return array
     */
    public function validateActionPost() : array
    {
        $request = $this->di->get("request");
        $inputIP = $request->getPost("ip");

//         $validator = new IPValidator();
        $json = $this->validator->validateIPJSON($inputIP);

        return $json;
    }

    /**
     * This is the validate method action, it handles:
     * GET METHOD mountpoint/validate
     *
     * @return array
     */
    public function validateActionGet() : array
    {
        $request = $this->di->get("request");
        $inputIP = $request->getGet("ip");

//         $validator = new IPValidator();
        $json = $this->validator->validateIPJSON($inputIP);

        return $json;
    }

    /**
     * This is the validate method action, it handles:
     * GET METHOD mountpoint/location
     *
     * @return array
     */
    public function locationActionGet() : array
    {
        $request = $this->di->get("request");
        $inputIP = $request->getGet("ip");

//         $validator = new IPValidator();
        $json = $this->validator->locateIPJSON($inputIP);

        return $json;
    }
    /**
     * This is the validate method action, it handles:
     * POST METHOD mountpoint/location
     *
     * @return array
     */
    public function locationActionPost() : array
    {
        $request = $this->di->get("request");
        $inputIP = $request->getPost("ip");

//         $validator = new IPValidator();
        $json = $this->validator->locateIPJSON($inputIP);

        return $json;
    }
    /**
     * This is the validate method action, it handles:
     * POST METHOD mountpoint/weather
     *
     * @return array
     */
    public function weatherActionPost() : array
    {
        $request = $this->di->get("request");
        $inputIP = $request->getPost("ip");

//         $validator = new IPValidator();
        $location = $this->validator->locateIP($inputIP);
        $json = [];

        if ($location == 'Not valid IP-address.') {
            $json = [
                "error" => "Not valid IP-address.",
            ];
            $json = [$json];
        } else {
            $json = $this->report->getJsonWeather($this->report->getHistoricDates(), $location["latitude"], $location["longitude"]);
        }

        return $json;
    }
}
