<?php

namespace UnknowG\Atlas\api;

use pocketmine\Player;
use UnknowG\Atlas\data\SQL;

class ParticlesAPI extends SQL {
    public static function setParticleStatus(Player $player, string $particleName, int $status){
        $db = SQL::getDatabase();
        $name = $player->getName();

        $db->query("UPDATE `playersParticles` SET `$particleName`='$status' WHERE playerName = '$name'");
    }

    public static function setParticleCounts(Player $player, int $status){
        $db = SQL::getDatabase();
        $name = $player->getName();

        $db->query("UPDATE `playersParticles` SET `partCounts`='$status' WHERE playerName = '$name'");
    }

    public static function getParticleStatus(Player $player, string $get){
        $db = SQL::getDatabase();
        $name = $player->getName();

        $data = mysqli_fetch_array($db->query("SELECT * FROM playersParticles WHERE playerName = '" . $name . "'"));
        return $data[$get];
    }

    public static function setParticleUsed(Player $player, string $particleName){
        $db = SQL::getDatabase();
        $name = $player->getName();

        $db->query("UPDATE `playersParticles` SET `particleUsed`='$particleName' WHERE playerName = '$name'");
    }
}