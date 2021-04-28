<?php

namespace UnknowG\Atlas\forms;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use UnknowG\Atlas\api\ParticlesAPI;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\forms\capes\CapesForm;
use UnknowG\Atlas\pets\manager\PetsSession;
use UnknowG\Atlas\utils\texts\Texts;

class NitroForm extends SimpleForm {
    public static function choose(Player $p)
    {
        $form = new SimpleForm
        (
            function (Player $p, $data) {
                if ($data === null) {
                } else {
                    switch ($data) {
                        case 0:
                            PetsSession::setPets($p,"petEndermite");
                            Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petEndermite", "You have set §3petEndermite");
                            break;
                        case 1:
                            CapesForm::setCape($p,"capeNitro");
                            Texts::sendMessage($p, Texts::$prefix, "Vous avez équiper §3capeNitro", "You have set §3capeNitro");
                            break;
                        case 2:
                            ParticlesAPI::setParticleUsed($p,"nitro");
                            Texts::sendMessage($p, Texts::$prefix, "Vous avez équiper les particules §3particleNitro", "You have set §3particleNitro");
                            break;
                            break;
                    }
                }
            }
        );

        $p1 = "§l§7» §r§7" . Texts::getText(SQLData::getLang($p),"Bienvenue dans l'interface §dNitro §7cosmétique que vous pouvez avoir en faisant §d&boost §7sur le discord en ayant bien sûr boosté le serveur grâce à l'abonnement Nitro Boost !","Welcome to the §dNitro §7cosmetics interface that you can have by doing §d&boost §7in the discord by having of course boosted the server thanks to the Nitro Boost subscription!");

        $form->setTitle("§lNitro Boost");
        $form->setContent($p1);
        $form->addButton(Texts::getText(SQLData::getLang($p),"Endermite","Endermite"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Cape Nitro","Nitro Cape"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Particules Roses","Nitro Particles"));
        $p->sendForm($form);
    }
}