<?php

namespace UnknowG\Atlas\forms\staff;

use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\forms\staff\owner\GamemodeForm;
use UnknowG\Atlas\forms\staff\owner\TpForm;
use UnknowG\Atlas\forms\staff\sanctions\BanForm;
use UnknowG\Atlas\forms\staff\sanctions\KickForm;
use UnknowG\Atlas\forms\staff\sanctions\MuteForm;
use UnknowG\Atlas\forms\staff\server\ServerForm;
use UnknowG\Atlas\utils\texts\Texts;

class HomePageForm extends SimpleForm{
    public static function owner(Player $p)
    {
        $form = new SimpleForm
        (
            function (Player $p, $data) {
                if ($data === null) {
                } else {
                    switch ($data) {
                        case 0:
                                KickForm::openAll($p);
                            break;
                        case 1:
                                ServerForm::open($p);
                            break;
                        case 2:
                                TpForm::openAll($p);
                            break;
                            break;
                    }
                }
            }
        );

        $form->setTitle("§lStaff");
        $form->addButton("Expulser tout le serveur");
        $form->addButton("Modification");
        $form->addButton("Téléporter tout le\nserveur sur vous");
        $p->sendForm($form);
    }

    public static function openAnnounceForm($player)
    {
        $form = new CustomForm(function (Player $player, array $data = null) {
            if (isset($data[0]) && isset($data[1])) {
                if($data[0] == "all"){
                    Server::getInstance()->broadcastTitle(Texts::$prefix,"§7{$data[1]}",1.0,1.0);
                }elseif($data[0] == "premium"){
                    foreach (Server::getInstance()->getOnlinePlayers() as $players){
                        if(RankAPI::isPremium($players)){
                            $players->addTitle(Texts::$prefixPreniumTitle,"§7{$data[1]}",1.0,1.0);
                        }
                    }
                }elseif($data[0] == "staff"){
                    foreach (Server::getInstance()->getOnlinePlayers() as $players){
                        if(RankAPI::isMStaff($players)){
                            $players->addTitle(Texts::$prefixStaffTitle,"§7{$data[1]}",1.0,1.0);
                        }
                    }
                }else{
                    Server::getInstance()->broadcastTitle(Texts::$prefix,"§7{$data[1]}",1.0,1.0);
                }
            } else {
                $player->sendMessage(Texts::$prefix . "Merci de communiquer des informations via cette interface");
            }
        });

        $form->setTitle("§lAnnonce");
        $form->addInput("Qui peut voir ? (premium, all, staff)","all");
        $form->addInput("Texte de l'Annonce","Bla bla bla");
        $form->sendToPlayer($player);
    }
}