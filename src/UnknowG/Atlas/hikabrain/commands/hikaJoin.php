<?php

namespace UnknowG\Atlas\hikabrain\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\hikabrain\manager\Game;
use UnknowG\Atlas\hikabrain\Texts;

class hikaJoin extends Command {
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player){
            $file = Atlas::getHikabrainFileData("games");

            if($file->exists($args[0])){
                $player1 = $file->get("waintingPlayer1");
                $player2 = $file->get("waintingPlayer2");
            }
        }
    }
}