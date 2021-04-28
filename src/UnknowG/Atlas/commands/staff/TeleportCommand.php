<?php

namespace UnknowG\Atlas\commands\staff;

use DiscordWebhookAPI\Embed;
use DiscordWebhookAPI\Message;
use DiscordWebhookAPI\Webhook;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;

class TeleportCommand extends Command{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if($player instanceof Player){
            if(RankAPI::isStaff($player)){
                $pseudo = Server::getInstance()->getPlayer($args[0]);
                if($pseudo instanceof Player){
                    if(isset($args[1])){
                        $pseudo2 = Server::getInstance()->getPlayer($args[1]);
                        if($pseudo2 instanceof Player){
                            $pseudo->teleport(new Position($pseudo2->getX(),$pseudo2->getY(),$pseudo2->getZ(),$pseudo2->getLevel()));
                            Texts::sendMessage($player,Texts::$prefixStaff,"Vous avez téléporté §6{$pseudo->getName()} §7à §6{$pseudo2->getName()}","You've teleported §6{$pseudo->getName()} §7to §6{$pseudo2->getName()}.");
                        }else{
                            $player->sendMessage("Cette personne n'est pas connecté(e)");
                        }
                    }else{
                        $player->teleport(new Position($pseudo->getX(),$pseudo->getY(),$pseudo->getZ(),$pseudo->getLevel()));
                        Texts::sendMessage($player,Texts::$prefixStaff,"Vous vous êtes téléporté à §6{$pseudo->getName()}","You teleported to §6{$pseudo->getName()}.");
                    }
                }else{
                    $player->sendMessage("Cette personne n'est pas connecté(e)");
                }
            }else{
                $player->sendMessage(Texts::$prefixStaff . Texts::getText(SQLData::getLang($player),"Vous n'avez pas la permission","You don't have the permission"));
            }
        }else{
            $player->sendMessage(Texts::$prefixStaff . "Utilisez cette commande dans le jeu !");
        }
    }
}