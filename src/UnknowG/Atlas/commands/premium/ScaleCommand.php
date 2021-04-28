<?php

namespace UnknowG\Atlas\commands\premium;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\LeaguesAPI;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\forms\CoinsForm;
use UnknowG\Atlas\mgr\PlayerProtectManager;
use UnknowG\Atlas\task\NameTagUpdateTask;
use UnknowG\Atlas\utils\texts\Texts;

class ScaleCommand extends Command
{

    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if ($player instanceof Player) {
            if (RankAPI::isStaff($player) or RankAPI::isPremium($player)) {
                if(!PlayerProtectManager::isIn($player)){
                    if($player->getLevel() === Server::getInstance()->getLevelByName("atlas")){
                        if (isset($args[0])) {
                            if ($args[0] >= 0) {
                                if ($args[0] <= 5) {
                                    Texts::sendMessage($player, Texts::$prefixPrenium, "Vous avez définie votre taille en §g{$args[0]} block de hauteur", "You set your size in §g{$args[0]} height block");
                                    $player->setScale($args[0]);
                                } else {
                                    Texts::sendMessage($player, Texts::$prefixPrenium, "Merci d'entrer un nombre plus grand que 0 et plus petit que 6", "Please enter a number greater than 0 and less than 6");
                                }
                            } else {
                                Texts::sendMessage($player, Texts::$prefixPrenium, "Merci d'entrer un nombre plus grand que 0 et plus petit que 6", "Please enter a number greater than 0 and less than 6");
                            }
                        } else {
                            Texts::sendMessage($player, Texts::$prefixPrenium, "Vous avez oublié(e) de préciser la taille", "You forgot to specify the scale");
                        }
                    }else{
                        Texts::sendMessage($player, Texts::$prefixPrenium, "Cette commande est utilisable seulement dans le lobby", "This command can only be used in the lobby");
                    }
                }else{
                    Texts::sendMessage($player,Texts::$prefix,"Vous êtes en combat !","You are in now fight !");
                }
            } else {
                Texts::returnNotPermission($player);
            }
        }
    }
}