<?php

namespace UnknowG\Atlas\commands\basic\utils;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\TranslationContainer;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;

class ListCommand extends Command
{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player) {
            $playerNames = array_map(function (Player $player): string {
                return $player->getName();
            }, array_filter($sender->getServer()->getOnlinePlayers(), function (Player $player) use ($sender) : bool {
                return $player->isOnline() and (!($sender instanceof Player) or $sender->canSee($player));
            }));

            $pC = count(Server::getInstance()->getOnlinePlayers());

            Texts::sendMessage($sender, Texts::$prefix, "Nous sommes actuellement §3$pC §7joueur(s) connecté(e)(s) sur le serveur !", "We are currently §3$pC §7players connected on the server!");
            $sender->sendMessage("§l§7» §r§7" . implode("§3, §7", $playerNames));
        }else{
            $pC = count(Server::getInstance()->getOnlinePlayers());
            echo "Il y a $pC joueurs connectées sur le serveur";
        }
    }
}