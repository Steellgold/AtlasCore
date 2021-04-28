<?php

namespace UnknowG\Atlas\api;

use pocketmine\Player;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;

class RankAPI extends SQL
{
    public static $ranks = [
        "fonda",
        "admin",
        "staff",
        "support",
        "ytb",
        "prenium",
        "player"
    ];

    public static $subranks = [
        "prenium",
        "player"
    ];

    public static function isRank(string $rank){
        foreach (self::$ranks as $r){
            if($r == $rank){
                return true;
            }else{
                return false;
            }
        }
    }

    public static function isSubRank(string $rank){
        foreach (self::$subranks as $r){
            if($r == $rank){
                return true;
            }else{
                return false;
            }
        }
    }


    public static function isPremium(Player $player)
    {
        $playerRank = SQL::getData($player, "playerRank");
        $playerSubRank = SQL::getData($player, "playerSubRank");

        if ($playerRank == "prenium" or $playerSubRank == "prenium") {
            return true;
        } else {
            return false;
        }
    }

    public static function isManager(Player $player)
    {
        $playerRank = SQL::getData($player, "playerRank");
        $playerSSRank = SQL::getData($player, "playerSSRank");

        if ($playerSSRank == "sm" or $playerRank == "admin") {
            return true;
        } else {
            return false;
        }
    }

    public static function isNitro(Player $player)
    {
        $playerRank = SQL::getData($player, "playerSSRank");

        if ($playerRank == "nitro") {
            return true;
        } else {
            return false;
        }
    }

    public static function isAllowedPassDoor(Player $player)
    {
        $playerRank = SQL::getData($player, "playerRank");
        $playerSubRank = SQL::getData($player, "playerSubRank");

        if ($playerRank == "ytb" or $playerSubRank == "ytb" or $playerRank == "fonda" or $playerRank == "admin" or $playerRank == "staff" or $playerRank == "prenium" or $playerRank == "support" or $player->getName() == "TrashMoMo6777") {
            return true;
        } else {
            return false;
        }
    }

    public static function isYtb(Player $player)
    {
        $playerRank = SQL::getData($player, "playerRank");
        $playerSubRank = SQL::getData($player, "playerSubRank");

        if ($playerRank == "ytb" or $playerSubRank == "ytb" or $playerRank == "fonda" or $playerRank == "admin" or $playerRank == "staff") {
            return true;
        } else {
            return false;
        }
    }

    public static function isStaff(Player $player)
    {
        $playerRank = SQL::getData($player, "playerRank");

        if ($playerRank == "fonda" or $playerRank == "admin" or $playerRank == "staff") {
            return true;
        } else {
            return false;
        }
    }

    public static function isMStaff(Player $player)
    {
        $playerRank = SQL::getData($player, "playerRank");
        $playerSubRank = SQL::getData($player, "playerSubRank");

        if ($playerRank == "fonda" or $playerRank == "admin" or $playerRank == "staff" or $playerRank == "support" or $playerSubRank == "support") {
            return true;
        } else {
            return false;
        }
    }

    public static function isWhitelisted(Player $player)
    {
        $playerRank = SQL::getData($player, "playerRank");
        $playerSubRank = SQL::getData($player, "playerSubRank");

        if ($playerRank == "fonda" or $playerRank == "admin" or $playerRank == "staff" or $playerSubRank == "prenium" or $playerRank == "prenium") {
            return true;
        } else {
            return false;
        }
    }

    public static function isWhitelistedDev(Player $player)
    {
        $playerRank = SQL::getData($player, "playerRank");

        if ($playerRank == "fonda" or $playerRank == "admin") {
            return true;
        } else {
            return false;
        }
    }

    public static function getColoredRank(Player $player)
    {
        $playerRank = SQL::getData($player, "playerRank");

        switch ($playerRank) {
            case "fonda":
                return Texts::$fondatorRank;
                break;
            case "admin":
                return Texts::$adminRank;
                break;
            case "staff":
                return Texts::$staffRank;
                break;
            case "support":
                return Texts::$supportRank;
                break;
            case "prenium":
                return Texts::$preniumRank;
                break;
            case "ytb":
                return Texts::$ytbRank;
                break;
            case "player":
                return Texts::$playerRank;
                break;
        }
        return true;
    }

    public static function getRank(Player $player)
    {
        $playerRank = SQL::getData($player, "playerRank");
        $playerSubRank = SQL::getData($player, "playerSubRank");

        switch ($playerRank) {
            case "fonda":
                return "Owner";
                break;
            case "admin":
                return "Admin";
                break;
            case "staff":
                return "Super-Moderator";
                break;
            case "support":
                if($playerSubRank == "ytb"){
                    return "Moderator | YouTube";
                }else{
                    return "Moderator";
                }
                break;
            case "ytb":
                return "YouTuber";
                break;
            case "prenium":
                return "Premium";
                break;
            case "player":
                return "Player";
                break;
        }
        return true;
    }

    public static function setSubRank(Player $player, string $result)
    {
        $database = SQL::getDatabase();
        $name = $player->getName();

        $database->query("UPDATE `players` SET `playerSubRank`='$result' WHERE playerName = '$name'");
    }

    public static function setRank(Player $player, string $result)
    {
        $database = SQL::getDatabase();
        $name = $player->getName();

        $database->query("UPDATE `players` SET `playerRank`='$result' WHERE playerName = '$name'");
    }

    public static function setSubRankOff($name, string $result)
    {
        $database = SQL::getDatabase();

        $database->query("UPDATE `players` SET `playerSubRank`='$result' WHERE playerName = '$name'");
    }

    public static function setRankOff($name, string $result)
    {
        $database = SQL::getDatabase();

        $database->query("UPDATE `players` SET `playerRank`='$result' WHERE playerName = '$name'");
    }

    public static function getSubRank(Player $player)
    {
        $database = SQL::getDatabase();
        return SQL::getData($player, "playerSubRank");
    }

    public static function getIDRank(Player $player)
    {
        return $playerRank = SQL::getData($player, "playerRank");
    }

}