<?php

namespace UnknowG\Atlas\events\player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerRespawnEvent;

class PlayerRespawn implements Listener{
    public function onRespawn(PlayerRespawnEvent $event){
        $player = $event->getPlayer();


        /** Remove all inventory */
        $player->getArmorInventory()->setContents([]);
        $player->getInventory()->clearAll();

        PlayerDeath::tpLobbySpawn($player);
        PlayerJoin::giveCompass($player);



    }
}