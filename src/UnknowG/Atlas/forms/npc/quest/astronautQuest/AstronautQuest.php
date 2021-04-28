<?php

namespace UnknowG\Atlas\forms\npc\quest\astronautQuest;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use UnknowG\Atlas\api\CoinsAPI;
use UnknowG\Atlas\api\QuestAPI;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;
use UnknowG\Atlas\utils\texts\Unicodes;

class AstronautQuest extends SimpleForm {
    public static function first(Player $p)
    {
        $form = new SimpleForm
        (
            function (Player $p, $data) {
                if ($data === null) {
                } else {
                    switch ($data) {
                        case 0:
                            break;
                    }
                }
            }
        );

        $form->setTitle(Texts::getText(SQLData::getLang($p),"§lQuête de l'Astronaute","§lAstronaut Quest"));
        $form->setContent(Texts::getText(SQLData::getLang($p),"§7§7En voyageant dans le monde, pour arriver jusqu'ici avec mon fils et ma femme nous avons pris la fusée §lAE-24 §r§7qui est la 24 ème fusée du projet de mon père, j'aurai besoin de toi en toute urgence, mon fils et ma femme on prit la fusée AE-23 et on ne trouve plus notre fils tu pourrais le retrouver et me le ramener ?","§7Travelling in the world, to get here with my son and my wife we took the rocket §AE-24 §r§7which is the 24th rocket of my father's project, I will need you urgently, my son and my wife we took the rocket AE-23 and we can't find our son anymore could you find him and bring him back to me?"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Bien sûr","Of course you do"));
        $p->sendForm($form);
    }

    public static function fiston(Player $p)
    {
        $form = new SimpleForm
        (
            function (Player $p, $data) {
                if ($data === null) {
                } else {
                    switch ($data) {
                        case 0:
                            break;
                    }
                }
            }
        );

        $form->setTitle(Texts::getText(SQLData::getLang($p),"§lQuête de l'Astronaute","§lAstronaut Quest"));
        $form->setContent(Texts::getText(SQLData::getLang($p),"§7Ramène moi à mon père je t'en supplie !","§7Take me back to my father, please!"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Je suis la pour ca suis moi","That's why I'm here. That's why I'm here."));
        $p->sendForm($form);
    }

    public static function end(Player $p)
    {
        $form = new SimpleForm
        (
            function (Player $p, $data) {
                if ($data === null) {
                } else {
                    switch ($data) {
                        case 0:
                            $c = Unicodes::$coin;
                            Texts::sendMessage($p,Texts::$prefixQuest,"Vous avez récuperer §310$c","You have retrieved §310$c");
                            CoinsAPI::addCoins($p,10);
                            QuestAPI::setFinishAstronaut($p);
                            break;
                    }
                }
            }
        );

        $form->setTitle(Texts::getText(SQLData::getLang($p),"§lQuête de l'Astronaute","§lAstronaut Quest"));
        $c = Unicodes::$coin;
        $form->setContent(Texts::getText(SQLData::getLang($p),"§7Merci, je te serais ételerment reconnaissant d'avoir retrouvé mon fils !\n§7Prend ca je t'en fait cadeau \n\nVous pouvez prendre §310$c","§7Thank you. I'd be so grateful, you found my son.\nTake this as a gift\n\n§fYou can get §310$c"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Merci !","Thank you !"));
        $p->sendForm($form);
    }
}