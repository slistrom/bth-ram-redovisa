<?php

namespace Lii\Controller;

use Lii\Model\IPValidatorMock;

/**
 * A mock class.
 */
class IPControllerMock extends IPController
{

    public function initialize() : void
    {
        $this->db = "active";
        $this->validator = new IPValidatorMock("");
    }
}
