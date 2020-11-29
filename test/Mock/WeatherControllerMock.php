<?php

namespace Lii\Controller;

use Lii\Model\WeatherReportMock;
use Lii\Model\IPValidatorMock;

/**
 * A mock class.
 */
class WeatherControllerMock extends WeatherController
{

    public function initialize() : void
    {
//         parent::initialize();
        $this->report = new WeatherReportMock("");
        $this->validator = new IPValidatorMock("");
//         $this->userContainer->setApiUrl("");
    }
}
