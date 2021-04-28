<?php

namespace UnknowG\Atlas\task\stop;

use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\events\player\PlayerDeath;
use UnknowG\Atlas\events\player\PlayerJoin;
use UnknowG\Atlas\utils\texts\Texts;

class AnnounceStoppingTask extends Task
{
    private $plugin;

    public function __construct(Atlas $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onRun(int $currentTick)
    {
        foreach (Server::getInstance()->getOnlinePlayers() as $player) {
            Texts::sendMessage($player, Texts::$prefix, "Le serveur va redemarrer dans 30 minutes","The server's gonna reboot in 30 minutes.");
        }

        $this->plugin->getScheduler()->scheduleDelayedTask(new StoppingTask($this->plugin),20 * 1800);
    }
}