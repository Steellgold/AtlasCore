<?php

namespace UnknowG\Atlas\task\util;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use UnknowG\Atlas\api\LeaguesAPI;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\forms\utils\MutedForm;

class MutedFormTask extends Task{
    private $player;
    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function onRun(int $currentTick)
    {
        MutedForm::open($this->player);
    }
}