<?php

namespace UnknowG\Atlas\hikabrain\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\hikabrain\manager\Game;
use UnknowG\Atlas\hikabrain\Texts;

class buildGame extends Command {
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player){
            $player = Server::getInstance()->getPlayer($args[0]);
            if($player instanceof Player){
                Game::getGame()->buildGame($sender->getLevel(),$sender,$player,5);
            }
        }
    }
}