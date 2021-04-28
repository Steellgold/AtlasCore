<?php

namespace UnknowG\Atlas\task\staff;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\utils\Config;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\Atlas;

class StaffHidePlayer extends Task
{
    public $player;
    public $file;

    public function __construct(Player $player, Config $file)
    {
        $this->player = $player;
        $this->file = $file;
    }

    public function onRun(int $currentTick)
    {
        foreach(Atlas::getInstance()->getServer()->getOnlinePlayers() as $onlinePlayer){
            if(RankAPI::isStaff($this->player)){
                if($this->file->get($this->player->getName()) == 1){
                    $onlinePlayer->hidePlayer($this->player);
                }else{
                    $onlinePlayer->showPlayer($this->player);
                }
            }
        }
    }
}