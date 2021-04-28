<?php

namespace UnknowG\Atlas\hikabrain\manager;

use pocketmine\level\Level;
use UnknowG\Atlas\Atlas;

class Utils
{
    private static $utils;

    public static function getUtils(): Utils
    {
        if (is_null(self::$utils))
            self::$utils = new Utils();
        return self::$utils;
    }

    public function getInfo(Level $level, string $infoToGet){
        $f = Atlas::getHikabrainFileData("gamesPlaSco");
        return $f->get($level->getName())[$infoToGet];
    }

    public function addRedKill(Level $level, int $count){
        $file = Atlas::getHikabrainFileData("gamesPlaSco");

        $array = [
            "redKill" => self::getUtils()->getInfo($level, "redKill") + $count,
            "blueKill" => self::getUtils()->getInfo($level, "blueKill"),
            "redDeath" => self::getUtils()->getInfo($level, "redDeath"),
            "blueDeath" => self::getUtils()->getInfo($level, "blueDeath"),
            "redSerialKill" => self::getUtils()->getInfo($level, "redSerialKill"),
            "blueSerialKill" => self::getUtils()->getInfo($level, "blueSerialKill"),
            "emeraldBlue" => self::getUtils()->getInfo($level,"emeraldBlue"),
            "emeraldRed" => self::getUtils()->getInfo($level,"emeraldRed"),
        ];

        $file->set($level->getName(), $array);
        $file->save();
    }

    public function addRedDeath(Level $level, int $count){
        $file = Atlas::getHikabrainFileData("gamesPlaSco");

        $array = [
            "redKill" => self::getUtils()->getInfo($level, "redKill"),
            "blueKill" => self::getUtils()->getInfo($level, "blueKill"),
            "redDeath" => self::getUtils()->getInfo($level, "redDeath") + $count,
            "blueDeath" => self::getUtils()->getInfo($level, "blueDeath"),
            "redSerialKill" => self::getUtils()->getInfo($level, "redSerialKill"),
            "blueSerialKill" => self::getUtils()->getInfo($level, "blueSerialKill"),
            "emeraldBlue" => self::getUtils()->getInfo($level,"emeraldBlue"),
            "emeraldRed" => self::getUtils()->getInfo($level,"emeraldRed"),
        ];

        $file->set($level->getName(), $array);
        $file->save();
    }

    public function addBlueKill(Level $level, int $count){
        $file = Atlas::getHikabrainFileData("gamesPlaSco");

        $array = [
            "redKill" => self::getUtils()->getInfo($level, "redKill"),
            "blueKill" => self::getUtils()->getInfo($level, "blueKill") + $count,
            "redDeath" => self::getUtils()->getInfo($level, "redDeath"),
            "blueDeath" => self::getUtils()->getInfo($level, "blueDeath"),
            "redSerialKill" => self::getUtils()->getInfo($level, "redSerialKill"),
            "blueSerialKill" => self::getUtils()->getInfo($level, "blueSerialKill"),
            "emeraldBlue" => self::getUtils()->getInfo($level,"emeraldBlue"),
            "emeraldRed" => self::getUtils()->getInfo($level,"emeraldRed"),
        ];

        $file->set($level->getName(), $array);
        $file->save();
    }

    public function addBlueDeath(Level $level, int $count)
    {
        $file = Atlas::getHikabrainFileData("gamesPlaSco");

        $array = [
            "redKill" => self::getUtils()->getInfo($level, "redKill"),
            "blueKill" => self::getUtils()->getInfo($level, "blueKill"),
            "redDeath" => self::getUtils()->getInfo($level, "redDeath"),
            "blueDeath" => self::getUtils()->getInfo($level, "blueDeath") + $count,
            "redSerialKill" => self::getUtils()->getInfo($level, "redSerialKill"),
            "blueSerialKill" => self::getUtils()->getInfo($level, "blueSerialKill"),
            "emeraldBlue" => self::getUtils()->getInfo($level,"emeraldBlue"),
            "emeraldRed" => self::getUtils()->getInfo($level,"emeraldRed"),
        ];

        $file->set($level->getName(), $array);
        $file->save();
    }

    public function addSerialRedKill(Level $level, int $count){
        $file = Atlas::getHikabrainFileData("gamesPlaSco");

        $array = [
            "redKill" => self::getUtils()->getInfo($level,"redKill"),
            "blueKill" => self::getUtils()->getInfo($level,"blueKill"),
            "redDeath" => self::getUtils()->getInfo($level,"redDeath"),
            "blueDeath" => self::getUtils()->getInfo($level,"blueDeath"),
            "redSerialKill" => self::getUtils()->getInfo($level,"redSerialKill") + $count,
            "blueSerialKill" => self::getUtils()->getInfo($level,"blueSerialKill"),
            "emeraldBlue" => self::getUtils()->getInfo($level,"emeraldBlue"),
            "emeraldRed" => self::getUtils()->getInfo($level,"emeraldRed"),
        ];

        $file->set($level->getName(),$array);
        $file->save();
    }

    public function addSerialBlueKill(Level $level, int $count){
        $file = Atlas::getHikabrainFileData("gamesPlaSco");

        $array = [
            "redKill" => self::getUtils()->getInfo($level,"redKill"),
            "blueKill" => self::getUtils()->getInfo($level,"blueKill"),
            "redDeath" => self::getUtils()->getInfo($level,"redDeath"),
            "blueDeath" => self::getUtils()->getInfo($level,"blueDeath"),
            "redSerialKill" => self::getUtils()->getInfo($level,"blueSerialKill"),
            "blueSerialKill" => self::getUtils()->getInfo($level,"blueSerialKill") + $count,
            "emeraldBlue" => self::getUtils()->getInfo($level,"emeraldBlue"),
            "emeraldRed" => self::getUtils()->getInfo($level,"emeraldRed"),
        ];

        $file->set($level->getName(),$array);
        $file->save();
    }

    public function resetSerialRed(Level $level){
        $file = Atlas::getHikabrainFileData("gamesPlaSco");

        $array = [
            "redKill" => self::getUtils()->getInfo($level,"redKill"),
            "blueKill" => self::getUtils()->getInfo($level,"blueKill"),
            "redDeath" => self::getUtils()->getInfo($level,"redDeath"),
            "blueDeath" => self::getUtils()->getInfo($level,"blueDeath"),
            "redSerialKill" => 0,
            "blueSerialKill" => self::getUtils()->getInfo($level,"blueSerialKill"),
            "emeraldBlue" => self::getUtils()->getInfo($level,"emeraldBlue"),
            "emeraldRed" => self::getUtils()->getInfo($level,"emeraldRed"),
        ];

        $file->set($level->getName(),$array);
        $file->save();
    }

    public function resetSerialBlue(Level $level){
        $file = Atlas::getHikabrainFileData("gamesPlaSco");

        $array = [
            "redKill" => self::getUtils()->getInfo($level,"redKill"),
            "blueKill" => self::getUtils()->getInfo($level,"blueKill"),
            "redDeath" => self::getUtils()->getInfo($level,"redDeath"),
            "blueDeath" => self::getUtils()->getInfo($level,"blueDeath"),
            "redSerialKill" => self::getUtils()->getInfo($level,"redSerialKill"),
            "blueSerialKill" => 0,
            "emeraldBlue" => self::getUtils()->getInfo($level,"emeraldBlue"),
            "emeraldRed" => self::getUtils()->getInfo($level,"emeraldRed"),
        ];

        $file->set($level->getName(),$array);
        $file->save();
    }

    public function addEmeraldRed(Level $level, int $count){
        $file = Atlas::getHikabrainFileData("gamesPlaSco");

        $array = [
            "redKill" => self::getUtils()->getInfo($level, "redKill"),
            "blueKill" => self::getUtils()->getInfo($level, "blueKill"),
            "redDeath" => self::getUtils()->getInfo($level, "redDeath"),
            "blueDeath" => self::getUtils()->getInfo($level, "blueDeath"),
            "redSerialKill" => self::getUtils()->getInfo($level, "redSerialKill"),
            "blueSerialKill" => self::getUtils()->getInfo($level, "blueSerialKill"),
            "emeraldBlue" => self::getUtils()->getInfo($level,"emeraldBlue"),
            "emeraldRed" => self::getUtils()->getInfo($level,"emeraldRed") + $count,
        ];

        $file->set($level->getName(), $array);
        $file->save();
    }

    public function addEmeraldBlue(Level $level, int $count){
        $file = Atlas::getHikabrainFileData("gamesPlaSco");

        $array = [
            "redKill" => self::getUtils()->getInfo($level, "redKill"),
            "blueKill" => self::getUtils()->getInfo($level, "blueKill"),
            "redDeath" => self::getUtils()->getInfo($level, "redDeath"),
            "blueDeath" => self::getUtils()->getInfo($level, "blueDeath"),
            "redSerialKill" => self::getUtils()->getInfo($level, "redSerialKill"),
            "blueSerialKill" => self::getUtils()->getInfo($level, "blueSerialKill"),
            "emeraldBlue" => self::getUtils()->getInfo($level,"emeraldBlue") + $count,
            "emeraldRed" => self::getUtils()->getInfo($level,"emeraldRed"),
        ];

        $file->set($level->getName(), $array);
        $file->save();
    }

    public function delEmeraldRed(Level $level, int $count){
        $file = Atlas::getHikabrainFileData("gamesPlaSco");

        $array = [
            "redKill" => self::getUtils()->getInfo($level, "redKill"),
            "blueKill" => self::getUtils()->getInfo($level, "blueKill"),
            "redDeath" => self::getUtils()->getInfo($level, "redDeath"),
            "blueDeath" => self::getUtils()->getInfo($level, "blueDeath"),
            "redSerialKill" => self::getUtils()->getInfo($level, "redSerialKill"),
            "blueSerialKill" => self::getUtils()->getInfo($level, "blueSerialKill"),
            "emeraldBlue" => self::getUtils()->getInfo($level,"emeraldBlue"),
            "emeraldRed" => self::getUtils()->getInfo($level,"emeraldRed") - $count,
        ];

        $file->set($level->getName(), $array);
        $file->save();
    }

    public function delEmeraldBlue(Level $level, int $count){
        $file = Atlas::getHikabrainFileData("gamesPlaSco");

        $array = [
            "redKill" => self::getUtils()->getInfo($level, "redKill"),
            "blueKill" => self::getUtils()->getInfo($level, "blueKill"),
            "redDeath" => self::getUtils()->getInfo($level, "redDeath"),
            "blueDeath" => self::getUtils()->getInfo($level, "blueDeath"),
            "redSerialKill" => self::getUtils()->getInfo($level, "redSerialKill"),
            "blueSerialKill" => self::getUtils()->getInfo($level, "blueSerialKill"),
            "emeraldBlue" => self::getUtils()->getInfo($level,"emeraldBlue") - $count,
            "emeraldRed" => self::getUtils()->getInfo($level,"emeraldRed"),
        ];

        $file->set($level->getName(), $array);
        $file->save();
    }

    public function resetEmeraldRed(Level $level, int $count){
        $file = Atlas::getHikabrainFileData("gamesPlaSco");

        $array = [
            "redKill" => self::getUtils()->getInfo($level, "redKill"),
            "blueKill" => self::getUtils()->getInfo($level, "blueKill"),
            "redDeath" => self::getUtils()->getInfo($level, "redDeath"),
            "blueDeath" => self::getUtils()->getInfo($level, "blueDeath"),
            "redSerialKill" => self::getUtils()->getInfo($level, "redSerialKill"),
            "blueSerialKill" => self::getUtils()->getInfo($level, "blueSerialKill"),
            "emeraldBlue" => self::getUtils()->getInfo($level,"emeraldBlue"),
            "emeraldRed" => 0,
        ];

        $file->set($level->getName(), $array);
        $file->save();
    }

    public function resetEmeraldBlue(Level $level, int $count){
        $file = Atlas::getHikabrainFileData("gamesPlaSco");

        $array = [
            "redKill" => self::getUtils()->getInfo($level, "redKill"),
            "blueKill" => self::getUtils()->getInfo($level, "blueKill"),
            "redDeath" => self::getUtils()->getInfo($level, "redDeath"),
            "blueDeath" => self::getUtils()->getInfo($level, "blueDeath"),
            "redSerialKill" => self::getUtils()->getInfo($level, "redSerialKill"),
            "blueSerialKill" => self::getUtils()->getInfo($level, "blueSerialKill"),
            "emeraldBlue" => 0,
            "emeraldRed" => self::getUtils()->getInfo($level,"emeraldRed"),
        ];

        $file->set($level->getName(), $array);
        $file->save();
    }
}