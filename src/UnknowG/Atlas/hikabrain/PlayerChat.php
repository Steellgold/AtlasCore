<?php

namespace UnknowG\Atlas\hikabrain;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\Server;
use UnknowG\Atlas\hikabrain\manager\Game;
use UnknowG\Atlas\hikabrain\manager\Team;

class PlayerChat implements Listener
{
    public function onChat(PlayerChatEvent $event){
        $pn = $event->getPlayer()->getName();
        $p = $event->getPlayer();
        $msg = $event->getMessage();

        if(in_array($p->getLevel()->getName(),Game::$worlds)){
            foreach ($p->getLevel()->getPlayers() as $player){
                if(Team::getTeam()->getPlayerBlue($p->getLevel()) == $p->getName()){
                    $player->sendMessage("§7[§bBlue§7] §b$pn §7» §b$msg");
                }

                if(Team::getTeam()->getPlayerRed($p->getLevel()) == $p->getName()){
                    $player->sendMessage("§7[§cRed§7] §c$pn §7» §c$msg");
                }
            }
        }
    }
}