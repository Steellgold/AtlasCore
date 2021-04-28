<?php

namespace UnknowG\Atlas\task;

use pocketmine\scheduler\Task;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\mgr\PlayerProtectManager as PPM;
use pocketmine\Server;
use UnknowG\Atlas\utils\texts\Texts;

class CombatCheckTask extends Task
{
    public function onRun(int $currentTick)
    {
        foreach (PPM::$checkfight as $lol) {
            $time = $lol["time"];
            $player = $lol["player"];
            $p = Server::getInstance()->getPlayer($player);
            if ($time > 0) {
                PPM::setTime($p, $time - 1);
                $p->sendTip(Texts::getText(SQLData::getLang($p),"§lVous pourrez changez d'adversaire dans $time secondes","§lYou will be able toss change your opponent in $time seconds."));
            } else {
                PPM::delIn($p);
            }
        }
    }
}