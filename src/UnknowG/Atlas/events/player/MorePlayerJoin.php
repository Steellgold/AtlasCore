<?php

namespace UnknowG\Atlas\events\player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\Server;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\forms\LangForm;

class MorePlayerJoin implements Listener
{
    public function morePlayers(PlayerPreLoginEvent $e)
    {
        $p = $e->getPlayer();

        if (count(Server::getInstance()->getOnlinePlayers()) >= 50) {
            if (!SQL::getData($p, "playerRank") == "fonda") {
                if (!SQL::getData($p, "playerRank") == "staff") {
                    if (!SQL::getData($p, "playerRank") == "ytb") {
                        if (!SQL::getData($p, "playerSubRank") == "prenium") {
                            if (!SQL::getData($p, "playerRank") == "prenium") {
                                $p->close("", "§cServer is Full\n§7For join the server on this full, buy a §gPremium §7rank");
                            }
                        }
                    }
                }
            }
        }
    }
}