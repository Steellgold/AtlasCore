<?php

namespace UnknowG\Atlas\entity\mob;

class Endermite{

    const NETWORK_ID = 55;

    public $width = 5;
    public $height = 5;

    public function getName() {
        return "Endermite";
    }

    public function getSpeed() {
        return 0.50;
    }

    public function isTamed() {
        return false;
    }
}
