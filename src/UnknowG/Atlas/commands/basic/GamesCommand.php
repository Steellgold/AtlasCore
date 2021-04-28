<?php

namespace UnknowG\Atlas\commands\basic;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\forms\utils\GamesForm;
use UnknowG\Atlas\mgr\PlayerProtectManager;
use UnknowG\Atlas\utils\texts\Texts;

class GamesCommand extends Command{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if($player instanceof Player){

            if(!PlayerProtectManager::isIn($player)) {
                GamesForm::open($player);
            }else{
                Texts::sendMessage($player,Texts::$prefix,"Vous êtes en combat !","You are in now fight !");
            }
        }
    }
}