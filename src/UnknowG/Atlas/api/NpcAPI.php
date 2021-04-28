<?php

namespace UnknowG\Atlas\api;

use pocketmine\entity\Entity;
use pocketmine\entity\Human;
use pocketmine\Player;

class NpcAPI{
    public static function spawnNpc(Player $player, string $id, string $name){
        $nbt = Entity::createBaseNBT($player->asVector3());
        $nbt->setString($id, uniqid());
        $nbt->setTag($player->namedtag->getTag("Skin"));
        $human = new Human($player->getLevel(), $nbt);
        $human->setNameTagVisible(true);
        $human->setScale(1);
        $human->setHealth(70);
        $human->setMaxHealth(70);
        $human->setNameTag($name);
        $human->setRotation($player->getYaw(), $player->getPitch());
        $human->sendSkin();
        $human->spawnToAll();
    }
}