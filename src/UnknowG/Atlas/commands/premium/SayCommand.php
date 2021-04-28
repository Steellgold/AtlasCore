<?php

namespace UnknowG\Atlas\commands\premium;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\forms\LangForm;
use UnknowG\Atlas\forms\staff\HomePageForm;
use UnknowG\Atlas\utils\texts\Texts;

class SayCommand extends Command{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if($player instanceof Player){
            if(RankAPI::isPremium($player)){
                if(isset($args[0])){
                    if(RankAPI::isStaff($player)){
                        Server::getInstance()->broadcastMessage(Texts::$prefix . implode(" ",$args));
                    }else{
                        Server::getInstance()->broadcastMessage("§c(§l{$player->getName()}§r§c) §7" . implode(" ",$args));
                    }
                }else{
                    Texts::sendMessage($player,Texts::$prefix,"Vous avez oublié d'entrer le texte que vous shouaitez envoyé","You forgot to enter the text you shouted you sent");
                }
            }else{
                Texts::sendMessage($player,Texts::$prefixPrenium,"Vous n'avez pas accès à cette commande","You don't have access to this command !");
            }
        }
    }
}