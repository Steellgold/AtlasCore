<?php

namespace UnknowG\Atlas\commands\staff\manager;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\CoinsAPI;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;

class CoinsCommand extends Command
{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if ($player instanceof Player) {
            if (RankAPI::isManager($player)) {
                if (isset($args[0])) {
                    if (isset($args[1])) {
                        if (in_array($args[1],["add", "del", "set"])) {
                            if (isset($args[2])) {
                                switch ($args[1]) {
                                    case "add":
                                        CoinsAPI::addOffCoins($args[0],$args[2]);
                                        $player->sendMessage(Texts::$prefixStaff . "Vous avez ajouté(e) §6{$args[2]} §7coins au joueur §6{$args[0]}");
                                        break;
                                    case "del":
                                        CoinsAPI::delOffCoins($args[0],$args[2]);
                                        $player->sendMessage(Texts::$prefixStaff . "Vous avez retiré(e) §6{$args[2]} §7coins au joueur §6{$args[0]}");
                                        break;
                                    case "set":
                                        CoinsAPI::setOffCoins($args[0],$args[2]);
                                        $player->sendMessage(Texts::$prefixStaff . "Vous avez définie §6{$args[2]} §7coins au joueur §6{$args[0]}");
                                        break;
                                }
                            } else {
                                $player->sendMessage(Texts::$prefixStaff . "Vous avez oublié l'argument §6coinsCount §7en position 2");
                            }
                        } else {
                            $player->sendMessage(Texts::$prefixStaff . "Une erreur c'est produite, voici les types disponibles: §6add§7, §6del§7, §6set");
                        }
                    } else {
                        $player->sendMessage(Texts::$prefixStaff . "Vous avez oublié l'argument §6type §7en position 1");
                    }
                } else {
                    $player->sendMessage(Texts::$prefixStaff . "Vous avez oublié l'argument §6pseudo §7en position 0");
                }
            } else {
                Texts::returnNotPermission($player);
            }
        }
    }
}