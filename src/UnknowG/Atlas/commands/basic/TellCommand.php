<?php

namespace UnknowG\Atlas\commands\basic;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;

class TellCommand extends Command
{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if ($player instanceof Player) {
            $sender = $player->getServer()->getPlayer(array_shift($args));
            if(isset($args[0])){
                if ($sender instanceof Player) {
                    $msg = implode(" ",$args);

                    Texts::sendDiscord2players($player,$sender->getName(),$msg);
                    Texts::sendMessage($sender, Texts::$prefix, "§3{$player->getName()} §7vous a envoyé(e) le message §l»§r§7 $msg", "sent you the message §l»§r§7 $msg");
                    Texts::sendMessage($player, Texts::$prefix, "Vous avez envoyé(e) à §3{$sender->getName()} §7le message §l»§r§7 $msg", "You have sent to §3{$sender->getName()} the message §l»§r§7 $msg");
                } else {
                    $player->sendMessage(Texts::getText(SQLData::getLang($player), Texts::$prefix . "Cette personne n'est pas connecté(e)", Texts::$prefix . "This person is not logged in"));
                }
            }else{
                $player->sendMessage(Texts::getText(SQLData::getLang($player), Texts::$prefix . "Vous avez oublié(e) le message", Texts::$prefix . "You have missed the message"));
            }
        }
    }
}