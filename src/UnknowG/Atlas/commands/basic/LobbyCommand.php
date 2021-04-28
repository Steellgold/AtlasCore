<?php

namespace UnknowG\Atlas\commands\basic;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use UnknowG\Atlas\events\player\PlayerDeath;
use UnknowG\Atlas\events\player\PlayerJoin;
use UnknowG\Atlas\mgr\PlayerProtectManager as PPM;
use UnknowG\Atlas\utils\texts\Texts;

class LobbyCommand extends Command
{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if ($player instanceof Player) {
            if(!PPM::isIn($player)){
                PlayerDeath::tpLobbySpawn($player);

                if(PPM::isIn($player)){
                    PPM::delIn($player);
                }

                $player->setImmobile(false);

                $player->getInventory()->clearAll();
                $player->getArmorInventory()->setContents([]);
                $player->removeAllEffects();
                PlayerJoin::giveCompass($player);
            }else{
                Texts::sendMessage($player,Texts::$prefix,"Vous êtes en combat !","You are in now fight !");
            }
        }
    }
}