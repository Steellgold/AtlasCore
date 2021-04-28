<?php

namespace UnknowG\Atlas\forms\utils;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;

class MutedForm
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
                            break;
                            break;
                    }
                }
            }
        );

        $form->setTitle("§lWarning !");

        $rsn = SQLData::getMuteData($p,"reason");
        $time = SQLData::getMuteData($p,"time");

        $init = $time - time();
        $day = floor($init / 86400);
        $hours = floor(($init / 3600));
        $minutes = floor(($init / 60) % 60);
        $seconds = $init % 60;

        $form->setContent(Texts::getText(SQLData::getLang($p),"§fVous êtes actuellement mis au silence, vous ne pouvez donc pas parler !\n\nVous devez encore attendre: $day jours $hours $minutes minutes $seconds secondes\n\nRaison: $rsn\n\n\n\n\n ","You are currently muted, so you cannot speak!\nYou still have to wait: $day days $hours $minutes minutes $seconds seconds\nReason: $rsn\n\n\n\n\n"));
        $form->addButton("OK");
        $p->sendForm($form);
    }
}