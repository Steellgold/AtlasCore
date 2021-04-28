<?php

namespace UnknowG\Atlas\forms\particles;

use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;
use pocketmine\Player;
use UnknowG\Atlas\api\CoinsAPI;
use UnknowG\Atlas\api\ParticlesAPI;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;
use UnknowG\Atlas\utils\texts\Unicodes;

class ParticlesListForm
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
                            ParticlesAPI::setParticleUsed($p, "none");
                            $p->sendMessage(Texts::$prefixParticles . Texts::getText(SQLData::getLang($p), "Vous avez défini(e) votre particule sur §3aucunes", "You have set your particle to §3none"));
                            break;
                        case 1:
                            if (ParticlesAPI::getParticleStatus($p, "heartParticles") == 1) {
                                ParticlesAPI::setParticleUsed($p, "heartParticles");
                                $p->sendMessage(Texts::$prefixParticles . Texts::getText(SQLData::getLang($p), "Vous avez défini(e) votre particule sur §3heartParticles", "You have set your particle to §3heartParticles"));
                            } else {
                                self::buyParticle($p, "heartParticles", 100, CoinsAPI::getCoins($p));
                            }
                            break;
                        case 2:
                            if (ParticlesAPI::getParticleStatus($p, "greenParticles") == 1) {
                                ParticlesAPI::setParticleUsed($p, "greenParticles");
                                $p->sendMessage(Texts::$prefixParticles . Texts::getText(SQLData::getLang($p), "Vous avez défini(e) votre particule sur §3greenParticles", "You have set your particle to §3greenParticles"));
                            } else {
                                self::buyParticle($p, "greenParticles", 100, CoinsAPI::getCoins($p));
                            }
                            break;
                        case 3:
                            if (ParticlesAPI::getParticleStatus($p, "dirtParticles") == 1) {
                                ParticlesAPI::setParticleUsed($p, "dirtParticles");
                                $p->sendMessage(Texts::$prefixParticles . Texts::getText(SQLData::getLang($p), "Vous avez défini(e) votre particule sur §3dirtParticle", "You have set your particle to §3dirtParticles"));
                            } else {
                                self::buyParticle($p, "dirtParticles", 50, CoinsAPI::getCoins($p));
                            }
                            break;
                        case 4:
                            if (ParticlesAPI::getParticleStatus($p, "bloodParticles") == 1) {
                                ParticlesAPI::setParticleStatus($p, "bloodParticles", 1);
                                ParticlesAPI::setParticleUsed($p, "bloodParticles");
                                $p->sendMessage(Texts::$prefixParticles . Texts::getText(SQLData::getLang($p), "Vous avez défini(e) votre particule sur §3bloodParticles", "You have set your particle to §3bloodParticles"));
                            }
                            break;
                        case 5:
                            if (ParticlesAPI::getParticleStatus($p, "cobwebParticles") == 1) {
                                ParticlesAPI::setParticleStatus($p, "cobwebParticles", 1);
                                ParticlesAPI::setParticleUsed($p, "cobwebParticles");
                                $p->sendMessage(Texts::$prefixParticles . Texts::getText(SQLData::getLang($p), "Vous avez défini(e) votre particule sur §3cobwebParticles", "You have set your particle to §3cobwebParticles"));
                            }
                            break;
                            break;
                    }
                }
            }
        );

        $co = Unicodes::$coin;
        $p1s = self::getStatus($p,"heartParticles");
        $p2s = self::getStatus($p,"greenParticles");
        $p4s = self::getStatus($p,"bloodParticles");
        $p5s = self::getStatus($p,"cobwebParticles");
        $p6s = self::getStatus($p,"dirtParticles");

        $form->setTitle(Texts::getText(SQLData::getLang($p),"§lParticules","§lParticules"));
        $form->setContent("§l§7» §r§7" . Texts::getText(SQLData::getLang($p),"§7Pour selectionner une particule à utiliser cliquer sur ceux que vous avez déjà, et si vous voulez l'acheter cliquer sur ceux que vous n'avez pas !","§7To select a particle to use click on the ones you already have, and if you want to buy it click on the ones you don't have!"));

        $form->addButton(Texts::getText(SQLData::getLang($p),"Aucunes Particules","No Particles"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Coeurs\n$p1s - 100$co","Hearts\n$p1s - 100$co"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Villageois heureux\n$p2s - 100$co","Happy Villagers\n$p2s - 100$co"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Terre\n$p6s - 50$co","Dirt\n$p6s - 50$co"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"§lSang\n$p4s - PREMIUM","§lBlood\n$p4s - PREMIUM"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"§lToile d'araigné\n$p5s - PREMIUM","§lSpider's Web\n$p5s - PREMIUM"));
    
        /** Others buttons */
        $form->addButton(Texts::getText(SQLData::getLang($p),"Quitter","Leave"));
        $p->sendForm($form);
    }

    public static function buyParticle(Player $player, string $particleName, int $price, int $playerCoins){
        if(ParticlesAPI::getParticleStatus($player,$particleName) == 1){
            $player->sendMessage(Texts::$prefix . Texts::getText(SQLData::getLang($player),"Vous avez déjà cette particule","You already have that particle"));
        }else{
            if($playerCoins > $price){
                ParticlesAPI::setParticleStatus($player,$particleName,1);
                CoinsAPI::delCoins($player,$price);

                $uni = Unicodes::$coin;
                $player->sendMessage(Texts::$prefix . Texts::getText(SQLData::getLang($player),"Vous avez acheté(e) la particule §3{$particleName} §7pour §3{$price}$uni","You purchased the particle §3{$particleName} §7for §3{$price}$uni"));
            }else{
                $player->sendMessage(Texts::$prefix . Texts::getText(SQLData::getLang($player),"Vous n'avez pas assez de coins pour pouvoir acheter cette particule","You don't have enough coins to be able to buy that particle..."));
            }
        }
    }

    public static function getStatus(Player $player, string $particleName){
        if(ParticlesAPI::getParticleStatus($player,$particleName) == 1){
            return Texts::getText(SQLData::getLang($player),"AQUIS","HAVE");
        }else{
            return Texts::getText(SQLData::getLang($player),"NON AQUIS","NOT HAVE");
        }
    }
}