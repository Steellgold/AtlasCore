<?php

namespace UnknowG\Atlas\events\player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDropItemEvent;

class PlayerDrop implements Listener{
    public function canDrop(PlayerDropItemEvent $event){
        $leveldeath = $event->getPlayer()->getLevel();
        if($leveldeath->getName() === "atlas"){
            $event->setCancelled();
        }
    }
}