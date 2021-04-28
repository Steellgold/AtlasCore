<?php

namespace UnknowG\Atlas\forms\utils;

use jojoe77777\FormAPI\CustomForm;
use pocketmine\level\sound\AnvilUseSound;
use pocketmine\Player;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;

class SettingsForm
{
    public static function open($player)
    {
        $form = new CustomForm(function (Player $player, array $data = null) {
            if (isset($data[0]) && isset($data[1]) && isset($data[2]) && isset($data[3]) && isset($data[4])) {
                $player->getLevel()->addSound(new AnvilUseSound($player->asVector3()));
                $player->sendMessage(Texts::$prefix . Texts::getText(SQLData::getLang($player),"Certains réglages nécessitent une déconnexion ainsi qu'une reconnexion pour être effectués.","Some settings require a disconnection as well as a reconnection to be carried out."));

                SQLData::setData($player,"players","showPopus",SettingsForm::getNumber($data[0]));
                SQLData::setData($player,"players","autoReconnect",SettingsForm::getNumber($data[1]));

                if(RankAPI::getIDRank($player) == "ytb" or RankAPI::getSubRank($player) == "ytb" or RankAPI::getIDRank($player) == "fonda" or RankAPI::getIDRank($player) == "admin" or RankAPI::getIDRank($player) == "staff"){
                    SQLData::setData($player,"players","flyLobby",SettingsForm::getNumber($data[2]));
                    if($data[2] == true){
                        $player->setAllowFlight(true);
                        $player->setFlying(true);
                    }else{
                        $player->setAllowFlight(false);
                        $player->setFlying(false);
                    }
                }else{
                    SQLData::setData($player,"players","flyLobby",0);
                    $player->sendMessage(Texts::$prefix . Texts::getText(SQLData::getLang($player),"Vous n'avez pas accès aux paramètres spéciaux pour le grade §cYouTube","You do not have access to the special parameters for the grade §cYouTube"));
                }

                if(RankAPI::isPremium($player) or $player->getName() == "ChromaYY9952"){
                    SQLData::setData($player,"players","showRank",SettingsForm::getNumber($data[3]));
                    SQLData::setData($player,"players","lgShow",SettingsForm::getNumber($data[4]));
                }else{
                    SQLData::setData($player,"players","showRank",0);
                    SQLData::setData($player,"players","lgShow",0);
                    $player->sendMessage(Texts::$prefix . Texts::getText(SQLData::getLang($player),"Vous n'avez pas accès aux paramètres spéciaux pour le grade §cPremium","You do not have access to the special parameters for the grade §cPremium"));
                }
            } else {
                $player->sendMessage(Texts::$prefix . Texts::getText(SQLData::getLang($player),"Merci de communiquer des informations via cette interface","Please communicate information via this interface"));
            }
        });

        $form->setTitle(Texts::getText(SQLData::getLang($player),"§lParamètres","§lSettings"));
        $form->addToggle(Texts::getText(SQLData::getLang($player),"Affichez tout les popus","Show all popus"),SQLData::getData($player,"showPopus"));
        $form->addToggle(Texts::getText(SQLData::getLang($player),"Reconnexion automatique lors d'un arrêt du serveur","Automatic reconnection when the server shuts down"),SQLData::getData($player,"autoReconnect"));
        $form->addToggle(Texts::getText(SQLData::getLang($player),"§cYT: Activez le vol dans le lobby","§cYT: Activate flying in the lobby"),SQLData::getData($player,"flyLobby"));
        $form->addToggle(Texts::getText(SQLData::getLang($player),"§4Premium: §7Affichez mon grade dans le chat","§4Premium: §7Show my rank in the chat"),SQLData::getData($player,"showRank"));
        $form->addToggle(Texts::getText(SQLData::getLang($player),"§4Premium: §7Eclair lors d'un §4kill","§4Premium: §7Lightning at a §4kill"),SQLData::getData($player,"lgShow"));
        $form->sendToPlayer($player);
    }

    public static function getNumber(string $letter){
        switch ($letter){
            case true:
                return 1;
                break;

            case false:
                return 0;
                break;
        }
        return true;
    }
}