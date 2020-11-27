<?php

namespace Lii\Service;

use PHPUnit\Framework\TestCase;

/**
 * Testclass.
 */
class ApiKeyServiceTest extends TestCase
{

    // Create the validator.
    protected $apiKeyService;

    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        $this->apiKeyService = new ApiKeyService();
    }

    /**
     * Test the function setIpKey.
     */
    public function testSetIpKey()
    {
        $this->apiKeyService->setIpKey("testKey");
        $res = $this->apiKeyService->getIpKey();
        $this->assertEquals($res, "testKey");
    }

    /**
     * Test the function setWeatherKey.
     */
    public function testSetWeatherKey()
    {
        $this->apiKeyService->setWeatherKey("testKey");
        $res = $this->apiKeyService->getWeatherKey();
        $this->assertEquals($res, "testKey");
    }
}
