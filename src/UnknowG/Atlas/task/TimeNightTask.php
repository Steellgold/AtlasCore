<?php

namespace UnknowG\Atlas\task;

use pocketmine\scheduler\Task;
use pocketmine\Server;
use UnknowG\Atlas\Atlas;

class TimeNightTask extends Task
{
    private $plugin;

    public function __construct(Atlas $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onRun(int $currentTick)
    {
        foreach (Server::getInstance()->getLevels() as $level){
            $level->setTime(14000);
        }
    }
}