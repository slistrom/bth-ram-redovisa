<?php

namespace Lii\Controller;

use Lii\Model\WeatherReportMock;

/**
 * A mock class.
 */
class WeatherControllerMock extends WeatherController
{

    public function initialize() : void
    {
//         parent::initialize();
        $this->report = new WeatherReportMock("");
//         $this->userContainer->setApiUrl("");
    }
}
