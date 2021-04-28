<?php

namespace UnknowG\Atlas\commands\youtube;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\LeaguesAPI;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\forms\CoinsForm;
use UnknowG\Atlas\task\NameTagUpdateTask;
use UnknowG\Atlas\utils\texts\Texts;

class NickCommand extends Command
{

    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if ($player instanceof Player) {
            if (RankAPI::isYtb($player) or RankAPI::isStaff($player)) {
                if (isset($args[0])) {
                    if ($args[0] == $player->getName()) {
                        SQLData::setData($player, "players", "isNick", 0);
                        Texts::sendMessage($player, Texts::$prefixYtb, "Vous n'êtes plus un fantôme", "You're not a ghost anymore.");
                        $player->setNameTag("§a" . LeaguesAPI::getLeague($player) . " §f" . $player->getName());
                    } else {
                        if(strlen($args[0]) <= 15){
                            $pseudo = Server::getInstance()->getPlayer($args[0]);
                            if (!$pseudo instanceof Player) {
                                SQLData::setData($player, "players", "isNick", 1);
                                SQLData::setData($player, "players", "nickName", $args[0]);

                                SQLData::setData($player, "players", "fakeRole","player");

                                Texts::sendMessage($player, Texts::$prefixYtb, "Vous avez définie votre pseudo sur §c{$args[0]}", "You have set your nametag as §c{$args[0]}");
                                $player->setNameTag("§a" . "Unranked" . " §f" . SQLData::getData($player, "nickName"));
                            } else {
                                Texts::sendMessage($player, Texts::$prefixYtb, "Cette personne est connecté(e)", "This player is online");
                            }
                        }else{
                            Texts::sendMessage($player, Texts::$prefixYtb, "Ce pseudo est trop long merci de limiter le pseudo à 15 caractères", "This nickname is too long please limit the nickname to 15 characters.");
                        }
                    }
                } else {
                    Texts::sendMessage($player, Texts::$prefixYtb, "Vous avez oublié(e) de préciser le pseudo", "You forgot to specify the nickname");
                }
            } else {
                Texts::returnNotPermission($player);
            }
        }
    }
}