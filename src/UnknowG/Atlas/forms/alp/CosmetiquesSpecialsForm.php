<?php

namespace UnknowG\Atlas\forms\alp;

use jojoe77777\FormAPI\SimpleForm;
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

class CosmetiquesSpecialsForm
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
                            self::openCapes($p);
                            break;
                        case 1:
                            self::openPets($p);
                            break;
                        case 2:
                            self::openParticles($p);
                            break;
                            break;
                    }
                }
            }
        );

        $form->setTitle("§lALP");
        $form->addButton("Capes",1,"https://rv-shock.net/minecraft/forms/capesIcon.png");
        $form->addButton("Pets",1,"https://rv-shock.net/minecraft/forms/petsIcon.png");
        $form->addButton("Particles",1,"https://rv-shock.net/minecraft/forms/particlesIcon.png");
        $p->sendForm($form);
    }

    public static function openParticles(Player $p)
    {
        $form = new SimpleForm
        (
            function (Player $p, $data) {
                if ($data === null) {
                } else {
                    switch ($data) {
                        case 0:
                            if(SQLData::getData($p,"playerLevel") >= 10) {
                                ParticlesAPI::setParticleUsed($p, "angry");
                                $p->sendMessage(Texts::$prefixParticles . Texts::getText(SQLData::getLang($p), "Vous avez défini(e) votre particule sur §3angry\"", "You have set your particle to §3angry"));
                            }else{
                                Texts::sendMessage($p,Texts::$prefixPass,"Vous n'avez pas le niveau requis pour utiliser cette particules","You don't have the level required to use this particle");
                            }
                            break;
                        case 1:
                            if(SQLData::getData($p,"playerLevel") >= 25) {
                                ParticlesAPI::setParticleUsed($p, "cactus");
                                $p->sendMessage(Texts::$prefixParticles . Texts::getText(SQLData::getLang($p), "Vous avez défini(e) votre particule sur §3cactus", "You have set your particle to §3cactus"));
                            }else{
                                Texts::sendMessage($p,Texts::$prefixPass,"Vous n'avez pas le niveau requis pour utiliser cette particules","You don't have the level required to use this particle");
                            }
                            break;
                        case 2:
                            if(SQLData::getData($p,"playerLevel") >= 40) {
                                ParticlesAPI::setParticleUsed($p, "obsidian");
                                $p->sendMessage(Texts::$prefixParticles . Texts::getText(SQLData::getLang($p), "Vous avez défini(e) votre particule sur §3obsidian", "You have set your particle to §3obsidian"));
                            }else{
                                Texts::sendMessage($p,Texts::$prefixPass,"Vous n'avez pas le niveau requis pour utiliser cette particules","You don't have the level required to use this particle");
                            }
                            break;
                        case 3:
                            if(SQLData::getData($p,"playerLevel") >= 55){
                                ParticlesAPI::setParticleUsed($p,"sand");
                                $p->sendMessage(Texts::$prefixParticles . Texts::getText(SQLData::getLang($p), "Vous avez défini(e) votre particule sur §3purpur", "You have set your particle to §3purpur"));
                            }else{
                                Texts::sendMessage($p,Texts::$prefixPass,"Vous n'avez pas le niveau requis pour utiliser cette particules","You don't have the level required to use this particle");
                            }
                            break;
                        case 4:
                            if(SQLData::getData($p,"playerLevel") >= 70){
                                ParticlesAPI::setParticleUsed($p,"purpur");
                                $p->sendMessage(Texts::$prefixParticles . Texts::getText(SQLData::getLang($p), "Vous avez défini(e) votre particule sur §3purpur", "You have set your particle to §3purpur"));
                            }else{
                                Texts::sendMessage($p,Texts::$prefixPass,"Vous n'avez pas le niveau requis pour utiliser cette particules","You don't have the level required to use this particle");
                            }
                            break;
                        case 5:
                            if(SQLData::getData($p,"playerLevel") >= 95){
                                ParticlesAPI::setParticleUsed($p,"diamond");
                                $p->sendMessage(Texts::$prefixParticles . Texts::getText(SQLData::getLang($p), "Vous avez défini(e) votre particule sur §3diamond\"", "You have set your particle to §3diamond"));
                            }else{
                                Texts::sendMessage($p,Texts::$prefixPass,"Vous n'avez pas le niveau requis pour utiliser cette particules","You don't have the level required to use this particle");
                            }
                            break;
                            break;
                    }
                }
            }
        );

        $form->setTitle("§lALP Particles");
        $form->addButton(Texts::getText(SQLData::getLang($p),"Villageois en colère\nNiveau 10","Angry Villager\nLevel 10"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Cactus\nNiveau 25","Cactus\nLevel 25"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Obsidienne\nNiveau 40","Obsidian\nLevel 40"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Sable\nNiveau 55","Sans\nLevel 55"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Purpur\nNiveau 70","Purpur\nLevel 70"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Diamond\nNiveau 95","Diamond\nLevel 95"));
        $p->sendForm($form);
    }

    public static function openCapes(Player $p)
    {
        $form = new SimpleForm
        (
            function (Player $p, $data) {
                if ($data === null) {
                } else {
                    switch ($data) {
                        case 0:
                            if(SQLData::getData($p,"playerLevel") >= 15){
                                CapesForm::setCape($p,"capeMars");
                                Texts::sendMessage($p, Texts::$prefix, "Vous avez équiper §3capeMars", "You have set §3capeMars");
                            }else{
                                Texts::sendMessage($p,Texts::$prefixPass,"Vous n'avez pas le niveau requis pour utiliser cette cape","You don't have the level required to use this cape");
                            }
                            break;
                        case 1:
                            if(SQLData::getData($p,"playerLevel") >= 30){
                                CapesForm::setCape($p,"capeDarkFlash");
                                Texts::sendMessage($p, Texts::$prefix, "Vous avez équiper §3capeDarkFlash", "You have set §3capeDarkFlash");
                            }else{
                                Texts::sendMessage($p,Texts::$prefixPass,"Vous n'avez pas le niveau requis pour utiliser cette cape","You don't have the level required to use this cape");
                            }
                            break;
                        case 2:
                            if(SQLData::getData($p,"playerLevel") >= 45){
                                CapesForm::setCape($p,"capeIce");
                                Texts::sendMessage($p, Texts::$prefix, "Vous avez équiper §3capeIce", "You have set §3capeIce");
                            }else{
                                Texts::sendMessage($p,Texts::$prefixPass,"Vous n'avez pas le niveau requis pour utiliser cette cape","You don't have the level required to use this cape");
                            }
                            break;
                        case 3:
                            if(SQLData::getData($p,"playerLevel") >= 60){
                                CapesForm::setCape($p,"capeFlashYellow");
                                Texts::sendMessage($p, Texts::$prefix, "Vous avez équiper §3capeFlashYellow", "You have set §3capeFlashYellow");
                            }else{
                                Texts::sendMessage($p,Texts::$prefixPass,"Vous n'avez pas le niveau requis pour utiliser cette cape","You don't have the level required to use this cape");
                            }
                            break;
                        case 4:
                            if(SQLData::getData($p,"playerLevel") >= 75){
                                CapesForm::setCape($p,"capeNasa");
                                Texts::sendMessage($p, Texts::$prefix, "Vous avez équiper §3capeIce", "You have set §3capeIce");
                            }else{
                                Texts::sendMessage($p,Texts::$prefixPass,"Vous n'avez pas le niveau requis pour utiliser cette cape","You don't have the level required to use this cape");
                            }
                            break;
                        case 5:
                            if(SQLData::getData($p,"playerLevel") >= 90){
                                CapesForm::setCape($p,"capeOf");
                                Texts::sendMessage($p, Texts::$prefix, "Vous avez équiper §3capeOf", "You have set §3capeOf");
                            }else{
                                Texts::sendMessage($p,Texts::$prefixPass,"Vous n'avez pas le niveau requis pour utiliser cette cape","You don't have the level required to use this cape");
                            }
                            break;
                            break;
                    }
                }
            }
        );

        $form->setTitle("§lALP Capes");
        $form->addButton(Texts::getText(SQLData::getLang($p),"Cape Mars\nNiveau 15","Mars Cape\nLevel 15"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Cape Flash noir\nNiveau 30","Cape Dark Flash\nLevel 30"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Cape Glace\nNiveau 45","Cape Ice\nLevel 45"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Cape Flash Jaune\nNiveau 60","Cape Yellow Flash\nLevel 60"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Cape Nasa\nNiveau 75","Nasa Cape\nLevel 75"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Cape OF\nNiveau 90","Cape OF\nLevel 90"));
        $p->sendForm($form);
    }

    public static function openPets(Player $p)
    {
        $form = new SimpleForm
        (
            function (Player $p, $data) {
                if ($data === null) {
                } else {
                    switch ($data) {
                        case 0:
                            if(SQLData::getData($p,"playerLevel") >= 5) {
                                PetsSession::setPets($p,"petRabbit");
                                Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petRabbit", "You have set §3petRabbit");
                            }else{
                                Texts::sendMessage($p,Texts::$prefixPass,"Vous n'avez pas le niveau requis pour utiliser cet animal de compagnie","You don't have the level required to use this pet");
                            }
                            break;
                        case 1:
                            if(SQLData::getData($p,"playerLevel") >= 20) {
                                PetsSession::setPets($p, "petDolphin");
                                Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petDolphin", "You have set §3petDolphin");
                            }else{
                                Texts::sendMessage($p,Texts::$prefixPass,"Vous n'avez pas le niveau requis pour utiliser cet animal de compagnie","You don't have the level required to use this pet");
                            }
                            break;
                        case 2:
                            if(SQLData::getData($p,"playerLevel") >= 35) {
                                PetsSession::setPets($p, "petPig");
                                Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petPig", "You have set §3petPig");
                            }
                            break;
                        case 3:
                            if(SQLData::getData($p,"playerLevel") >= 50) {
                                PetsSession::setPets($p, "petParrot");
                                Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petParrot", "You have set §3petParrot");
                            }else{
                                Texts::sendMessage($p,Texts::$prefixPass,"Vous n'avez pas le niveau requis pour utiliser cet animal de compagnie","You don't have the level required to use this pet");
                            }
                            break;
                        case 4:
                            if(SQLData::getData($p,"playerLevel") >= 65) {
                                PetsSession::setPets($p, "petMoos");
                                Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petMoosheroom", "You have set §3petMoosheroom");
                            }else{
                                Texts::sendMessage($p,Texts::$prefixPass,"Vous n'avez pas le niveau requis pour utiliser cet animal de compagnie","You don't have the level required to use this pet");
                            }
                            break;
                        case 5:
                            if(SQLData::getData($p,"playerLevel") >= 80) {
                                PetsSession::setPets($p, "petFox");
                                Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petFox", "You have set §3petFox");
                            }else{
                                Texts::sendMessage($p,Texts::$prefixPass,"Vous n'avez pas le niveau requis pour utiliser cet animal de compagnie","You don't have the level required to use this pet");
                            }
                            break;
                        case 6:
                            if(SQLData::getData($p,"playerLevel") >= 100){
                                if(RankAPI::isPremium($p)){
                                    PetsSession::setPets($p,"petIronGolem");
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petIronGolem", "You have set §3petIronGolem");
                                }else{
                                    PetsSession::setPets($p,"petSnowgolem");
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petSnowGolem", "You have set §3petSnowGolem");
                                }
                            }else{
                                Texts::sendMessage($p,Texts::$prefixPass,"Vous n'avez pas le niveau requis pour utiliser cet animal de compagnie","You don't have the level required to use this pet");
                            }
                            break;
                            break;
                    }
                }
            }
        );

        if(RankAPI::isPremium($p)){
            if(SQLData::getLang($p) == "fr"){
                $max = "Golem de Fer";
            }else{
                $max = "Iron Golem";
            }
        }else{
            if(SQLData::getLang($p) == "fr"){
                $max = "Golem de la neige";
            }else{
                $max = "Snowgolem";
            }
        }

        $form->setTitle("§lALP Capes");
        $form->addButton(Texts::getText(SQLData::getLang($p),"Lapin\nNiveau 5","Rabbit\nLevel 5"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Dophin\nNiveau 20","Dolphin\nLevel 20"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Dochon\nNiveau 35","Pig\nLevel 35"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Perroquet\nNiveau 50","Parrot\nLevel 50"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Vache à Soupe\nNiveau 65","Moosheroom\nLevel 65"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Renard\nNiveau 80","Fox\nLevel 80"));
        $form->addButton($max . "\n". Texts::getText(SQLData::getLang($p),"Niveau 100","Level 100"));
        $p->sendForm($form);
    }
}