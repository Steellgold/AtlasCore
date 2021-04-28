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

class UnmuteCommand extends Command
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
                    $pseudo = Server::getInstance()->getPlayer($args[0]);
                    if($pseudo instanceof Player){
                        $conn = SQL::getDatabase();
                        $result = $conn->query("SELECT * FROM mutedPlayers WHERE playerName = '{$args[0]}'");

                        if ($result) {
                            if (mysqli_num_rows($result) > 0) {
                                $conn->query("DELETE FROM `mutedPlayers` WHERE playerName = '{$args[0]}'");
                                SQLData::killMute($pseudo);
                                $player->sendMessage(Texts::$prefix . "Vous avez supprimer la mise au silence de {$args[0]}");
                            } else {
                                $player->sendMessage(Texts::$prefix . "Cette personne n'est pas mise au silence");
                            }
                        } else {
                            echo 'ERROR unban';
                        }
                    }else{
                        $player->sendMessage(Texts::$prefix . "Cette personne n'est pas connecté(e)");
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