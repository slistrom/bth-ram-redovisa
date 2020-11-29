<?php

namespace Lii\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Testclass.
 */
class IPControllerTest extends TestCase
{
    // Create the di container.
    protected $di;
    public $controller = null;

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
        $this->controller = new IPControllerMock();
        $this->controller->setDI($this->di);
        $this->controller->initialize();
    }

    /**
     * Test the route "index".
     */
    public function testIndexAction()
    {
        // Setup the controller
//         $controller = new IPController();
//         $controller->setDI($this->di);

        // Test the controller action
        $res = $this->controller->indexAction();
        $body = $res->getBody();
        $this->assertStringContainsString("Validera en IP-adress", $body);
    }

    /**
     * Test the route "index".
     */
    public function testValidateActionPost()
    {
        // Setup the controller
//         $controller = new IPController();
//         $controller->setDI($this->di);

        // Setup request
        $request = $this->di->get("request");
        $request->setPost("ip", "12.12.12.12");

        // Test the controller action
        $res = $this->controller->validateActionPost();
        $body = $res->getBody();
        $this->assertStringContainsString("Validerings resultat", $body);
        $this->assertStringContainsString("12.12.12.12", $body);
    }

    /**
     * Test the "catchall" function on a route that does not exist.
     */
    public function testCatchAll()
    {
        // Setup the controller
//         $controller = new IPController();
//         $controller->setDI($this->di);

        // Setup route
        $router = $this->di->get("router");
        $router->handle("ip/hej");

        // Test the controller action
        $res = $this->controller->catchAll();
        $body = $res->getBody();
        $this->assertStringContainsString("Lii\Controller\IPController::catchAll", $body);
    }
}
