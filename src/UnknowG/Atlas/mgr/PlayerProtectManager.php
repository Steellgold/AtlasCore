<?php

namespace UnknowG\Atlas\mgr;

use pocketmine\Server;
use pocketmine\Player;

class PlayerProtectManager{

    public static $infight = [];
    public static $checkfight = [];

    public static function isIn(Player $player){
        if(in_array($player->getName(),self::$infight)){
            return true;
        }else{
            return false;
        }
    }

    public static function getIn(Player $player){
        return self::$infight[$player->getName()];
    }

    public static function setIn(Player $player, Player $fdp){
        self::$infight[$player->getName()] = $fdp->getName();
        self::$infight[$fdp->getName()] = $player->getName();

        self::$checkfight[$player->getName()] =  ["time"=>10, "player"=>$fdp->getName()];
        self::$checkfight[$fdp->getName()] = ["time"=>10, "player"=>$fdp->getName()];
    }

    public static function setTime(Player $player, int $time){
        self::$checkfight[$player->getName()]["time"] = $time;
    }
       
    public static function delIn(Player $player){
        $vktm = self::$infight[$player->getName()];
        unset(self::$infight[$vktm]);
        unset(self::$infight[$player->getName()]);

        unset(self::$checkfight[$vktm]);
        unset(self::$checkfight[$player->getName()]);
    }
}