<?php

namespace UnknowG\Atlas\forms\pets;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use UnknowG\Atlas\api\CoinsAPI;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\pets\manager\PetsSession;
use UnknowG\Atlas\utils\texts\Texts;
use UnknowG\Atlas\utils\texts\Unicodes;

class PetsForm extends SimpleForm{
    public static function open(Player $p)
    {
        {
            $form = new SimpleForm
            (
                function (Player $p, $data) {
                    if ($data === null) {
                    } else {
                        switch ($data) {
                            case 0:
                                PetsSession::removePets($p);
                                break;
                            case 1:
                                if (SQLData::getData($p, "petSkeleton") == 1) {
                                    PetsSession::setPets($p, "petSkeleton");
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petSkeleton", "You have set §3petSkeleton");
                                } else {
                                    self::buyPets($p, "petSkeleton", 100, CoinsAPI::getCoins($p));
                                }
                                break;
                            case 2:
                                if (SQLData::getData($p, "petZombie") == 1) {
                                    PetsSession::setPets($p, "petZombie");
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petZombie", "You have set §3petZombie");
                                } else {
                                    self::buyPets($p, "petZombie", 100, CoinsAPI::getCoins($p));
                                }
                                break;
                            case 3:
                                if (SQLData::getData($p, "petCat") == 1) {
                                    PetsSession::setPets($p, "petCat");
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petCat", "You have set §3petCat");
                                } else {
                                    self::buyPets($p, "petCat", 100, CoinsAPI::getCoins($p));
                                }
                                break;
                            case 4:
                                if (SQLData::getData($p, "petHorse") == 1) {
                                    PetsSession::setPets($p, "petHorse");
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petHorse", "You have set §3petHorse");
                                } else {
                                    self::buyPets($p, "petHorse", 100, CoinsAPI::getCoins($p));
                                }
                                break;
                            case 5:
                                if (SQLData::getData($p, "petGuardian") == 1) {
                                    PetsSession::setPets($p, "petGuardian");
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petGuardian", "You have set §3petGuardian");
                                } else {
                                    self::buyPets($p, "petGuardian", 100, CoinsAPI::getCoins($p));
                                }
                                break;
                            case 6:
                                if (SQLData::getData($p, "petTurtle") == 1) {
                                    PetsSession::setPets($p, "petTurtle");
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petTurtle", "You have set §3petTurtle");
                                } else {
                                    self::buyPets($p, "petTurtle", 100, CoinsAPI::getCoins($p));
                                }
                                break;
                            case 7:
                                if (SQLData::getData($p, "petSpider") == 1) {
                                    PetsSession::setPets($p, "petSpider");
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petSpider", "You have set §3petSpider");
                                } else {
                                    self::buyPets($p, "petSpider", 100, CoinsAPI::getCoins($p));
                                }
                                break;
                            case 8:
                                if (SQLData::getData($p, "petPhantom") == 1) {
                                    PetsSession::setPets($p, "petPhantom");
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petPhantom", "You have set §3petPhantom");
                                } else {
                                    self::buyPets($p, "petPhantom", 100, CoinsAPI::getCoins($p));
                                }
                                break;
                            case 9:
                                if (RankAPI::isPremium($p)) {
                                    PetsSession::setPets($p, "petTnt");
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petTnt", "You have set §3petTnt");
                                } else {
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous n'avez pas accès au capes du grade §gPremium", "You do not have access to the rank capes §gPremium");
                                }
                                break;
                            case 10:
                                if (RankAPI::isPremium($p)) {
                                    PetsSession::setPets($p, "petWither");
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petWither", "You have set §3petWither");
                                } else {
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous n'avez pas accès au capes du grade §gPremium", "You do not have access to the rank capes §gPremium");
                                }
                                break;
                            case 11:
                                if (RankAPI::isPremium($p)) {
                                    PetsSession::setPets($p, "petFireball");
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petFireball", "You have set §3petFireball");
                                } else {
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous n'avez pas accès au capes du grade §gPremium", "You do not have access to the rank capes §gPremium");
                                }
                                break;
                            case 12:
                                if (RankAPI::isYtb($p)) {
                                    PetsSession::setPets($p, "petMinecart");
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petMinecart", "You have set §3petMinecart");
                                } else {
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous n'avez pas accès au capes du grade §cYouTuber", "You do not have access to the grade capes §cYouTuber");
                                }
                                break;
                            case 13:
                                if (RankAPI::isYtb($p)) {
                                    PetsSession::setPets($p, "petCamera");
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petCamera", "You have set §3petCamera");
                                } else {
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous n'avez pas accès au capes du grade §cYouTuber", "You do not have access to the grade capes §cYouTuber");
                                }
                                break;
                            case 14:
                                if (RankAPI::isYtb($p)) {
                                    PetsSession::setPets($p, "petPanda");
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petPanda", "You have set §3petPanda");
                                } else {
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous n'avez pas accès au capes du grade §cYouTuber", "You do not have access to the grade capes §cYouTuber");
                                }
                                break;
                            case 15:
                                if (RankAPI::isPremium($p)) {
                                    PetsSession::setPets($p, "petHooper");
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous avez équiper §3petHooper", "You have set §3petHooper");
                                } else {
                                    Texts::sendMessage($p, Texts::$prefixPets, "Vous n'avez pas accès au capes du grade §gPremium", "You do not have access to the rank capes §gPremium");
                                }
                                break;
                        }
                    }
                }
            );

            $skeletton = self::getStatus($p,"petSkeleton");
            $zombie = self::getStatus($p,"petZombie");
            $cat = self::getStatus($p,"petCat");
            $horse = self::getStatus($p,"petHorse");
            $gardian = self::getStatus($p,"petGuardian");
            $turtle = self::getStatus($p,"petTurtle");
            $spider = self::getStatus($p,"petSpider");
            $phantom = self::getStatus($p,"petPhantom");

            $form->setTitle("Pets");
            $form->setContent("§l§7» §r§7" . Texts::getText(SQLData::getLang($p),"§7Vous voulez un mob de compagnie, achetez les et équipez les, c'est aussi simple que sa","§7You want a company moped, buy them and equip them, it's as simple as that."));

            $form->addButton(Texts::getText(SQLData::getLang($p),"§c§lRetiré le pets","§c§lRemove the pets"));
            $form->addButton(Texts::getText(SQLData::getLang($p),"Squelette","Skeleton") . "\n$skeletton");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Zombie","Zombie") . "\n$zombie");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Chat","Cat") . "\n$cat");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Cheval","Horse"). "\n$horse" );
            $form->addButton(Texts::getText(SQLData::getLang($p),"Guardien","Guardian") . "\n$gardian");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Tortue","Turtle") . "\n$turtle");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Araignée","Spider") . "\n$spider");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Phantom","Phantom") . "\n$phantom");
            $form->addButton(Texts::getText(SQLData::getLang($p),"TNT","TNT") . "\n§lPremium");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Wither","Wither") . "\n§lPremium ");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Boule de Feu","Dragon Fireball") . "\n§lPremium");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Minecart","Minecart") . "\n§lYouTuber");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Caméra","Camera") . "\n§lYouTuber");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Panda","Panda") . "\n§lYouTuber");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Entonnoir d'idées","Ideas Hooper") . "\n§lPremium");
            $form->addButton(Texts::getText(SQLData::getLang($p),"§c§lQuitter","§c§lLeave"));
            $p->sendForm($form);
        }
    }

    public static function getStatus(Player $player, string $name){
        if(SQLData::getData($player,$name) == 1){
            return Texts::getText(SQLData::getLang($player),"CLIQUER POUR EQUIPER","CLICK FOR EQUIP");
        }else{
            $uni = Unicodes::$coin;
            return Texts::getText(SQLData::getLang($player),"ACHETER - 100 $uni","BUY - 100 $uni");
        }
    }

    public static function buyPets(Player $player, string $petName, int $price, int $playerCoins){
        if(SQLData::getData($player,$petName) == 1){
            Texts::sendMessage($player,Texts::$prefix,"Vous avez déjà ce pet","You already have that pet");
        }else{
            if($playerCoins > $price){
                SQLData::setData($player,"players",$petName,1);
                CoinsAPI::delCoins($player,$price);

                $uni = Unicodes::$coin;
                Texts::sendMessage($player,Texts::$prefix,"Vous avez acheté(e) le pet §3{$petName} §7pour §3{$price}$uni","You purchased the pet §3{$petName} §7for §3{$price}$uni");
            }else{
                Texts::sendMessage($player,Texts::$prefix,"Vous n'avez pas assez de coins pour pouvoir acheter ce pet","You don't have enough coins to be able to buy that pet..");
            }
        }
    }
}