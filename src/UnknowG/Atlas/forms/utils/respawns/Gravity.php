<?php

namespace UnknowG\Atlas\forms\utils\respawns;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\Player;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\events\player\PlayerDeath;
use UnknowG\Atlas\events\player\PlayerJoin;
use UnknowG\Atlas\utils\RespawnUtil;
use UnknowG\Atlas\utils\texts\Texts;

class Gravity
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
                            PlayerDeath::tpGravitySpawn($p);
                            $p->getInventory()->clearAll();
                            $p->removeAllEffects();
                            RespawnUtil::giveGappleKit($p);

                            $p->addEffect(new EffectInstance(Effect::getEffect(8),20 * 999999,3,false));
                            break;
                        case 1:
                            $p->getInventory()->clearAll();
                            $p->removeAllEffects();
                            $p->getArmorInventory()->setContents([]);


                            PlayerJoin::giveCompass($p);
                            PlayerDeath::tpLobbySpawn($p);
                            break;
                            break;
                    }
                }
            }
        );

        $form->setTitle("§lAtlas");
        $form->setContent(Texts::getText(SQLData::getLang($p),"§7Voulez vous rejouer ?","§7Do you want replay ?") . "\n\n\n\n\n\n\n ");
        $form->addButton(Texts::getText(SQLData::getLang($p),"§lOui","§lYes"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"§lNon","§lNo"));
        $p->sendForm($form);
    }
}