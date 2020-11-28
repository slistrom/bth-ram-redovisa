<?php

namespace Lii\Controller;

use Lii\Model\IPValidator;
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

        $this->validator = new IPValidator();
        $this->report = new WeatherReportMock("");
    }
}
