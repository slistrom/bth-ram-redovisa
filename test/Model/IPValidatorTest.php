<?php

namespace Lii\Model;

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
        $this->validator = new IPValidatorMock("");
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

    /**
     * Test the function locateIPJSON with IPv4-address.
     */
    public function testLocateIPJSONIPv4()
    {
        $res = $this->validator->locateIPJSON("12.12.12.12");
        $this->assertEquals($res[0]["ip"], "12.12.12.12");
    }

    /**
     * Test the function locateIPJSON with IPv6-address.
     */
    public function testLocateIPJSONIPv6()
    {
        $res = $this->validator->locateIPJSON("2001:0db8:85a3:0000:0000:8a2e:0370:7334");
        $this->assertEquals($res[0]["ip"], "2001:0db8:85a3:0000:0000:8a2e:0370:7334");
    }

    /**
     * Test the function locateIPJSON with not valid IP-address.
     */
    public function testLocateIPJSONIPFail()
    {
        $res = $this->validator->locateIPJSON("hej");
        $this->assertEquals($res[0]["error"], "Not valid IP-address.");
    }
}
