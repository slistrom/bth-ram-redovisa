<?php

namespace Lii\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Testclass.
 */
class WeatherControllerTest extends TestCase
{
    // Create the di container.
    protected $di;
    protected $controller = null;

    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;

        // Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use a different cache dir for unit test
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");
        $this->di = $di;

        // Setup the controller
//         $controller = new WeatherController();
        $this->controller = new WeatherControllerMock();
        $this->controller->setDI($this->di);
        $this->controller->initialize();
    }

    /**
     * Test the route "weather".
     */
    public function testIndexAction()
    {

        // Test the controller action
        $res = $this->controller->indexAction();
        $body = $res->getBody();
        $this->assertStringContainsString("Weather report", $body);
    }

    /**
     * Test the route "map".
     */
    public function testMapActionPost()
    {
        // Setup the controller
//         $controller = new WeatherController();
//         $controller->setDI($this->di);

        // Setup request
        $request = $this->di->get("request");
        $request->setPost("ip", "12.12.12.12");

        // Test the controller action
        $res = $this->controller->mapActionPost();
        $body = $res->getBody();
        $this->assertStringContainsString("Weather report", $body);
    }

    /**
     * Test the route "map" when the request fail.
     */
    public function testMapActionPostFail()
    {
        // Setup the controller
//         $controller = new WeatherController();
//         $controller->setDI($this->di);

        // Setup request
        $request = $this->di->get("request");
        $request->setPost("ip", "12.12");

        // Test the controller action
        $res = $this->controller->mapActionPost();
        $body = $res->getBody();
        $this->assertStringContainsString("Not a valid IP-address", $body);
    }
}
