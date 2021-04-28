<?php

namespace UnknowG\Atlas\forms;

use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;

class RulesForm
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
                            self::rulesAccept($p);
                            break;
                            break;
                    }
                }
            }
        );

        $la = Texts::getText(SQLData::getLang($p), "§cCliquez sur le bouton après avoir lu(e) le règlement§f", "§cPlease click on the button, after reading the rules§f");
        $l1 = Texts::getText(SQLData::getLang($p), "» §7Les doubles comptes qui ont pour but de s'avantager, de se faire deban ou bien d'afk ne sont pas autorisés", "» §7Double accounts for the purpose of benefiting, unban or afk are not allowed");
        $l2 = Texts::getText(SQLData::getLang($p), "» §7Jitter click, manettes à palettes , Butterfly , dragClick sont interdits si ils dépassent les 16 CPS (Bannissement de 3 jours automatiquement)", "» §7Jitter click, paddle joysticks, Butterfly, dragClick are prohibited if they exceed 16 CPS (3 day ban automatically)");
        $l3 = Texts::getText(SQLData::getLang($p), "» §7Les switch abusifs ne sont pas tolérés", "» §7Abusive switches are not tolerated");
        $l4 = Texts::getText(SQLData::getLang($p), "» §7Les logiciels ayant pour but de vous faire \"lag\" sont interdits", "» §7Software designed to make you §llag§r §fis prohibited");
        $l5 = Texts::getText(SQLData::getLang($p), "» §7Toutes dénigrations, flood, spams, majuscules, provocations, propos racistes, propos déplacés, (hitl-, ez, t nul, fd-) sont interdit et punissable d'un bannissement sélévant jusqu'à 10 jours si abus", "» §7All denigration, §lflood, spam, capital letters, provocations, racist remarks, inappropriate remarks, (hitl-, ez, you suck, fuc- you)§r§f are forbidden and punishable by a ban up to 10 days if abused");
        $l6 = Texts::getText(SQLData::getLang($p), "» §7Le déco combat sera punissable d'un bannissement 1 journée", "» §7The fight deconnect will be punishable by a 1 day ban.");
        $l7 = Texts::getText(SQLData::getLang($p), "» §7Les menaces.. sont bannissables de 1 à 30 jours", "» §7Threats.. are banned for 1 to 30 days.");

        $form->setTitle(Texts::getText(SQLData::getLang($p), "§lRèglement", "§lRules"));
        $form->setContent("$la\n$l1\n$l2\n$l3\n$l4\n$l5\n$l6\n$l7");
        $form->addButton("§lRead and approved");
        $p->sendForm($form);
    }

    public static function rulesAccept($player)
    {
        $form = new CustomForm(function (Player $player, array $data = null) {
            if ($data[1] == "Read and approved") {
                SQLData::setData($player, "players", "rulesAccept", 1);
                Texts::sendMessage($player, Texts::$prefix, "Bon jeu à vous", "Good game at you !");
            } else {
                RulesForm::open($player);
                Texts::sendMessage($player, Texts::$prefix, "Merci d'écrire §lRead and approved", "Please, enter read and approved");
            }
        });

        $form->setTitle("§lCoins");
        $form->addLabel(Texts::getText(SQLData::getLang($player), "Merci d'écrire §lRead and approved", "Please, enter §lRead and approved"));
        $form->addInput(Texts::getText(SQLData::getLang($player), "Message", "Message"));
        $form->sendToPlayer($player);
    }
}