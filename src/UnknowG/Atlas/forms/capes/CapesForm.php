<?php

namespace UnknowG\Atlas\forms\capes;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\entity\Skin;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\CoinsAPI;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;
use UnknowG\Atlas\utils\texts\Unicodes;

class CapesForm extends SimpleForm{

    public static $dark = 50;
    public static $nike = 50;
    public static $flash = 100;
    public static $galaxy = 100;
    public static $alchimist = 100;
    public static $nutella = 200;
    public static $king = 150;
    public static $dragon = 500;

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
                                self::removeCape($p);
                                break;
                            case 1:
                                if (SQLData::getData($p, "capeDark") == 1) {
                                    self::setCape($p, "capeDark");
                                    Texts::sendMessage($p, Texts::$prefix, "Vous avez équiper §3capeDark", "You have set §3capeDark");
                                } else {
                                    self::buyCape($p, "capeDark", self::$dark, CoinsAPI::getCoins($p));
                                }
                                break;
                            case 2:
                                if (SQLData::getData($p, "capeNike") == 1) {
                                    self::setCape($p, "capeNike");
                                    Texts::sendMessage($p, Texts::$prefix, "Vous avez équiper §3capeNike", "You have set §3capeNike");
                                } else {
                                    self::buyCape($p, "capeNike", self::$nike, CoinsAPI::getCoins($p));
                                }
                                break;
                            case 3:
                                if (SQLData::getData($p, "capeFlash") == 1) {
                                    self::setCape($p, "capeFlash");
                                    Texts::sendMessage($p, Texts::$prefix, "Vous avez équiper §3capeFlash", "You have set §3capeFlash");
                                } else {
                                    self::buyCape($p, "capeFlash", self::$flash, CoinsAPI::getCoins($p));
                                }
                                break;
                            case 4:
                                if (SQLData::getData($p, "capeNutella") == 1) {
                                    self::setCape($p, "capeNutella");
                                    Texts::sendMessage($p, Texts::$prefix, "Vous avez équiper §3capeNutella", "You have set §3capeNutella");
                                } else {
                                    self::buyCape($p, "capeNutella", self::$nutella, CoinsAPI::getCoins($p));
                                }
                                break;
                            case 5:
                                if (SQLData::getData($p, "capeGalaxy") == 1) {
                                    self::setCape($p, "capeGalaxy");
                                    Texts::sendMessage($p, Texts::$prefix, "Vous avez équiper §3capeGalaxy", "You have set §3capeGalaxy");
                                } else {
                                    self::buyCape($p, "capeGalaxy", self::$galaxy, CoinsAPI::getCoins($p));
                                }
                                break;
                            case 6:
                                if (SQLData::getData($p, "capeAlchemist") == 1) {
                                    self::setCape($p, "capeAlchemist");
                                    Texts::sendMessage($p, Texts::$prefix, "Vous avez équiper §3capeAlchemist", "You have set §3capeAlchemist");
                                } else {
                                    self::buyCape($p, "capeAlchemist", self::$alchimist, CoinsAPI::getCoins($p));
                                }
                                break;
                            case 7:
                                if (SQLData::getData($p, "capeKing") == 1) {
                                    self::setCape($p, "capeKing");
                                    Texts::sendMessage($p, Texts::$prefix, "Vous avez équiper §3capeKing", "You have set §3capeKing");
                                } else {
                                    self::buyCape($p, "capeKing", self::$king, CoinsAPI::getCoins($p));
                                }
                                break;
                            case 8:
                                if (SQLData::getData($p, "capeDragon") == 1) {
                                    self::setCape($p, "capeDragon");
                                    Texts::sendMessage($p, Texts::$prefix, "Vous avez équiper §3capeDragon", "You have set §3capeDragon");
                                } else {
                                    self::buyCape($p, "capeDragon", self::$dragon, CoinsAPI::getCoins($p));
                                }
                                break;
                            case 9:
                                if(RankAPI::isYtb($p)){
                                    self::setCape($p, "capeYoutube");
                                    Texts::sendMessage($p, Texts::$prefixYtb, "Vous avez équiper §ccapeYoutube", "You have set §ccapeYoutube");
                                }else{
                                    Texts::sendMessage($p, Texts::$prefixYtb, "Vous n'avez pas accès au capes du grade §cYouTube", "You do not have access to the rank capes §cYouTube");
                                }
                                break;
                            case 10:
                                if(RankAPI::isPremium($p)){
                                    self::setCape($p, "capePremium");
                                    Texts::sendMessage($p, Texts::$prefixPrenium, "Vous avez équiper §gcapePaypal", "You have set §gcapePremium");
                                } else {
                                    Texts::sendMessage($p, Texts::$prefixPrenium, "Vous n'avez pas accès au capes du grade §gcapePaypal", "You do not have access to the rank capes §gcapePaypal");
                                }
                                break;
                            case 11:
                                if($p->getName() == "MymaQc" or $p->getName() == "Steellg0ld"){
                                    self::setCape($p, "capeTest");
                                    Texts::sendMessage($p, Texts::$prefixPrenium, "Vous avez équiper §3capeTest", "You have set §3Test");
                                } else {
                                    Texts::sendMessage($p, Texts::$prefixPrenium, "Vous n'avez pas accès au capes du grade §gcapePaypal", "You do not have access to the rank capes §gcapePaypal");
                                }
                                break;
                            break;
                        }
                    }
                }
            );

            $galaxy = self::getStatus($p,"capeGalaxy",100);
            $alchemist = self::getStatus($p,"capeAlchemist",100);
            $king = self::getStatus($p,"capeKing",150);
            $dragon = self::getStatus($p,"capeDragon",500);
            $dark = self::getStatus($p,"capeDark",50);
            $nike = self::getStatus($p,"capeNike",50);
            $flash = self::getStatus($p,"capeFlash",100);
            $nutella = self::getStatus($p,"capeNutella",200);

            $form->setTitle("Capes");
            $form->setContent("§l§7» §r§7" . Texts::getText(SQLData::getLang($p),"Un peu plus de style à son skin sa ne fait pas de mal","A little more style to his skin doesn't hurt."));

            $form->addButton(Texts::getText(SQLData::getLang($p),"§c§lRetiré la cape","§c§lRemove the cape"));
            $form->addButton(Texts::getText(SQLData::getLang($p),"Cape noir","Dark Cape") . "\n$dark");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Cape Nike","Nike cape") . "\n$nike");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Cape Flash","Flash cape") . "\n$flash");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Cape Nutella","Nutella cape") . "\n$nutella");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Galaxie","Galaxy") . "\n$galaxy");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Alchimiste","Alchemist") . "\n$alchemist");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Cape de Roi","King") . "\n$king");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Derière de Dragon","Dragon's Back") . "\n$dragon");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Bouton Lire","Play Button") . "\n§lYouTube");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Cape Paypal","Paypal cape") . "\n§lPremium");
            if($p->getName() == "MymaQc" or $p->getName() == "Steellg0ld"){
                $form->addButton(Texts::getText(SQLData::getLang($p),"Cape personnel à MymaQC","Personal Cape for MymaQC") . "\n§lPremium");
            }
            $p->sendForm($form);
        }
    }

    public static function getStatus(Player $player, string $name,int $price){
        if(SQLData::getData($player,$name) == 1){
            return Texts::getText(SQLData::getLang($player),"CLIQUER POUR EQUIPER","CLICK FOR EQUIP");
        }else{
            $uni = Unicodes::$coin;
            return Texts::getText(SQLData::getLang($player),"ACHETER - $price $uni","BUY - $price $uni");
        }
    }

    public static function buyCape(Player $player, string $capeName, int $price, int $playerCoins){
        if(SQLData::getData($player,$capeName) == 1){
            Texts::sendMessage($player,Texts::$prefix,"Vous avez déjà cette cape","You already have that cape");
        }else{
            if($playerCoins > $price){
                SQLData::setData($player,"players",$capeName,1);
                CoinsAPI::delCoins($player,$price);

                $player->getInventory()->setContents([]);
                $player->getArmorInventory()->setContents([]);
                $player->getEnderChestInventory()->setContents([]);

                $uni = Unicodes::$coin;
                Texts::sendMessage($player,Texts::$prefix,"Vous avez acheté(e) la cape §3{$capeName} §7pour §3{$price}$uni","You purchased the cape §3{$capeName} §7for §3{$price}$uni");
            }else{
                Texts::sendMessage($player,Texts::$prefix,"Vous n'avez pas assez de coins pour pouvoir acheter cette cape","You don't have enough coins to be able to buy that cape..");
            }
        }
    }

    public static function setCape(Player $player,string $capeName){
        $oldSkin = $player->getSkin();
        $capeData = Atlas::getInstance()->pngToData(Atlas::getImageFile($capeName));
        $setCape = new Skin($oldSkin->getSkinId(), $oldSkin->getSkinData(), $capeData, $oldSkin->getGeometryName(), $oldSkin->getGeometryData());
        $player->setSkin($setCape);
        $player->sendSkin();
    }

    public static function removeCape(Player $player){
        $oldSkin = $player->getSkin();
        $setCape = new Skin($oldSkin->getSkinId(), $oldSkin->getSkinData(), "", $oldSkin->getGeometryName(), $oldSkin->getGeometryData());
        $player->setSkin($setCape);
        $player->sendSkin();
    }
}