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

class UnbanCommand extends Command
{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if ($player instanceof Player) {
            if (RankAPI::isStaff($player)) {
                if (isset($args[0])) {
                    if (isset($args[1])) {

                        $conn = SQL::getDatabase();
                        $result = $conn->query("SELECT * FROM bannedPlayers WHERE playerName = '{$args[0]}'");

                        if ($result) {
                            if (mysqli_num_rows($result) > 0) {
                                $conn->query("DELETE FROM `bannedPlayers` WHERE playerName = '{$args[0]}'");
                                $player->sendMessage(Texts::$prefix . "Vous avez supprimer le banissement de §3{$args[0]}");

                                $web = new Webhook("https://canary.discordapp.com/api/webhooks/716436216840716348/e7_1Ep5xexQthP4JQl5cTZjOMRT_skolyoK8LFEQ_DBlqjg-3od6h8DaSwMgOOfDwR6q");
                                $embed = new Embed();
                                $msg = new Message();

                                $embed->setTitle("[:unlock:] Débanissement");
                                $embed->setDescription("**" . $args[0] . "** a été débanni(e) pour **" . $args[1] . "** par **{$player->getName()}**");
                                $embed->setFooter("rv-shock.net - 19133");
                                $msg->addEmbed($embed);
                                $web->send($msg);
                            } else {
                                $player->sendMessage(Texts::$prefix . "Cette personne n'est pas banni(e)");
                            }
                        } else {
                            echo 'ERROR unban';
                        }
                    } else {
                        $player->sendMessage(Texts::$prefix . "Vous avez oublié l'argument : §3raison");
                    }
                } else {
                    $player->sendMessage(Texts::$prefix . "Vous avez oublié l'argument : §3pseudo");
                }
            } else {
                Texts::sendMessage($player, Texts::$prefix, "Vous n'avez pas la permission", "You don't have the permission");
            }
        } else {
            $player->sendMessage(Texts::$prefix . "Utilisez cette commande dans le jeu !");
        }
    }
}