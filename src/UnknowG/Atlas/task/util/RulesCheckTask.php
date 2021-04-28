<?php

namespace UnknowG\Atlas\task\util;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use UnknowG\Atlas\api\LeaguesAPI;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\forms\RulesForm;

class RulesCheckTask extends Task{
    private $player;
    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function onRun(int $currentTick)
    {
        if(!SQLData::getData($this->player,"rulesAccept") == 1){
            RulesForm::open($this->player);
        }
    }
}