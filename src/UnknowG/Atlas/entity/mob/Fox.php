<?php

namespace UnknowG\Atlas\entity\mob;

class Fox{

    const NETWORK_ID = 121;

    public $width = 0.7;
    public $height = 0.6;

    public function getName() {
        return "Fox";
    }

    public function getSpeed() {
        return 1.2;
    }

    public function isTamed() {
        return false;
    }
}
