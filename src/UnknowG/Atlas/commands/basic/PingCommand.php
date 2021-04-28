<?php

namespace UnknowG\Atlas\commands\basic;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\forms\LangForm;
use UnknowG\Atlas\utils\texts\Texts;

class PingCommand extends Command
{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if ($player instanceof Player) {
            Texts::sendMessage($player, Texts::$prefix, "Votre ping est de §3{$player->getPing()} ms", "Your ping is §3{$player->getPing()} ms");
        }
    }
}