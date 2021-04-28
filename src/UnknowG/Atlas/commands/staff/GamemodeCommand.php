<?php

namespace UnknowG\Atlas\commands\staff;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\item\Item;
use pocketmine\Player;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\utils\texts\Texts;

class GamemodeCommand extends Command{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if($player instanceof Player){
            if(RankAPI::isStaff($player)){
                if(isset($args[0])){
                    switch ($args[0]){
                        case 0:
                            $player->setGamemode(0);
                            Texts::sendMessage($player,Texts::$prefixStaff,"Vous avez définie votre mode de jeu en §6Survie","You have set your game mode in §6Survival");
                            break;

                        case 1:
                            $player->setGamemode(1);
                            Texts::sendMessage($player,Texts::$prefixStaff,"Vous avez définie votre mode de jeu en §6Créatif","You have set your game mode in §6Creative");
                            break;

                        case 2:
                            $player->setGamemode(2);
                            Texts::sendMessage($player,Texts::$prefixStaff,"Vous avez définie votre mode de jeu en §6Aventure","You have set your game mode in §6Adventure");
                            break;

                        case 3:
                            $player->setGamemode(3);
                            Texts::sendMessage($player,Texts::$prefixStaff,"Vous avez définie votre mode de jeu en §6Spectateur","You have set your game mode in §6Spectator");
                            break;
                    }
                }else{
                    $player->setGamemode(0);
                    Texts::sendMessage($player,Texts::$prefixStaff,"Vous avez définie votre mode de jeu en §6Spectateur","You have set your game mode in §6Spectator");
                }
            }
        }
    }
}