<?php

namespace UnknowG\Atlas\scorehud;

use pocketmine\Player;
use pocketmine\Server;
use Miste\scoreboardspe\API\{
    Scoreboard, ScoreboardDisplaySlot, ScoreboardSort, ScoreboardAction
};
use UnknowG\Atlas\api\ApiXP;
use UnknowG\Atlas\api\CoinsAPI;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\utils\texts\Unicodes;

class Scoreboards{

    public static function createSB(Player $player){
        $scoreboard = new Scoreboard(Server::getInstance()->getPluginManager()->getPlugin("ScoreboardsPE")->getPlugin(),"§7Stats §3- §7{$player->getName()}",ScoreboardAction::CREATE);
        $scoreboard->create(ScoreboardDisplaySlot::SIDEBAR, ScoreboardSort::DESCENDING, true);

        $scoreboard->addDisplay($player);
        $scoreboard->setLine(2," §7Your Rank: §3" . RankAPI::getRank($player) . " ");
        $scoreboard->setLine(4," §7You have §3" . CoinsAPI::getCoins($player) . Unicodes::$coin . " ");
        $scoreboard->setLine(6," §7ALP Level: §3" . ApiXP::getLevel($player) . "§7/§3100" . " ");
        $scoreboard->setLine(8," §3rv-shock.net 19133" . " ");
    }
}