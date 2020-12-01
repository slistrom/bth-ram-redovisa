<?php

namespace Lii\Controller;

use Lii\Model\IPValidatorMock;
use Lii\Model\WeatherReportMock;

/**
 * A mock class.
 */
class JsonControllerMock extends JsonController
{

    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->db = "active";

        $this->validator = new IPValidatorMock("");
        $this->report = new WeatherReportMock("");
    }
}
