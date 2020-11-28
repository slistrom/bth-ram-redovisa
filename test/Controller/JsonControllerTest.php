<?php

namespace Lii\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleJsonController.
 */
class JsonControllerTest extends TestCase
{
    
    // Create the di container.
    protected $di;
    protected $controller;



    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;

        // Setup di
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use a different cache dir for unit test
        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;

        // Setup the controller
        $this->controller = new JsonControllerMock();
        $this->controller->setDI($this->di);
        $this->controller->initialize();
    }



    /**
     * Test the route "index".
     */
    public function testIndexAction()
    {
        $res = $this->controller->indexActionGet();
        $this->assertInternalType("array", $res);

        $json = $res[0];
        $exp = "db is active";
        $this->assertContains($exp, $json["message"]);
    }

    /**
     * Test the route "info".
     */
    public function testInfoAction()
    {
        // Test the controller action
        $res = $this->controller->infoAction();
        $body = $res->getBody();
        $this->assertStringContainsString("Information om me-sidans API", $body);
    }


    /**
     * Test the route "validation" for POST.
     */
    public function testValidateActionPost()
    {
        // Setup request
        $request = $this->di->get("request");
        $request->setPost("ip", "12.12.12.12");

        // Test the controller action
        $res = $this->controller->validateActionPost();
        $this->assertInternalType("array", $res);

        $json = $res[0];
        $exp = "12.12.12.12";
        $this->assertContains($exp, $json["ip"]);
    }

    /**
     * Test the route "validation" for GET.
     */
    public function testValidateActionGet()
    {
        // Setup request
        $request = $this->di->get("request");
        $request->setGet("ip", "12.12.12.12");

        // Test the controller action
        $res = $this->controller->validateActionGet();
        $this->assertInternalType("array", $res);

        $json = $res[0];
        $exp = "12.12.12.12";
        $this->assertContains($exp, $json["ip"]);
    }

    /**
     * Test the route "location" for POST.
     */
    public function testLocationActionPost()
    {
        // Setup request
        $request = $this->di->get("request");
        $request->setPost("ip", "12.12.12.12");

        // Test the controller action
        $res = $this->controller->locationActionPost();
        $this->assertInternalType("array", $res);

        $json = $res[0];
        $exp = "12.12.12.12";
        $this->assertContains($exp, $json["ip"]);
    }

    /**
     * Test the route "location" for GET.
     */
    public function testLocationActionGet()
    {
        // Setup request
        $request = $this->di->get("request");
        $request->setGet("ip", "12.12.12.12");

        // Test the controller action
        $res = $this->controller->locationActionGet();
        $this->assertInternalType("array", $res);

        $json = $res[0];
        $exp = "12.12.12.12";
        $this->assertContains($exp, $json["ip"]);
    }

    /**
     * Test the route "location" for GET with wrong input.
     */
    public function testLocationActionGetFail()
    {
        // Setup request
        $request = $this->di->get("request");
        $request->setGet("ip", "12");

        // Test the controller action
        $res = $this->controller->locationActionGet();
        $this->assertInternalType("array", $res);

        $json = $res[0];
        $exp = "Not valid IP-address.";
        $this->assertContains($exp, $json["error"]);
    }

    /**
     * Test the route "weather" for POST.
     */
    public function testWeatherActionPost()
    {
        // Setup request
        $request = $this->di->get("request");
        $request->setPost("ip", "12.12.12.12");

        // Test the controller action
        $res = $this->controller->weatherActionPost();
        $this->assertInternalType("array", $res);

//         $json = $res[0];
//         $exp = "12.12.12.12";
//         $this->assertContains($exp, $json["city"]);
    }
}
