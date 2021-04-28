<?php

namespace UnknowG\Atlas\entity\mob;

use pocketmine\entity\Monster;

class Creeper extends Monster
{
    const NETWORK_ID = 33;

    public $height = 1.7;
    public $width = 0.6;


    public function getName() : string{
        return "Creeper";
    }
}