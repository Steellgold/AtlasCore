<?php

namespace UnknowG\Atlas\task\util\texts;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;

class DiscordTextTask extends Task{
    private $plugin;
    public function __construct(Atlas $atlas)
    {
        $this->plugin = $atlas;
    }

    public function onRun(int $currentTick)
    {
        foreach (Server::getInstance()->getOnlinePlayers() as $player) {
            if (SQLData::getLang($player) == "fr") {
                $player->sendMessage(Texts::$prefix . "Tu peut venir discuter avec nous sur notre discord avec ce lien !\n§7§l> §r§7discord.gg/XVcEvqf");
            }else{
                $player->sendMessage(Texts::$prefix . "You can come chat with us on our discord with this link !\n§7§l> §r§7discord.gg/XVcEvqf");
            }
        }

        $this->plugin->getScheduler()->scheduleDelayedTask(new RulesTextTask($this->plugin), 20 * 300);
    }
}