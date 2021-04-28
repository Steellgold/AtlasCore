<?php

namespace UnknowG\Atlas\events\player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\data\sql\SQLDataServer;
use UnknowG\Atlas\utils\texts\Texts;

class PlayerMove implements Listener
{
    public function onMove(PlayerMoveEvent $e)
    {
        $p = $e->getPlayer();
        if ($p->getY() <= 0) {
            PlayerDeath::tpLobbySpawn($p);
        }

        if ($p->getLevel()->getName() === "atlas") {
            $block = $p->getLevel()->getBlockAt($p->x, ($p->y - 0.1), $p->z);

            if ($block->getId() == 236 && $block->getDamage() == 12) {
                if (RankAPI::isAllowedPassDoor($p)) {
                    $p->addTitle(Texts::$prefix, "Welcome to the Special Room !\nOnly §cYouTuber§f, §gPremium §fand §6Staff\n§fhas access");
                    if ($p->isSneaking()) {
                        $p->setGamemode(0);
                    } else {
                        $p->setGamemode(1);
                    }
                } else {
                    if ($p->getName() == "Lyoxii") {
                        $p->teleport(new Position(-6,103,10, Server::getInstance()->getLevelByName("atlas")));
                        $p->addTitle(Texts::$prefix, "You don't have acces\nat the special room !");
                    } else {
                        PlayerDeath::tpLobbySpawn($p);
                        $p->addTitle(Texts::$prefix, "You don't have acces\nat the special room !");
                    }
                }
            } elseif ($block->getId() == 236 && $block->getDamage() == 7) {
                if (RankAPI::isAllowedPassDoor($p)) {
                    $p->addTitle(Texts::$prefix, "Welcome to the Discotheque !");
                }
            } elseif ($block->getId() == 236 && $block->getDamage() == 4) {
                if (RankAPI::isAllowedPassDoor($p)) {
                    if ($p->getName() == "Steellg0ld" or $p->getName() == "ChromaYY9952") {
                        $p->addTitle(Texts::$prefix, "Welcome to the Jackuzzi !");
                    } else {
                        $p->addTitle(Texts::$prefix, "You don't have acces\nat the Jackuzzi !");
                        PlayerDeath::tpLobbySpawn($p);
                    }
                }
            } elseif ($block->getId() == 236 && $block->getDamage() == 1) {
                if (RankAPI::isAllowedPassDoor($p)) {
                    $p->addTitle(Texts::$prefix, "Welcome to the Pool !");
                }
            }
        }
    }
}