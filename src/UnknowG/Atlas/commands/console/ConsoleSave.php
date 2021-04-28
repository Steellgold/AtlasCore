<?php

namespace UnknowG\Atlas\commands\console;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\CoinsAPI;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;
use UnknowG\Atlas\utils\texts\Unicodes;

class ConsoleSave extends Command
{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if(!$player instanceof Player){
            foreach (Server::getInstance()->getLevels() as $level){
                $level->save(true);
                $level->setAutoSave(true);
                $player->sendMessage($level->getName() . " saved !");
            }
        }
    }
}