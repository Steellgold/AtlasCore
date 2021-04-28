<?php

namespace UnknowG\Atlas\events\player;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\mgr\PlayerProtectManager as PPM;

class PlayerTap implements Listener
{
    public function onDamage(EntityDamageByEntityEvent $ev)
    {
        $player = $ev->getEntity();
        $fdp = $ev->getDamager();

        $levels = [
            "stick",

            "train1",
            "train2",
            "train3",
            "train4",
            "train5",
            "arena1",
            "arena2",
            "arena3",
            "arena4",
            "arena5",
            "atlas",
            "bow",
            "sumo",
            "gravity",
            "ninja",

            "hika1",
            "hika2",
            "hika3",
            "hika4",
        ];

        if (in_array($player->getLevel()->getName(), $levels)) {

        } else {
            if ($player instanceof Player && $fdp instanceof Player) {
                if (PPM::isIn($player)) {
                    if (PPM::getIn($player) === $fdp->getName()) {
                        PPM::setIn($player, $fdp);
                    } else {
                        $ev->setCancelled();
                    }
                } elseif (PPM::isIn($fdp)) {
                    if (PPM::getIn($fdp) === $player->getName()) {
                        PPM::setIn($player, $fdp);
                    } else {
                        $ev->setCancelled();
                    }
                } else {
                    PPM::setIn($player, $fdp);
                }
            }
        }

        $ev->setKnockBack(0.42);
    }
}