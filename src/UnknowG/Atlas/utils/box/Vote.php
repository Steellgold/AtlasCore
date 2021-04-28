<?php

namespace UnknowG\Atlas\utils\box;

use pocketmine\Player;
use UnknowG\Atlas\api\CoinsAPI;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;
use UnknowG\Atlas\utils\texts\Unicodes;

class Vote
{
    public static function launchBox(Player $player)
    {
        $mtRand = mt_rand(1, 10);
        $u = Unicodes::$coin;

        switch ($mtRand) {
            case 1:
                CoinsAPI::addCoins($player, 5);
                Texts::sendMessage($player,Texts::$prefixBox,"§7Vous avez récuperer §35$u", "§7You have recovered §35$u");
                break;
            case 2:
                CoinsAPI::addCoins($player, 10);
                Texts::sendMessage($player,Texts::$prefixBox,"§7Vous avez récuperer §310$u", "§7You have recovered §310$u");
                break;
            case 3:
                CoinsAPI::addCoins($player, 15);
                Texts::sendMessage($player,Texts::$prefixBox,"§7Vous avez récuperer §315$u", "§7You have recovered §315$u");
                break;
            case 4:
                CoinsAPI::addCoins($player, 20);
                Texts::sendMessage($player,Texts::$prefixBox,"§7Vous avez récuperer §320$u", "§7You have recovered §320$u");
                break;
            case 5:
                CoinsAPI::addCoins($player, 25);
                Texts::sendMessage($player,Texts::$prefixBox,"§7Vous avez récuperer §325$u", "§7You have recovered §325$u");
                break;
            case 6:
                CoinsAPI::addCoins($player, 30);
                Texts::sendMessage($player,Texts::$prefixBox,"§7Vous avez récuperer §330$u", "§7You have recovered §330$u");
                break;
            case 7:
                CoinsAPI::addCoins($player, 35);
                Texts::sendMessage($player,Texts::$prefixBox,"§7Vous avez récuperer §335$u", "§7You have recovered §335$u");
                break;
            case 8:
                CoinsAPI::addCoins($player, 40);
                Texts::sendMessage($player,Texts::$prefixBox,"§7Vous avez récuperer §340$u", "§7You have recovered §340$u");
                break;
            case 9:
                CoinsAPI::addCoins($player, 45);
                Texts::sendMessage($player,Texts::$prefixBox,"§7Vous avez récuperer §345$u", "§7You have recovered §345$u");
                break;
            case 10:
                CoinsAPI::addCoins($player, 50);
                Texts::sendMessage($player,Texts::$prefixBox,"§7Vous avez récuperer §350$u", "§7You have recovered §350$u");
                break;
        }
    }

    public static function addKey(Player $player)
    {
        $data = SQLData::getData($player, "playerKeyCountsVote");
        $total = $data + 1;

        SQLData::setData($player,"players","playerKeyCountsVote", $total);
    }
}