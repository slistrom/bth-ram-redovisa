<?php

namespace Lii\IP;

use PHPUnit\Framework\TestCase;

/**
 * Testclass.
 */
class IPValidatorTest extends TestCase
{

    // Create the validator.
    protected $validator;

    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        $this->validator = new IPValidator();
    }

    /**
     * Test the function validateIPv4.
     */
    public function testValidateIPv4()
    {
        $res = $this->validator->validateIPv4("12.12.12.12");
        $this->assertTrue($res);
    }

    /**
     * Test the function validateIPv6.
     */
    public function testValidateIPv6()
    {
        $res = $this->validator->validateIPv6("2001:0db8:85a3:0000:0000:8a2e:0370:7334");
        $this->assertTrue($res);
    }

    /**
     * Test the function checkDomain.
     */
     public function testCheckDomain()
    {
        $res = $this->validator->checkDomain("37.156.192.50");
        $this->assertEquals($res, "sunet.se");
    }

    /**
     * Test the function validateIPJSON with IPv4 address.
     */
    public function testValidateIPJSONIPv4()
    {
        $res = $this->validator->validateIPJSON("12.12.12.12");
        $this->assertEquals($res[0]["ip"], "12.12.12.12");
    }

    /**
     * Test the function validateIPJSON with IPv6 address.
     */
    public function testValidateIPJSONIPv6()
    {
        $res = $this->validator->validateIPJSON("2001:0db8:85a3:0000:0000:8a2e:0370:7334");
        $this->assertEquals($res[0]["ip"], "2001:0db8:85a3:0000:0000:8a2e:0370:7334");
    }
}
