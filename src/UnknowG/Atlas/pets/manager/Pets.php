<?php

namespace UnknowG\Atlas\pets\manager;

use pocketmine\Player;
use UnknowG\Atlas\pets\task\PetsTask;

class Pets
{

    public static $pets = [
        "petSkeleton" => 34,
        "petZombie" => 32,
        "petCat" => 75,
        "petHorse" => 23,
        "petGuardian" => 49,
        "petTurtle" => 74,
        "petSpider" => 35,
        "petPhantom" => 58,
        "petTnt" => 65,
        "petWither" => 52,
        "petFireball" => 79,
        "petMinecart" => 84,
        "petCamera" => 62,
        "petPanda" => 113,
        "petHooper" => 96,
        "petRabbit" => 18,
        "petDolphin" => 31,
        "petPig" => 12,
        "petParrot" => 30,
        "petMoos" => 16,
        "petSnowgolem" => 21,
        "petIronGolem" => 20,
        "petFox" => 121,
        "petEndermite" => 55
    ];

    public static function isBig(Player $player){
        $array = PetsTask::$petsBigPlayer;

         foreach ($array as $i){
            if(PetsSession::getPetsPlayerName($player) == $i){
                PetsSession::removePets($player);
            }
        }
    }
}