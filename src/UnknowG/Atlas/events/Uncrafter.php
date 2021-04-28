<?php

namespace UnknowG\Atlas\events;

use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\Listener;

class Uncrafter implements Listener {
    public function onCraft(CraftItemEvent $event){
        foreach($event->getOutputs() as $item){
            if(($item->getId() === 266)) {
                $event->setCancelled(true);
                $player = $event->getPlayer();
            } else {

            }
        }
    }
}