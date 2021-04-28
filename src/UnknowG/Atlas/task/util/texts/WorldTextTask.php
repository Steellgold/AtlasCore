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
use UnknowG\Atlas\utils\texts\Texts;

class WorldTextTask extends Task{
    private $player;
    private $message;
    private $id;

    public function __construct(Player $player, string $message, int $id)
    {
        $this->player = $player;
        $this->message = $message;
        $this->id = $id;
    }

    public function onRun(int $currentTick)
    {

        $w1n = Server::getInstance()->getLevelByName("train1");
        $w2n = Server::getInstance()->getLevelByName("train2");
        $w3n = Server::getInstance()->getLevelByName("train3");
        $w4n = Server::getInstance()->getLevelByName("train4");
        $w5n = Server::getInstance()->getLevelByName("train5");

        $this->player->sendMessage($this->message);

        if($this->id == 1){
            $this->player->teleport(new Position(265,4,256,$w1n));
        }elseif($this->id == 2){
            $this->player->teleport(new Position(265,4,256,$w2n));
        }elseif($this->id == 3){
            $this->player->teleport(new Position(265,4,256,$w3n));
        }elseif($this->id == 4){
            $this->player->teleport(new Position(265,4,256,$w4n));
        }elseif($this->id == 5){
            $this->player->teleport(new Position(265,4,256,$w5n));
        }elseif($this->id == 6){

        }

    }
}