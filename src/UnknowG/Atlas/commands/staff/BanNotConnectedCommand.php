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
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;

class BanNotConnectedCommand extends Command
{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if ($player instanceof Player) {
            if (RankAPI::isStaff($player)) {
                if (is_numeric($args[2])) {
                    if(!isset($args[0]) || !isset($args[1]) || !isset($args[2])){
                        return true;
                    }

                    $moderator = $player->getName();

                    $web = new Webhook("https://canary.discordapp.com/api/webhooks/713009546897129564/Lr5jPmnbq8Mk1qxyj7glRRGLx9OBGuvtQgtNBBGgkVQDU09XizW8pajvyJQHYJVBOwQx");
                    $embed = new Embed();
                    $msg = new Message();

                    $embed->setTitle("[:no_entry:] Banissement sur une personne non connecté(e)");
                    $embed->setDescription("**" . $args[0] . "** a été banni(e) pour **" . $args[1] . "** par **$moderator** pendant **" . $args[2] . " jours**");
                    $embed->setFooter("rv-shock.net - 19133");
                    $msg->addEmbed($embed);
                    $web->send($msg);

                    $time = time() + 60 * 60 * 24 * $args[2];
                    SQL::registerBan($args[0], $time, $args[1], $args[2],$moderator);
                    $player->sendMessage("Cette personne a été banni(e)");
                    Server::getInstance()->broadcastMessage(Texts::$prefix . "§3{$args[0]} §7has been banned from Atlas Pvp for §3{$args[1]} §7fwhile {$args[2]} days");
                } else {
                    $player->sendMessage("Utilisez des chiffres !");
                }
            } else {
                $player->sendMessage(Texts::$prefix . Texts::getText(SQLData::getLang($player), "Vous n'avez pas la permission", "You don't have the permission"));
            }
        } else {
            $player->sendMessage(Texts::$prefix . "Utilisez cette commande dans le jeu !");
        }
    }
}