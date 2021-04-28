<?php

namespace UnknowG\Atlas\forms\alp;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use UnknowG\Atlas\api\ApiXP;
use UnknowG\Atlas\api\CoinsAPI;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\forms\CosmetiquesForm;
use UnknowG\Atlas\utils\texts\Texts;
use UnknowG\Atlas\utils\texts\Unicodes;

class ALPForm
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
                            CosmetiquesSpecialsForm::open($p);
                            break;
                        case 1:
                            DoubleXPForm::open($p);
                            break;
                            break;
                    }
                }
            }
        );

        $level = ApiXP::getLevel($p);
        $p1 = "§7§l» §r" . Texts::getText(SQLData::getLang($p),"§7Bienvenue sur l'ALP (Atlas Level Pass) faîtes des kills ou ouvrez des boxs pour gagner un maximum d'xp et augmenter votre niveau pour pouvoir gagner des récompenses exclusives du pass, il reste intact à chaque saison, nous ne réinitialisons pas le pass","§7Welcome on the ALP (Atlas Level Pass) made of kills or open boxes to win a maximum of xp and increase your level to be able to win exclusive rewards of the pass, it remains intact each season, we do not reset the pass");
        $p2 = "§7§l» §r" . Texts::getText(SQLData::getLang($p),"§7Niveau: §l$level" . "§r§7/§l100","§7Level: §l$level" . "§r§7/§l100");

        $form->setTitle("§lALP");
        $form->setContent($p1."\n\n".$p2."\n");
        $form->addButton(Texts::getText(SQLData::getLang($p),"Cosmetiques","Cosmetics"),1,"https://rv-shock.net/minecraft/textures/item/firework_rocket.png");
        $form->addButton(Texts::getText(SQLData::getLang($p),"Double XP","Double XP"),1,"https://rv-shock.net/minecraft/forms/iconDoubleXP.png");
        $p->sendForm($form);
    }

    public static function openBuy(Player $p)
    {
        $form = new SimpleForm
        (
            function (Player $p, $data) {
                if ($data === null) {
                } else {
                    switch ($data) {
                        case 0:
                            if(CoinsAPI::getCoins($p) >= 1500){
                                CoinsAPI::delCoins($p,1500);
                                SQLData::setData($p,"players","asALP",1);
                                ALPForm::open($p);
                                Texts::sendMessage($p,Texts::$prefixPass,"Vous avez débloqué le §3Atlas Level Pass §7eliminez vos adversaires pour gagner des xp et augmenter votre niveau, tous les 5 niveaux vous gagnerez une récompense exclusive.","You have unlocked the §3Atlas Level pass §7eliminate opponents to win xp and increase your level, every 5 levels you will win an eclusive reward.");
                            }else{
                                Texts::sendMessage($p,Texts::$prefixPass,"Vous n'avez pas assez de coins pour pouvoir vous acheter l'§3ALP","You don't have enough coins to buy yourself the 3ALP.");
                            }
                            break;
                            break;
                    }
                }
            }
        );

        $p1 = "§7§l» §r" . Texts::getText(SQLData::getLang($p),"§7Débloquez le §3Atlas Level Pass §7pour pouvoir débloquer des cosmétiques exclusifs !","§7Unlock the §3Atlas Level Pass §7 to be able to unlock exclusive cosmetics!");
        $bB = "\n1500" . Unicodes::$coin;

        $form->setTitle("§lALP");
        $form->setContent($p1."\n\n\n\n\n\n\n\n\n");
        $form->addButton(Texts::getText(SQLData::getLang($p),"Acheter$bB","Buy$bB"),1,"https://rv-shock.net/minecraft/forms/passBuy.png");
        $p->sendForm($form);
    }
}