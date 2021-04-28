<?php

namespace UnknowG\Atlas\entity\mob;

class Agent{

    const NETWORK_ID = 56;

    public $width = 2;
    public $height = 2;

    public function getName() {
        return "Agent";
    }

    public function getSpeed() {
        return 1.2;
    }

    public function isTamed() {
        return false;
    }
}
