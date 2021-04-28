<?php

namespace UnknowG\Atlas\commands\youtube;

use Exception;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\LibSkin;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\utils\texts\Texts;

class SkinCommand extends Command
{

    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if ($player instanceof Player) {
            if (RankAPI::isYtb($player) or RankAPI::isStaff($player) or RankAPI::isPremium($player)) {
                if (isset($args[0])) {
                    $pseudo = Server::getInstance()->getPlayer($args[0]);
                    if ($pseudo instanceof Player) {
                        Texts::sendMessage($player, Texts::$prefixYtb, "Vous avez pris le skin de §c{$pseudo->getName()}", "You have taken the skin as §c{$pseudo->getName()}");

                        $player->setSkin($pseudo->getSkin());
                        $player->sendSkin();
                        $player->spawnToAll();
                    } else {
                        Texts::sendMessage($player, Texts::$prefix, "Cette personne n'est pas connecté(e)", "Player is not online");
                    }
                } else {
                    Texts::sendMessage($player, Texts::$prefix, "Vous avez oublié(e) de préciser le pseudo", "You forgot to specify the nickname");
                }
            } else {
                Texts::returnNotPermission($player);
            }
        }
    }
}