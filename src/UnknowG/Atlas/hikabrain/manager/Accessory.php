<?php

namespace UnknowG\Atlas\hikabrain\manager;

use pocketmine\level\Level;
use UnknowG\Atlas\Atlas;

class Accessory
{
    private static $acc;

    public static function getUtils(): Accessory
    {
        if (is_null(self::$acc))
            self::$acc = new Accessory();
        return self::$acc;
    }

    public function getInfo(Level $level, string $infoToGet){
        $f = Atlas::getHikabrainFileData("gamesItems");
        return $f->get($level->getName())[$infoToGet];
    }

    public function setRedItem(Level $level, string $item){
        $file = Atlas::getHikabrainFileData("gamesItems");

        $array = [
            "redItem" => $item,
            "blueItem" => self::getUtils()->getInfo($level,"blueItem"),
            "redTime" => self::getUtils()->getInfo($level,"redTime"),
            "blueTime" => self::getUtils()->getInfo($level,"blueTime")
        ];

        $file->set($level->getName(), $array);
        $file->save();
    }

    public function setBlueItem(Level $level, string $item){
        $file = Atlas::getHikabrainFileData("gamesItems");

        $array = [
            "redItem" => self::getUtils()->getInfo($level,"redItem"),
            "blueItem" => $item,
            "redTime" => self::getUtils()->getInfo($level,"redTime"),
            "blueTime" => self::getUtils()->getInfo($level,"blueTime")
        ];

        $file->set($level->getName(), $array);
        $file->save();
    }

    public function setRedTime(Level $level, int $time){
        $file = Atlas::getHikabrainFileData("gamesItems");

        $array = [
            "redItem" => self::getUtils()->getInfo($level,"redItem"),
            "blueItem" => self::getUtils()->getInfo($level,"blueItem"),
            "redTime" => $time,
            "blueTime" => self::getUtils()->getInfo($level,"blueTime")
        ];

        $file->set($level->getName(), $array);
        $file->save();
    }

    public function setBlueTime(Level $level, int $time){
        $file = Atlas::getHikabrainFileData("gamesItems");

        $array = [
            "redItem" => self::getUtils()->getInfo($level,"redItem"),
            "blueItem" => self::getUtils()->getInfo($level,"blueItem"),
            "redTime" => self::getUtils()->getInfo($level,"redTime"),
            "blueTime" => $time
        ];

        $file->set($level->getName(), $array);
        $file->save();
    }
}