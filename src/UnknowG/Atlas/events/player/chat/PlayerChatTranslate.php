<?php

namespace UnknowG\Atlas\events\player\chat;

use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\LeaguesAPI;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\api\Translation;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;

class PlayerChatTranslate
{
    public static function translateMessage(Player $player, string $message, string $playerLang)
    {

        if ($playerLang == "fr") {
            self::sendFrenchMessage($player, $message); // No translated message

            $enMsg = Translation::auto_translate("fr", "en", $message);
            self::sendEnglishMessage($player, $enMsg); // Translated message
        } else {
            self::sendEnglishMessage($player, $message); // No translated message

            $frMsg = Translation::auto_translate("en", "fr", $message);
            self::sendFrenchMessage($player,$frMsg); // Translated message
        }
    }

    public static function sendEnglishMessage(Player $Baseplayer, string $message)
    {
        foreach (Server::getInstance()->getOnlinePlayers() as $EnglishPlayer) {
            if (SQLData::getLang($EnglishPlayer) == "en") {
                $league = LeaguesAPI::getLeague($Baseplayer);

                switch (SQLData::getData($Baseplayer, "playerRank")) {
                    case "fonda":
                        if(RankAPI::getSubRank($EnglishPlayer) == "prenium"){
                            $EnglishPlayer->sendMessage(Texts::$fondatorRank . "§gPremium§r" . "§7" . "§7" . $league . "§3 " . $Baseplayer->getName() . " §7» §3" . $message);
                        }else{
                            $EnglishPlayer->sendMessage(Texts::$fondatorRank . "§7" . $league . "§3 " . $Baseplayer->getName() . " §7» §3" . $message);
                        }
                        break;
                    case "staff":
                        if(RankAPI::getSubRank($EnglishPlayer) == "prenium"){
                            $EnglishPlayer->sendMessage(Texts::$staffRank . "§gPremium§r" . "§7" . $league . "§e " . $Baseplayer->getName() . " §7» §e" . $message);
                        }else{
                            $EnglishPlayer->sendMessage(Texts::$staffRank . "§7" . $league . "§e " . $Baseplayer->getName() . " §7» §e" . $message);
                        }
                        break;
                    case "prenium":
                        $EnglishPlayer->sendMessage(Texts::$preniumRank . "§7" . $league . "§g " . $Baseplayer->getName() . " §7» §g" . $message);
                        break;
                    case "player":
                        $EnglishPlayer->sendMessage(Texts::$playerRank . "§l" . $league . "§r§7 " . $Baseplayer->getName() . " §r§l»§r §7" . $message);
                        break;
                }
            }
        }
    }

    public static function sendFrenchMessage(Player $Baseplayer, string $message)
    {
        foreach (Server::getInstance()->getOnlinePlayers() as $FrenchPlayer) {
            if (SQLData::getLang($FrenchPlayer) == "fr") {
                $league = LeaguesAPI::getLeague($Baseplayer);

                switch (SQLData::getData($Baseplayer, "playerRank")) {
                    case "fonda":
                        if(RankAPI::getSubRank($FrenchPlayer) == "prenium"){
                            $FrenchPlayer->sendMessage(Texts::$fondatorRank . "§gPremium§r" . "§7" . "§7" . $league . "§3 " . $Baseplayer->getName() . " §7» §3" . $message);
                        }else{
                            $FrenchPlayer->sendMessage(Texts::$fondatorRank . "§7" . $league . "§3 " . $Baseplayer->getName() . " §7» §3" . $message);
                        }
                        break;
                    case "staff":
                        if(RankAPI::getSubRank($FrenchPlayer) == "prenium"){
                            $FrenchPlayer->sendMessage(Texts::$staffRank . "§gPremium§r" . "§7" . $league . "§e " . $Baseplayer->getName() . " §7» §e" . $message);
                        }else{
                            $FrenchPlayer->sendMessage(Texts::$staffRank . "§7" . $league . "§e " . $Baseplayer->getName() . " §7» §e" . $message);
                        }
                        break;
                    case "prenium":
                        $FrenchPlayer->sendMessage(Texts::$preniumRank . "§7" . $league . "§g " . $Baseplayer->getName() . " §7» §g" . $message);
                        break;
                    case "player":
                        $FrenchPlayer->sendMessage(Texts::$playerRank . "§l" . $league . "§r§7 " . $Baseplayer->getName() . " §r§l»§r §7" . $message);
                        break;
                }
            }
        }
    }
}