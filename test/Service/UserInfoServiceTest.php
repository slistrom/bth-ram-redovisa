<?php

namespace Lii\Service;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Testclass.
 */
class UserInfoServiceTest extends TestCase
{

    // Create the service.
    protected $userInfoService;

    // Create the di container.
    protected $di;

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
        $this->userInfoService = new UserInfoService();
        $this->userInfoService->setDI($this->di);
    }

    /**
     * Test the function setIpKey.
     */
    public function testGetUserIP()
    {
        $res = $this->userInfoService->getUserIP();
        $this->assertEquals($res, "x.x.x.x");
    }
}
