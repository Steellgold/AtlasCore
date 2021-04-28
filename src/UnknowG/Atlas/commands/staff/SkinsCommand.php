<?php

namespace UnknowG\Atlas\commands\staff;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Skin;
use pocketmine\Player;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\forms\LangForm;
use UnknowG\Atlas\forms\staff\HomePageForm;
use UnknowG\Atlas\utils\texts\Texts;

class SkinsCommand extends Command{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if($player instanceof Player){
            if(RankAPI::isStaff($player)){
                $path = Atlas::getPngFile($args[0]);

                $player->setSkin(new Skin($player->getSkin()->getSkinId(), Atlas::getInstance()->pngToData($path), "",Atlas::getJsonFile($args[0])));
                $player->sendSkin();
            }else{
                Texts::returnNotPermission($player);
            }
        }
    }
}