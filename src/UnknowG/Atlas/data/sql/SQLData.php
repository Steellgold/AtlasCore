<?php

namespace UnknowG\Atlas\data\sql;

use pocketmine\Player;
use UnknowG\Atlas\data\SQL;

class SQLData extends SQL
{
    public static function getLang(Player $player)
    {
        return SQL::getData($player,"playerLang");
    }

    public static function setLang(Player $player,string $result)
    {
        $database = SQL::getDatabase();
        $name = $player->getName();

        $database->query("UPDATE `players` SET `playerLang`='$result' WHERE playerName = '$name'");
    }

    public static function setData(Player $player,string $databaseName, string $table,string $tableResult)
    {
        $database = SQL::getDatabase();
        $name = $player->getName();

        $database->query("UPDATE `$databaseName` SET `$table`='$tableResult' WHERE playerName = '$name'");
    }

    public static function setOffData($name,string $databaseName, string $table,string $tableResult)
    {
        $database = SQL::getDatabase();

        $database->query("UPDATE '$databaseName' SET `$table`='$tableResult' WHERE playerName = '$name'");
    }

    public static function killBan(Player $player)
    {
        $database = SQL::getDatabase();
        $name = $player->getName();

        $database->query("DELETE FROM `bannedPlayers` WHERE playerName='$name'");
    }

    public static function killMute(Player $player)
    {
        $database = SQL::getDatabase();
        $name = $player->getName();

        $database->query("DELETE FROM `mutedPlayers` WHERE playerName='$name'");
    }
}