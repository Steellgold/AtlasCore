<?php

namespace UnknowG\Atlas\commands\staff;

use DiscordWebhookAPI\Embed;
use DiscordWebhookAPI\Message;
use DiscordWebhookAPI\Webhook;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;

class KickCommand extends Command{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if($player instanceof Player){
            if(RankAPI::isMStaff($player)){
                if(!isset($args[0]) || !isset($args[1])){
                    return true;
                }

                $pseudo = Server::getInstance()->getPlayer($args[0]);
                if($pseudo instanceof Player){
                    $moderator = $player->getName();

                    $web = new Webhook("https://canary.discordapp.com/api/webhooks/713009546897129564/Lr5jPmnbq8Mk1qxyj7glRRGLx9OBGuvtQgtNBBGgkVQDU09XizW8pajvyJQHYJVBOwQx");
                    $embed = new Embed();
                    $msg = new Message();

                    $embed->setTitle("[:incoming_envelope:] Expulsion");
                    $embed->setDescription("**". $pseudo->getName() . "** a été expulsé(e) pour **" . $args[1] . "** par **$moderator**");
                    $embed->setFooter("rv-shock.net - 19133");
                    $msg->addEmbed($embed);
                    $web->send($msg);

                    $player->sendMessage("Cette personne a été expulser");
                    Server::getInstance()->broadcastMessage(Texts::$prefix . "§3{$pseudo->getName()} §7has been kicked from Atlas Pvp for §3{$args[1]}");
                    $pseudo->close("","§cYou have been kicked from Atlas Pvp\n§fFor: {$args[1]}");
                }else{
                    $player->sendMessage("Cette personne n'est pas connecté(e)");
                }
            }else{
                $player->sendMessage(Texts::$prefix . Texts::getText(SQLData::getLang($player),"Vous n'avez pas la permission","You don't have the permission"));
            }
        }else{
            $player->sendMessage(Texts::$prefix . "Utilisez cette commande dans le jeu !");
        }
    }
}