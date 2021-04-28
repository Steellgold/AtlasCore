<?php

namespace UnknowG\Atlas\forms;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;

class LangForm
{
    public static function open(Player $p)
    {
        $form = new SimpleForm
        (
            function (Player $p, $data) {
                if ($data === null) {
                } else {
                    switch ($data) {
                        case 0:
                            SQLData::setLang($p, "fr");
                            RulesForm::open($p);
                            Texts::sendMessage($p,Texts::$prefix,"Vous avez choisie de configurer la langue de vos messages en §3Français","You have chosen to configure the language of your messages in §3English");
                            break;
                        case 1:
                            RulesForm::open($p);
                            SQLData::setLang($p, "en");
                            Texts::sendMessage($p,Texts::$prefix,"Vous avez choisie de configurer la langue de vos messages en §3Français","You have chosen to configure the language of your messages in §3English");
                            break;
                            break;
                    }
                }
            }
        );

        $form->setTitle("§lLanguage");
        $form->setContent(Texts::getText(SQLData::getLang($p),"§7Que voulez vous choisir comme language ?","§7What language do you want to choose?") . "\n\n\n\n\n\n\n ");
        $form->addButton("§lFrançais");
        $form->addButton("§lEnglish");
        $p->sendForm($form);
    }
}