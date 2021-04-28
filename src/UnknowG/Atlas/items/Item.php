<?php

namespace UnknowG\Atlas\items;

use pocketmine\Player;
use UnknowG\Atlas\entity\Hook;

class Item{
    private static $fishing = [];

    public static function getFishingHook(Player $player): ?Hook{
        return self::$fishing[$player->getName()] ?? null;
    }

    public static function setFishingHook(?Hook $fish, Player $player){
        self::$fishing[$player->getName()] = $fish;
    }
}