<?php

namespace UnknowG\Atlas\commands\console;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\CoinsAPI;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;
use UnknowG\Atlas\utils\texts\Unicodes;

class ConsoleReward extends Command
{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if (!$player instanceof Player) {
            if (isset($args[0])) {
                $playerName = Server::getInstance()->getPlayer($args[0]);

                if (isset($args[1])) {
                    $typeBuy = $args[1];

                    switch ($typeBuy) {
                        case "rank":
                            SQLData::setData($playerName,"players","playerRank","prenium");
                            SQLData::setData($playerName,"players","showRank",1);
                            Server::getInstance()->broadcastMessage(Texts::$prefixShop . "Thank to §5{$playerName->getName()} §7to have buy a §5Premium §7rank on our shop, if you also want to be premium, go to §5https://shop.atlas-mc.fr §7!");
                            break;
                        case "coins":
                            CoinsAPI::addCoins($playerName,$args[2]);
                            $uni = Unicodes::$coin;
                            Server::getInstance()->broadcastMessage(Texts::$prefixShop . "Thank to §5{$playerName->getName()} §7to have buy §5{$args[2]}{$uni} §7on our shop, if you also want to be have {$uni}, go to §5https://shop.atlas-mc.fr §7!");
                            break;
                        case "keys":
                            $kP = SQLData::getData($playerName,"playerKeyCountsPrenium");
                            $to = $kP + $args[2];
                            SQLData::setData($playerName,"players","playerKeyCountsPrenium",$to);
                            Server::getInstance()->broadcastMessage(Texts::$prefixShop . "Thank to §5{$playerName->getName()} §7to have buy §5{$args[2]} §7keys §5premium §7on our shop, if you also want to have other box keys than the vote or the pvp box, go to §5https://shop.atlas-mc.fr §7!");
                            break;
                    }
                }
            }
        }
    }
}