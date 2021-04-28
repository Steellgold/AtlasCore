<?php

namespace UnknowG\Atlas\commands\capes;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use UnknowG\Atlas\forms\capes\CapesForm;

class CapesCommand extends Command
{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if ($player instanceof Player) {
            CapesForm::open($player);
        }
    }
}