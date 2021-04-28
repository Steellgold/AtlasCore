<?php

namespace UnknowG\Atlas\utils;

use pocketmine\Player;
use UnknowG\Atlas\api\CoinsAPI;
use UnknowG\Atlas\api\RankAPI;

class Rand{
    public static function giveRandCoin(Player $player){
        if(RankAPI::isPremium($player)){
            $nuC = mt_rand(0, 3);
        }else{
            $nuC = mt_rand(0, 6);
        }

        if ($nuC == 1) {
            CoinsAPI::addCoins($player, 1);
            $player->sendPopup("§e+ 1");
        }
    }

    public static function giveStickRandCoin(Player $player){
        if(RankAPI::isPremium($player)){
            $nuC = mt_rand(0, 2);
        }else{
            $nuC = mt_rand(0, 4);
        }

        if ($nuC == 1) {
            CoinsAPI::addCoins($player, 2);
            $player->sendPopup("§e+ 2");
        }
    }
}