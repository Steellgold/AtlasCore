<?php

namespace UnknowG\Atlas\commands\staff;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\task\staff\StaffHidePlayer;
use UnknowG\Atlas\utils\texts\Texts;

class VanishCommand extends Command{
    public $plugin;
    public function __construct(Atlas $plugin, string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        $this->plugin = $plugin;
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if($player instanceof Player){
            if(RankAPI::isStaff($player)){
                if($player->isInvisible()){
                    $player->setInvisible(false);
                }else{
                    $player->setInvisible(true);
                }
            }else{
                $player->sendMessage(Texts::$prefixStaff . Texts::getText(SQLData::getLang($player),"Vous n'avez pas la permission","You don't have the permission"));
            }
        }else{
            $player->sendMessage(Texts::$prefixStaff . "Utilisez cette commande dans le jeu !");
        }
    }
}