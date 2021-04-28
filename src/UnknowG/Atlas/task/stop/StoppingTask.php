<?php

namespace UnknowG\Atlas\task\stop;

use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\events\player\PlayerDeath;
use UnknowG\Atlas\events\player\PlayerJoin;
use UnknowG\Atlas\utils\texts\Texts;

class StoppingTask extends Task
{
    private $plugin;

    public function __construct(Atlas $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onRun(int $currentTick)
    {
        $this->plugin->getServer()->shutdown();
    }
}