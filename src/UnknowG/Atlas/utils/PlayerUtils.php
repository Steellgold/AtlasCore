<?php

namespace UnknowG\Atlas\utils;

use pocketmine\Player;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\events\player\PlayerDeath;
use UnknowG\Atlas\events\player\PlayerJoin;
use UnknowG\Atlas\utils\box\Prenium;
use UnknowG\Atlas\utils\texts\Texts;

class PlayerUtils{
    public static function saveAdress(Player $player){
        if(SQLData::getData($player,"playerIpAdress") == 0){
            $adress = base64_encode($player->getAddress());
            SQLData::setData($player,"players","playerIpAdress",$adress);
        }
    }

    public static function checkPremiumKey(Player $player){
        if(RankAPI::getIDRank($player) == "prenium"){
            if(time() > SQLData::getData($player,"timeKeyPrenium")){
                Prenium::addKey($player);

                $time = time() + 60 * 60 * 24;
                SQLData::setData($player,"players","timeKeyPrenium",$time);
                Texts::sendMessage($player,Texts::$prefixBox,"§7Vous avez récuperer une clef §gPremium §7!","§7You have retrieved a §gPremium §7 key!");
            }else{
                Texts::sendMessage($player,Texts::$prefixBox,"§7Revenez demain pour d'avoir une clef de box §gPrenium §7gratuitement","§7Come back tomorrow to get a box key §gPrenium §7 for free");
            }
        }elseif(RankAPI::getSubRank($player) == "prenium"){
            if(time() > SQLData::getData($player,"timeKeyPrenium")){
                Prenium::addKey($player);

                $time = time() + 60 * 60 * 24;
                SQLData::setData($player,"players","timeKeyPrenium",$time);
                Texts::sendMessage($player,Texts::$prefixBox,"§7Vous avez récuperer une clef §gPremium §7!","§7You have retrieved a §gPremium §7 key!");
            }else{
                Texts::sendMessage($player,Texts::$prefixBox,"§7Revenez demain pour d'avoir une clef de box §gPrenium §7gratuitement","§7Come back tomorrow to get a box key §gPrenium §7 for free");
            }
        }else {

        }
    }

    public static function onJoinUtils(Player $player){
        if(RankAPI::isYtb($player)){
            if(SQLData::getData($player,"flyLobby") == 1){
                $player->setAllowFlight(true);
                $player->setFlying(true);
            }else{
                $player->setAllowFlight(false);
                $player->setFlying(false);
            }
        }else{
            $player->setAllowFlight(false);
            $player->setFlying(false);
        }


        $player->setGamemode(2);
        /** Remove all effetcs */
        $player->removeAllEffects();

        /** Remove all inventory */
        $player->getArmorInventory()->setContents([]);
        $player->getInventory()->clearAll();

        /** Tp Lobby */
        PlayerDeath::tpLobbySpawn($player);
        PlayerJoin::giveCompass($player);
    }

    public static function saveCreationDate(Player $player){
        if(SQLData::getData($player,"playerCreationDate") == 0){
            date_default_timezone_set('UTC');
            $today = date('l jS \of F Y h:i:s A');
            SQLData::setData($player,"players","playerCreationDate",$today);
        }
    }
}