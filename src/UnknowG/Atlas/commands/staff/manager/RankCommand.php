<?php

namespace UnknowG\Atlas\commands\staff\manager;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;

class RankCommand extends Command {
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if($player instanceof Player){
            if(RankAPI::isManager($player)){
                if(isset($args[0])){
                    if(isset($args[1])){
                        if(in_array($args[1],RankAPI::$ranks)){
                            RankAPI::setRankOff($args[0],$args[1]);
                            $player->sendMessage(Texts::$prefixStaff . "Vous avez attribué le grade §6{$args[1]} §7à §6{$args[0]}");
                            Server::getInstance()->broadcastMessage("§7[§6!!§7] {$args[0]} has been ranked to §6{$args[1]}");
                        }else{
                            $player->sendMessage(Texts::$prefixStaff . "Une erreur c'est produite, les grades qui sont disponibles sont: §6fonda§7, §6admin§7, §6staff§7, §6support§7, §6ytb§7, §6prenium§7, §6player");
                        }
                    }else{
                        $player->sendMessage(Texts::$prefixStaff . "Vous avez oublié l'argument §6grade §7en position 1");
                    }
                }else{
                    $player->sendMessage(Texts::$prefixStaff . "Vous avez oublié l'argument §6pseudo §7en position 0");
                }
            }else{
                Texts::returnNotPermission($player);
            }
        }
    }
}