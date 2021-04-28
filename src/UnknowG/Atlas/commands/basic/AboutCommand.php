<?php

namespace UnknowG\Atlas\commands\basic;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\forms\LangForm;
use UnknowG\Atlas\utils\texts\Texts;

class AboutCommand extends Command
{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if ($player instanceof Player) {
            Texts::sendMessage($player, Texts::$prefix, "Ce serveur éxécute §3PocketMine-MP §7avec des modifications faite par l'équipe de développement du serveur §3Atlas", "This server runs §3PocketMine-MP §7 with modifications made by the §3Atlas server development team.");
        }
    }
}