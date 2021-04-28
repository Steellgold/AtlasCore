<?php

namespace UnknowG\Atlas\task;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use UnknowG\Atlas\api\LeaguesAPI;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Unicodes;

class NameTagUpdateTask extends Task
{
    private $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function onRun(int $currentTick)
    {
        if (SQLData::getData($this->player, "isNick") == 1) {
            $this->player->setNameTag("§r§a" . "Unranked" . " §f" . SQLData::getData($this->player, "nickName"));
        } else {
            if($this->player->getName() == "ChromaYY9952" or $this->player->getName() == "ZarTreyk"){
                $this->player->setNameTag(RankAPI::getRank($this->player) . "\n§a" . LeaguesAPI::getLeague($this->player) . " §f" . $this->player->getName());
            }else{
                $this->player->setNameTag(RankAPI::getRank($this->player) . "\n§a" . LeaguesAPI::getLeague($this->player) . " §f" . $this->player->getName());
            }
        }
    }
}