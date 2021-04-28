<?php

namespace UnknowG\Atlas\task\util\texts;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;

class RulesTextTask extends Task{
    private $plugin;
    public function __construct(Atlas $atlas)
    {
        $this->plugin = $atlas;
    }

    public function onRun(int $currentTick)
    {
        foreach (Server::getInstance()->getOnlinePlayers() as $player) {
            if (SQLData::getLang($player) == "fr") {
                $player->sendMessage(Texts::$prefix . "N'oublie pas de respecter le reglement, utilisez la commande §3/rules §7pour le lire !");
            }else{
                $player->sendMessage(Texts::$prefix . "Don't forget to respect the regulation\n§7Use the command §3/rules §7 to read it!");
            }
        }

        $this->plugin->getScheduler()->scheduleDelayedTask(new DiscordTextTask($this->plugin), 20 * 300);
    }
}