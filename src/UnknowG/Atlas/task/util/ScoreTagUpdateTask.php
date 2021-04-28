<?php

namespace UnknowG\Atlas\task\util;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use UnknowG\Atlas\api\LeaguesAPI;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\Atlas;

class ScoreTagUpdateTask extends Task
{

    private $player;
    private $plugin;

    public function __construct(Player $player, Atlas $plugin)
    {
        $this->player = $player;
        $this->plugin = $plugin;
    }

    public function onRun(int $currentTick)
    {
        if ($this->player->getHealth() <= 5) {
            $this->player->setScoreTag("§4§l" . $this->player->getHealth() . " ❤");
        } elseif ($this->player->getHealth() <= 10) {
            $this->player->setScoreTag("§6" . $this->player->getHealth() . " ❤");
        } elseif ($this->player->getHealth() <= 15) {
            $this->player->setScoreTag("§2" . $this->player->getHealth() . " ❤");
        } elseif ($this->player->getHealth() <= 20) {
            $this->player->setScoreTag("§a" . $this->player->getHealth() . " ❤");
        } else {
            $this->player->setScoreTag("§a" . $this->player->getHealth() . " ❤");
        }
    }
}