<?php

namespace UnknowG\Atlas\events\player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerExhaustEvent;

class PlayerExhaust implements Listener{
    public function onperdBouffeptdr(PlayerExhaustEvent $event){
        $event->setCancelled();
    }
}