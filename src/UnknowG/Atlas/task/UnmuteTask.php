<?php

namespace UnknowG\Atlas\task;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\events\player\chat\PlayerChat;
use UnknowG\Atlas\utils\texts\Texts;

class UnmuteTask extends Task
{
    public $player;
    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function onRun(int $currentTick)
    {
        if(RankAPI::getSubRank($this->player) == "muted"){
            if(PlayerChat::checkMuteExpired($this->player)){
                RankAPI::setSubRank($this->player,"player");
                SQLData::killMute($this->player);
                $this->player->sendMessage(Texts::$prefix . Texts::getText(SQLData::getLang($this->player),"Vous pouvez à nouveau parler !","You can now talk !"));
            }else{
                $time = SQLData::getMuteData($this->player, "time");

                $init = $time - time();
                $minutes = floor(($init / 60) % 60);
                $seconds = $init % 60;

                $this->player->sendMessage(Texts::$prefix . Texts::getText(SQLData::getLang($this->player),"Vous pourrez à nouveau parler dans §3$minutes minutes §7et §3$seconds secondes","You'll be able to talk again in §3$minutes minutes §7and §3$seconds secondes"));
            }
        }
    }
}