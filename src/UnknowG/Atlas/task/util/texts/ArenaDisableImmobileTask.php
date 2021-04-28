<?php

namespace UnknowG\Atlas\task\util\texts;

use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\events\player\PlayerDeath;
use UnknowG\Atlas\events\player\PlayerJoin;
use UnknowG\Atlas\utils\RespawnUtil;
use UnknowG\Atlas\utils\texts\Texts;

class ArenaDisableImmobileTask extends Task{
    private $player;
    private $worldname;

    public function __construct(Player $player, string $worldname)
    {
        $this->player = $player;
        $this->worldname = $worldname;
    }

    public function onRun(int $currentTick)
    {
        foreach (Server::getInstance()->getLevelByName($this->worldname)->getPlayers() as $players){
            $playersCount = count(Server::getInstance()->getLevelByName($this->worldname)->getPlayers());
            if($playersCount >= 2){
                Texts::sendMessage($players,Texts::$prefix,"Bonne chance !","Good Luck !");
                $players->setImmobile(false);
                $players->getInventory()->setContents([]);
                $players->getArmorInventory()->setContents([]);
                RespawnUtil::giveGappleKit($players);
            }else{
                Texts::sendTip($players,"En attente d'autre joueurs","Waiting for other players");
                $players->setImmobile(true);
            }
        }
    }
}