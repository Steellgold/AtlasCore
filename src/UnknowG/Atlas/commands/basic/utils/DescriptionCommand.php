<?php

namespace UnknowG\Atlas\commands\basic\utils;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\forms\LeagueForm;
use UnknowG\Atlas\utils\texts\Texts;

class DescriptionCommand extends Command
{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if ($player instanceof Player) {
            if (isset($args[0])) {
                Texts::sendMessage($player, Texts::$prefix, "Vous avez modifié(e) votre description !", "You have changed your description");
                SQLData::setData($player, "players", "playerDesc", implode(" ",$args));
            }else{
                Texts::sendMessage($player, Texts::$prefix, "Vous avez oublié de définir la description", "You forgot to define the description");
            }
        }
    }
}