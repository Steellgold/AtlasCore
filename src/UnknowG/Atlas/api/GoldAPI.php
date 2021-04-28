<?php

namespace UnknowG\Atlas\api;

use pocketmine\Player;
use UnknowG\Atlas\data\SQL;

class GoldAPI extends SQL {

    public static function getGold(Player $player)
    {
        return $pts = SQL::getData($player,"playerGoldCount");
    }

    public static function addGold(Player $player, int $count){
        $database = SQL::getDatabase();
        $name = $player->getName();

        $g = self::getGold($player);
        $calc = $g + $count;

        $database->query("UPDATE `players` SET `playerGoldCount`='$calc' WHERE playerName = '$name'");
    }

    public static function delGold(Player $player, int $count){
        $database = SQL::getDatabase();
        $name = $player->getName();

        $g = self::getGold($player);
        $calc = $g - $count;

        $database->query("UPDATE `players` SET `playerGoldCount`='$calc' WHERE playerName = '$name'");
    }
}