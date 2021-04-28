<?php

namespace UnknowG\Atlas\forms\alp;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\entity\Entity;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\Player;
use UnknowG\Atlas\api\ApiXP;
use UnknowG\Atlas\api\ParticlesAPI;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\forms\capes\CapesForm;
use UnknowG\Atlas\pets\manager\PetsSession;
use UnknowG\Atlas\utils\texts\Texts;

class DoubleXPForm
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
                            if (SQLData::getData($p, "doubleXpBottles") >= 1) {
                                if(SQLData::getData($p, "doubleXpActive") == 1){
                                    return;
                                }
                                Texts::sendMessage($p, Texts::$prefixPass, "Pendant 30 minutes vos xp(s) seront doublées alors qu'es ce que vous attendez !", "For 30 minutes your xp(s) will be doubled while you wait!");
                                $endingTime = time() + 60 * 30;
                                SQLData::setData($p, "players", "doubleXpTime", $endingTime);
                                SQLData::setData($p, "players", "doubleXpActive", 1);

                                $fl = SQLData::getData($p, "doubleXpBottles");
                                SQLData::setData($p, "players", "doubleXpBottles", $fl - 1);

                                $p->getLevel()->dropExperience($p->asVector3(), 20);
                                $p->getLevel()->dropExperience($p->asVector3(), 20);
                                $p->getLevel()->dropExperience($p->asVector3(), 20);
                                $p->getLevel()->dropExperience($p->asVector3(), 20);
                            } else {
                                Texts::sendMessage($p, Texts::$prefixPass, "Vous n'avez aucuns flacons !", "You don't have any vials!");
                            }
                            break;
                            break;
                    }
                }
            }
        );

        $fl = SQLData::getData($p, "doubleXpBottles");
        $flhave = SQLData::getData($p, "doubleXpActive");

        $p1 = "§7§l» §r" . Texts::getText(SQLData::getLang($p), "§7Bienvenue sur la page de doublage xp, activez vos flacons ici pour pouvoir gagner plus d'xp, vous pouvez facilement en gagner lors de meurtres avec une chance sur 30 et leur temps est de 30 minutes !", "§7Welcome to the xp dubbing page, activate your vials here to be able to win more xp, you can easily win some during kills with a chance of 4 out of 30 and their time is 30 minutes!");
        $p2 = "§7§l» §r" . Texts::getText(SQLData::getLang($p), "§7Vous avez un total de §3$fl §7flocons de double xp, pour les utiliser cliquez sur le bouton §3lancer §7lors des kills les flocons d'xp se brisent sous vos pieds, ce n'est pas beau son pendant 30 minutes vous aurez la beauté(e)", "§7You have a total of §3$fl §7double xp vials, to use them click on the §3launch a bottle §7button and when you do kills of xp vials will break under your feet, it's not beautiful its for 30 minutes you will have the beauty");

        $form->setTitle("§lALP - Double XP");
        $form->setContent($p1 . "`\n\n$p2");
        if ($flhave == 1) {
            $form->addButton(Texts::getText(SQLData::getLang($p), "Vous avez déjà un effet\nen activité", "You're already \nhaving an effect."), 1, "https://rv-shock.net/minecraft/forms/xpAleardyHave.png");
        } else {
            $form->addButton(Texts::getText(SQLData::getLang($p), "Lancer le flocon", "Launch the vials"));
        }
        $p->sendForm($form);
    }
}