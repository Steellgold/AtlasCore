<?php

namespace UnknowG\Atlas\task;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\events\player\PlayerDeath;
use UnknowG\Atlas\events\player\PlayerJoin;
use UnknowG\Atlas\events\player\PlayerUse;

class StickTpTask extends Task{
    public $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function onRun(int $currentTick)
    {

        PlayerUse::showPlayers($this->player);
        if(SQLData::getData($this->player,"flyLobby") == 1){
            $this->player->setAllowFlight(true);
            $this->player->setFlying(true);
        }else{
            $this->player->setAllowFlight(false);
            $this->player->setFlying(false);
        }

        $this->player->setImmobile(false);
        $this->player->getInventory()->clearAll();
        $this->player->removeAllEffects();
        $this->player->getArmorInventory()->setContents([]);
        PlayerJoin::giveCompass($this->player);
        PlayerDeath::tpLobbySpawn($this->player);
    }
}