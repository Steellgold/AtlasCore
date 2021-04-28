<?php

namespace UnknowG\Atlas\forms;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\forms\capes\CapesForm;
use UnknowG\Atlas\forms\particles\ParticlesListForm;
use UnknowG\Atlas\forms\pets\PetsForm;
use UnknowG\Atlas\utils\texts\Texts;

class CosmetiquesForm
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
                            CapesForm::open($p);
                            break;
                        case 1:
                            PetsForm::open($p);
                            break;
                        case 2:
                            ParticlesListForm::open($p);
                            break;
                            break;
                    }
                }
            }
        );

        $form->setTitle(Texts::getText(SQLData::getLang($p), "§lCosmetiques", "§lCosmetics"));

        $form->addButton("Capes",1,"https://rv-shock.net/minecraft/forms/capesIcon.png");
        $form->addButton("Pets",1,"https://rv-shock.net/minecraft/forms/petsIcon.png");
        $form->addButton("Particles",1,"https://rv-shock.net/minecraft/forms/particlesIcon.png");
        $p->sendForm($form);
    }
}