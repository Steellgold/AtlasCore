<?php

namespace UnknowG\Atlas\api;

use pocketmine\Player;
use UnknowG\Atlas\data\SQL;

class CoinsAPI extends SQL {

    public static function getCoins(Player $player)
    {
        return $pts = SQL::getData($player,"playerCoinsCount");
    }

    public static function addCoins(Player $player, int $count){
        $database = SQL::getDatabase();
        $name = $player->getName();

        $g = self::getCoins($player);
        $calc = $g + $count;

        $database->query("UPDATE `players` SET `playerCoinsCount`='$calc' WHERE playerName = '$name'");
    }

    public static function delCoins(Player $player, int $count){
        $database = SQL::getDatabase();
        $name = $player->getName();

        $g = self::getCoins($player);
        $calc = $g - $count;

        $database->query("UPDATE `players` SET `playerCoinsCount`='$calc' WHERE playerName = '$name'");
    }

    public static function delOffCoins(string $name, int $count){
        $database = SQL::getDatabase();

        $g = self::getOffData($name,"playerCoinsCount");
        $calc = $g - $count;

        $database->query("UPDATE `players` SET `playerCoinsCount`='$calc' WHERE playerName = '$name'");
    }

    public static function addOffCoins(string $name, int $count){
        $database = SQL::getDatabase();

        $g = self::getOffData($name,"playerCoinsCount");
        $calc = $g + $count;

        $database->query("UPDATE `players` SET `playerCoinsCount`='$calc' WHERE playerName = '$name'");
    }

    public static function setOffCoins(string $name, int $count){
        $database = SQL::getDatabase();

        $database->query("UPDATE `players` SET `playerCoinsCount`='$count' WHERE playerName = '$name'");
    }
}