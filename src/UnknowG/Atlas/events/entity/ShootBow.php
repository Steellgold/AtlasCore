<?php

namespace UnknowG\Atlas\events\entity;

use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\Listener;
use UnknowG\Atlas\data\sql\SQLData;

class ShootBow implements Listener {
    public function playerShoot(EntityShootBowEvent $ev){
        $arrow = $ev->getProjectile();

        if ($arrow !== null and $arrow::NETWORK_ID == Entity::ARROW){
            $ev->setForce($ev->getForce() + SQLData::getServerData("shootArrowDamage"));
        }
    }
}