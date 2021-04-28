<?php

namespace UnknowG\Atlas\api;

use pocketmine\Player;
use UnknowG\Atlas\data\SQL;

class QuestAPI extends SQL {
    public static function isFinished(Player $player)
    {
        return $pts = SQL::getQuestData($player,"astronautFinished");
    }

    public static function getHaveSon(Player $player)
    {
        return $pts = SQL::getQuestData($player,"astronautHaveSon");
    }

    public static function setFinishAstronaut(Player $player){
        $database = SQL::getDatabase();
        $name = $player->getName();

            $database->query("UPDATE `questPlayer` SET `astronautStarted`='1',`astronautHaveSon`='1',`astronautFinished`='1' WHERE playerName = '$name'");
    }

    public static function setHaveSon(Player $player){
        $database = SQL::getDatabase();
        $name = $player->getName();

        $database->query("UPDATE `questPlayer` SET `astronautStarted`='1',`astronautHaveSon`='1' WHERE playerName = '$name'");
    }
}