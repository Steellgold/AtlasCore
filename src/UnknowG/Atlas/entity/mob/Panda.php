<?php

namespace UnknowG\Atlas\entity\mob;

class Panda{

    const NETWORK_ID = 113;

    public $width = 0.10;
    public $height = 0.5;

    public function getName() {
        return "Turtle";
    }

    public function getSpeed() {
        return 1.2;
    }

    public function isTamed() {
        return false;
    }
}
