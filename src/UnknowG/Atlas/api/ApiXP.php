<?php

namespace UnknowG\Atlas\api;

use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\network\mcpe\protocol\ActorEventPacket;
use pocketmine\network\mcpe\protocol\AddActorPacket;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;

class ApiXP extends SQL
{
    public static function getLevel(Player $player)
    {
        return SQLData::getData($player, "playerLevel");
    }

    public static function getXP(Player $player)
    {
        return SQLData::getData($player, "playerXp");
    }

    public static function setLevel(Player $player, int $level)
    {
        SQLData::setData($player, "players", "playerLevel", $level);
    }

    public static function addLevel(Player $player)
    {
        $total = self::getLevel($player) + 1;
        SQLData::setData($player, "players", "playerLevel", $total);
    }

    public static function setXp(Player $player, int $xp)
    {
        SQLData::setData($player, "players", "playerXp", $xp);
    }

    public static function addXp(Player $player, int $xp)
    {
        $total = self::getXP($player) + $xp;
        SQLData::setData($player, "players", "playerXp", $total);
        self::getLevelByXp($player);
    }

    public static function reset(Player $player)
    {

    }

    public static function getLevelByXp(Player $player)
    {
        $level = ApiXP::getLevel($player);
        $levelplus = ApiXP::getLevel($player) + 1;
        if (ApiXP::getXp($player) >= (($level * 2 * 2500) - 2500)) {
            $player->addTitle(Texts::$prefixPass, "§7$level §l» §r§7$levelplus",10.0,10.0,10.0);

            ApiXP::addLevel($player);
            CoinsAPI::addCoins($player,15);
            self::guardian($player);

            return ApiXP::getLevel($player) + 1;
        }
    }

    public static function guardian(Player $player)
    {
        $pk = new LevelEventPacket();
        $pk->evid = LevelEventPacket::EVENT_GUARDIAN_CURSE;
        $pk->data = 0;
        $pk->position = $player->asVector3();
        $player->dataPacket($pk);
    }
}