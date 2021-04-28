<?php

namespace UnknowG\Atlas\task;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\events\player\PlayerDeath;
use UnknowG\Atlas\events\player\PlayerJoin;
use UnknowG\Atlas\events\player\PlayerUse;

class AtlasLobbyPlayers extends Task{
    public function onRun(int $currentTick)
    {
        foreach (Server::getInstance()->getLevelByName("atlas")->getPlayers() as $player){
            if(!RankAPI::getIDRank($player) == "admin" or !RankAPI::getIDRank($player) == "fonda"){
                $player->getInventory()->setContents([]);
                $player->getArmorInventory()->setContents([]);
                PlayerJoin::giveCompass($player);
            }
        }
    }
}