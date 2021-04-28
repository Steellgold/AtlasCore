<?php

namespace UnknowG\Atlas\commands\pets;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use UnknowG\Atlas\forms\pets\PetsForm;

class PetsCommand extends Command
{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        $this->setPermission("ee");
        parent::__construct($name, $description, $usageMessage, $aliases);
    }


    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if ($player instanceof Player) {
            PetsForm::open($player);
        }
    }
}