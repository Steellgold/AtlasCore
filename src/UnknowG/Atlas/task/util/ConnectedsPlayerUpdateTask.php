<?php


namespace UnknowG\Atlas\task\util;


use pocketmine\Player;
use pocketmine\scheduler\Task;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\sql\SQLDataServer;

class ConnectedsPlayerUpdateTask extends Task
{
    public function onRun(int $currentTick)
    {
        SQLDataServer::setConnecteds(count(Atlas::getInstance()->getServer()->getOnlinePlayers()));
    }
}