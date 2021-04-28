<?php

namespace UnknowG\Atlas\events\player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Server;
use UnknowG\Atlas\api\LeaguesAPI;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\mgr\PlayerProtectManager as PPM;
use UnknowG\Atlas\utils\texts\Texts;

class PlayerQuit implements Listener
{
    public function onNewPreLoggingPlayer(PlayerQuitEvent $e)
    {
        $e->setQuitMessage("");

        $p = $e->getPlayer();
        Server::getInstance()->broadcastPopup("§4- §c{$p->getName()} §4-");
        SQLData::setData($p,"players","playerStatus",0);

        if (PPM::isIn($p)) {
            PPM::delIn($p);
        }

        /**
        $level = Server::getInstance()->getLevelByName("atlas");
        if (PPM::isIn($p)) {
            if ($p->getPing() <= 10) {
                Server::getInstance()->broadcastMessage(Texts::$prefix . "§3{$p->getName()} §7it's not decconected fight, his connection made his game booze, so made a disconnection.");
            } else {
                Server::getInstance()->broadcastMessage(Texts::$prefix . "§3{$p->getName()} §7has been banned for §3deco-combat §7for §31§7 days.");
                $time = time() + 60 * 60 * 2;
                SQL::registerBan($p->getName(), $time, "Deco Combat", 1, "SERVER");
            }
            PPM::delIn($p);
        }
         */
    }
}