<?php

namespace UnknowG\Atlas\forms\utils;

use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\CoinsAPI;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\data\yaml\CustomKitUpdate;
use UnknowG\Atlas\events\player\PlayerDeath;
use UnknowG\Atlas\events\player\PlayerJoin;
use UnknowG\Atlas\utils\kit\KitBuilder;
use UnknowG\Atlas\utils\RespawnUtil;
use UnknowG\Atlas\utils\texts\Texts;
use UnknowG\Atlas\utils\texts\Unicodes;

class TrainKitForm
{
    public static $armorMaterial = [
        "diamond",
        "iron"
    ];

    public static $swordMaterial = [
        "diamond",
        "iron"
    ];

    public static function open(Player $p)
    {
        $form = new SimpleForm
        (
            function (Player $p, $data) {
                if ($data === null) {
                } else {
                    switch ($data) {
                        case 0:
                            self::openCustomKit($p);
                            $p->setInvisible(true);
                            break;
                        case 1:
                            $file = Atlas::getFileData("CustomKits");
                            $data = $file->get($p->getName());
                            if($file->exists($p->getName())) {
                                foreach (Server::getInstance()->getLevelByName($p->getLevel()->getName())->getPlayers() as $players) {
                                    $players->setImmobile(false);
                                    $players->getInventory()->clearAll();
                                    $players->removeAllEffects();
                                    $players->getArmorInventory()->setContents([]);
                                    $players->setGamemode(0);

                                    /** Health */

                                    $players->setMaxHealth($data["healthCounts"]);
                                    $players->setHealth($data["healthCounts"]);

                                    /** Types of Tools */
                                    switch ($data["typeSword"]) {
                                        case 0:
                                            KitBuilder::buildSword($players, "diamond", $data["swordEnchantUnbreaking"], $data["swordEnchantFireAspect"], $data["swordEnchantSharpness"], $data["swordEnchantKnockback"]);
                                            break;
                                        case 1:
                                            KitBuilder::buildSword($players, "iron", $data["swordEnchantUnbreaking"], $data["swordEnchantFireAspect"], $data["swordEnchantSharpness"], $data["swordEnchantKnockback"]);
                                            break;
                                    }

                                    /** Types of Armor */
                                    switch ($data["typeArmor"]) {
                                        case 0:
                                            KitBuilder::buildArmor($players, "diamond", $data["armorEnchantUnbreaking"], $data["armorEnchantProtection"]);
                                            break;
                                        case 1:
                                            KitBuilder::buildArmor($players, "iron", $data["armorEnchantUnbreaking"], $data["armorEnchantProtection"]);
                                            break;
                                    }

                                    /** Bow */
                                    if ($data["asBow"] == 1) {
                                        KitBuilder::buildBow($players, $data["bowEnchantUnbreaking"], $data["bowEnchantKnockback"], $data["bowEnchantPower"]);
                                    }

                                    if ($data["effectRegeneration"] >= 1) {
                                        $players->addEffect(new EffectInstance(Effect::getEffect(10), 20 * 999999, $data["effectRegeneration"]));
                                    }
                                    if ($data["effectStrength"] >= 1) {
                                        $players->addEffect(new EffectInstance(Effect::getEffect(5), 20 * 999999, $data["effectStrength"]));
                                    }
                                    if ($data["effectSpeed"] >= 1) {
                                        $players->addEffect(new EffectInstance(Effect::getEffect(1), 20 * 999999, $data["effectSpeed"]));
                                    }
                                    if ($data["effectResistance"] >= 1) {
                                        $players->addEffect(new EffectInstance(Effect::getEffect(11), 20 * 999999, $data["effectResistance"]));

                                    }
                                    if ($data["effectJumpBoost"] >= 1) {
                                        $players->addEffect(new EffectInstance(Effect::getEffect(8), 20 * 999999, $data["effectJumpBoost"]));
                                    }

                                    if ($data["asGoldenApple"] == 1) {
                                        $gapple = Item::get(322);
                                        $gapple->setCount($data["itemGoldenAppleCount"]);
                                        $players->getInventory()->addItem($gapple);
                                    }

                                    if ($data["asEnchantedGoldenApple"] == 1) {
                                        $gapple = Item::get(466);
                                        $gapple->setCount($data["itemEnchantedGoldenAppleCount"]);
                                        $players->getInventory()->addItem($gapple);
                                    }

                                    if ($data["asSnowball"] == 1) {
                                        $snowBall = Item::get(332);
                                        $snowBall->setCount($data["itemSnowballCount"]);
                                        $players->getInventory()->addItem($snowBall);
                                    }

                                    if ($data["asEnderPearl"] == 1) {
                                        $enderPearl = Item::get(368);
                                        $enderPearl->setCount($data["itemEnderPearlCount"]);
                                        $players->getInventory()->addItem($enderPearl);
                                    }

                                    if ($data["asSplashHealth"] == 1) {
                                        $popoHeal = Item::get(438, 22);
                                        $popoHeal->setCount($data["itemSplashHealth"]);
                                        $players->getInventory()->addItem($popoHeal);
                                    }
                                    if ($data["asSplashWeakness"] == 1) {
                                        $popoWeakness = Item::get(438, 27);
                                        $popoWeakness->setCount($data["itemSplashWeakness"]);
                                        $players->getInventory()->addItem($popoWeakness);
                                    }
                                    if ($data["asSplashPoison"] == 1) {
                                        $popoPoison = Item::get(438, 35);
                                        $popoPoison->setCount($data["itemSplashPoison"]);
                                        $players->getInventory()->addItem($popoPoison);
                                    }
                                    if ($data["asBlocks"] == 1) {
                                        $players->getInventory()->addItem(Item::get(236, 14, $data["blocksCount"])->setCustomName($players->getName()));
                                    }
                                }
                            }else{
                                Texts::sendMessage($p,Texts::$prefix,"Vous n'avez sauvegarder aucun kit","You haven't saved any kits");
                            }
                            break;
                        case 2:
                            $p->setImmobile(false);
                            $p->setGamemode(0);

                            $p->getInventory()->clearAll();
                            $p->removeAllEffects();
                            RespawnUtil::giveGappleKit($p);

                            $p->addEffect(new EffectInstance(Effect::getEffect(1), 20 * 99999, 0));
                            break;
                        case 3:
                            $p->setImmobile(false);
                            $p->setGamemode(0);

                            $p->getInventory()->clearAll();
                            $p->removeAllEffects();
                            RespawnUtil::giveNodeKit($p);

                            $p->addEffect(new EffectInstance(Effect::getEffect(1), 20 * 99999, 0));
                            break;
                        case 4:
                            $p->setImmobile(false);
                            $p->setGamemode(0);

                            $p->getInventory()->clearAll();
                            $p->removeAllEffects();
                            RespawnUtil::giveArcKit($p);

                            $p->addEffect(new EffectInstance(Effect::getEffect(1), 20 * 99999, 0));
                            break;
                        case 5:
                            $p->setImmobile(false);
                            $p->getInventory()->clearAll();
                            $p->removeAllEffects();
                            RespawnUtil::giveGappleKit($p);

                            $p->addEffect(new EffectInstance(Effect::getEffect(8), 20 * 999999, 3, false));
                            break;
                        case 6:
                            $p->setImmobile(false);
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

        $form->setTitle("§lGames - Ranked");
        $form->setContent(Texts::getText(SQLData::getLang($p), "§lChoisissez le kit que vous voulez !", "§lChoose your kit do you want to play !") . "\n ");
        $uni = Unicodes::$coin;
        if (RankAPI::isPremium($p) or RankAPI::getRank($p) == "ytb") {
            if (RankAPI::isPremium($p)) {
                $form->addButton("§lCustom Kit\n§l§0GRATUIT");
            } else {
                $form->addButton("§lCustom Kit\n§l§050 $uni/kit");
            }
        } else {
            $form->addButton("§lCustom Kit\n§l§0COMMING SOON  - 50 $uni/kit");
        }

        $form->addButton("Kit §lSaved\nCustom Kit");
        $form->addButton("Kit §lGapple");
        $form->addButton("Kit §lNodebuff");
        $form->addButton("Kit §lBow");
        $form->addButton("Kit §lGravity");
        $form->addButton("§l§cReturn Hub");
        $p->sendForm($form);
    }

    public static function openCustomKit($player)
    {
        $form = new CustomForm(function (Player $player, array $data = null) {
            if (isset($data[0]) && isset($data[1]) && isset($data[2]) && isset($data[3]) && isset($data[4]) && isset($data[5]) && isset($data[6]) && isset($data[7]) && isset($data[8]) && isset($data[9]) && isset($data[10]) && isset($data[11]) && isset($data[12]) && isset($data[13]) && isset($data[14]) && isset($data[15]) && isset($data[16]) && isset($data[17]) && isset($data[18]) && isset($data[19]) && isset($data[21]) && isset($data[22]) && isset($data[23]) && isset($data[24]) && isset($data[25]) && isset($data[26]) && isset($data[27]) && isset($data[28]) && isset($data[29])) {
                if($data[34] == 0) {
                    foreach (Server::getInstance()->getLevelByName($player->getLevel()->getName())->getPlayers() as $players) {
                        $players->setImmobile(false);
                        $players->getInventory()->clearAll();
                        $players->removeAllEffects();
                        $players->getArmorInventory()->setContents([]);
                        $players->setGamemode(0);

                        /** Health */
                        $players->setMaxHealth($data[0]);
                        $players->setHealth($data[0]);

                        /** Types of Tools */
                        switch ($data[1]) {
                            case 0:
                                KitBuilder::buildSword($players, "diamond", $data[7], $data[8], $data[9], $data[10]);
                                break;
                            case 1:
                                KitBuilder::buildSword($players, "iron", $data[7], $data[8], $data[9], $data[10]);
                                break;
                        }

                        /** Types of Armor */
                        switch ($data[2]) {
                            case 0:
                                KitBuilder::buildArmor($players, "diamond", $data[11], $data[12]);
                                break;
                            case 1:
                                KitBuilder::buildArmor($players, "iron", $data[11], $data[12]);
                                break;
                        }

                        /** Bow */
                        if ($data[3] == 1) {
                            KitBuilder::buildBow($players, $data[4], $data[5], $data[6]);
                        }

                        if ($data[13] >= 1) {
                            $players->addEffect(new EffectInstance(Effect::getEffect(10), 20 * 999999, $data[13]));
                        }
                        if ($data[14] >= 1) {
                            $players->addEffect(new EffectInstance(Effect::getEffect(5), 20 * 999999, $data[14]));
                        }
                        if ($data[15] >= 1) {
                            $players->addEffect(new EffectInstance(Effect::getEffect(1), 20 * 999999, $data[15]));
                        }
                        if ($data[16] >= 1) {
                            $players->addEffect(new EffectInstance(Effect::getEffect(11), 20 * 999999, $data[16]));

                        }
                        if ($data[17] >= 1) {
                            $players->addEffect(new EffectInstance(Effect::getEffect(8), 20 * 999999, $data[17]));
                        }

                        if ($data[18] == 1) {
                            $gapple = Item::get(322);
                            $gapple->setCount($data[19]);
                            $players->getInventory()->addItem($gapple);
                        }

                        if ($data[20] == 1) {
                            $gapple = Item::get(466);
                            $gapple->setCount($data[21]);
                            $players->getInventory()->addItem($gapple);
                        }

                        if ($data[22] == 1) {
                            $snowBall = Item::get(332);
                            $snowBall->setCount($data[23]);
                            $players->getInventory()->addItem($snowBall);
                        }

                        if ($data[24] == 1) {
                            $enderPearl = Item::get(368);
                            $enderPearl->setCount($data[25]);
                            $players->getInventory()->addItem($enderPearl);
                        }

                        if ($data[26] == 1) {
                            $popoHeal = Item::get(438, 22);
                            $popoHeal->setCount($data[27]);
                            $players->getInventory()->addItem($popoHeal);
                        }
                        if ($data[28] == 1) {
                            $popoWeakness = Item::get(438, 27);
                            $popoWeakness->setCount($data[29]);
                            $players->getInventory()->addItem($popoWeakness);
                        }
                        if ($data[30] == 1) {
                            $popoPoison = Item::get(438, 35);
                            $popoPoison->setCount($data[31]);
                            $players->getInventory()->addItem($popoPoison);
                        }
                        if ($data[32] == 1) {
                            $players->getInventory()->addItem(Item::get(236, 14, $data[33])->setCustomName($players->getName()));
                        }


                        if (!RankAPI::isPremium($player)) {
                            $uni = Unicodes::$coin;
                            if (CoinsAPI::getCoins($player) >= 50) {
                                Texts::sendMessage($player, Texts::$prefix, "Vous avez payé §350 $uni pour pouvoir faire ce kit personnalisé !", "You paid §350 $uni §7to be able to make this custom kit!");

                                $player->setInvisible(false);
                                CoinsAPI::delCoins($player, 50);
                            } else {
                                Texts::sendMessage($player, Texts::$prefix, "Vous n'avez pas assez de coins pour pouvoir crée se kit", "You don't have enough coins to create this kit");
                                $player->setInvisible(false);
                            }
                        } else {
                            Texts::sendMessage($player, Texts::$prefixPrenium, "Grâce à votre grade §gPremium§7, la création d'un kit personnalisé est gratuit ", "Thanks to your rank §gPremium§7, the creation of a personalized kit is free!");
                            $player->setInvisible(false);
                        }
                    }
                }else{
                    $player->setInvisible(false);
                    CustomKitUpdate::saveCKit($player,$data[0],$data[1],$data[2],$data[3],$data[4],$data[5],$data[6],$data[7],$data[8],$data[9],$data[10],$data[11],$data[12],$data[13],$data[14],$data[15],$data[16],$data[17],$data[18],$data[19],$data[20],$data[21],$data[22],$data[23],$data[24],$data[25],$data[26],$data[27],$data[28],$data[29],$data[30],$data[31],$data[32],$data[33]);
                    Texts::sendMessage($player,Texts::$prefix,"Vous avez crée le kit, cliquez sur le bouton §lKit sauvegardée §r§7 pour l'obtenir",'You have created the kit, click on the button §lKit saved §r§7 to get it');
                }
            } else {
                Texts::sendMessage($player,Texts::$prefix,"Donc vous ne voulez pas d'un kit personnalisé... c'est dommage.","So you don't want a custom kit... that's too bad.");
                $player->setInvisible(false);
            }
        });
        
        
        $form->setTitle("§lCustom Kit");
        $form->addSlider(Texts::getText(SQLData::getLang($player),"§l» §r§7Nombres de coeurs de vies","§l» §r§7Number of hearts of life"),1,500,1,20);
        /** Types */
        $form->addDropdown(Texts::getText(SQLData::getLang($player),"§l» §r§7Type d'épée","§l» §r§7Sword materials"),TrainKitForm::$swordMaterial);
        $form->addDropdown(Texts::getText(SQLData::getLang($player),"§l» §r§7Type d'Armure","§l» §r§7Armor materials"),TrainKitForm::$armorMaterial);
        $form->addToggle(Texts::getText(SQLData::getLang($player),"§l» §r§7Arc","§l» §r§7Bow"),0);
        /** Enchantements */
        $form->addSlider(Texts::getText(SQLData::getLang($player),"§l» §r§7[Arc] Enchantement Solidité","§l» §r§7 [Bow] Enchantment Unbreaking"),0,10);
        $form->addSlider(Texts::getText(SQLData::getLang($player),"§l» §r§7[Arc] Enchantement Recul","§l» §r§7 [Bow] Enchantment Knockback"),0,10);
        $form->addSlider(Texts::getText(SQLData::getLang($player),"§l» §r§7[Arc] Enchantement Puissance","§l» §r§7 [Bow] Enchantment Power"),0,10);
        $form->addSlider(Texts::getText(SQLData::getLang($player),"§l» §r§7[Epée] Enchantement Solidité","§l» §r§7 [Sword] Enchantment Unbreaking"),0,10);
        $form->addSlider(Texts::getText(SQLData::getLang($player),"§l» §r§7[Epée] Enchantement Aura de Feu","§l» §r§7 [Sword] Enchantment Fire Aspect"),0,10);
        $form->addSlider(Texts::getText(SQLData::getLang($player),"§l» §r§7[Epée] Enchantement Tranchant","§l» §r§7 [Sword] Enchantment Sharpness"),0,50);
        $form->addSlider(Texts::getText(SQLData::getLang($player),"§l» §r§7[Epée] Enchantement Recul","§l» §r§7 [Sword] Enchantment Knockback"),0,10);
        $form->addSlider(Texts::getText(SQLData::getLang($player),"§l» §r§7[Armure] Enchantement Solidité","§l» §r§7 [Armor] Enchantment Unbreaking"),0,10);
        $form->addSlider(Texts::getText(SQLData::getLang($player),"§l» §r§7[Armure] Enchantement Protection","§l» §r§7 [Armor] Enchantment Protection"),0,5);
        /** Effects */
        $form->addSlider(Texts::getText(SQLData::getLang($player),"§l» §r§7Effet de Regeneration","§l» §r§7Effect of Regeneration"),0,10);
        $form->addSlider(Texts::getText(SQLData::getLang($player),"§l» §r§7Effet de Force","§l» §r§7Effect of Strength"),0,10);
        $form->addSlider(Texts::getText(SQLData::getLang($player),"§l» §r§7Effet de Vitesse","§l» §r§7Effect of Speed"),0,10);
        $form->addSlider(Texts::getText(SQLData::getLang($player),"§l» §r§7Effet de Resistance","§l» §r§7Effect of Resistance"),0,10);
        $form->addSlider(Texts::getText(SQLData::getLang($player),"§l» §r§7Effet de Saut","§l» §r§7Effect of Jump Boost"),0,10);
        /** Items */
        $form->addToggle(Texts::getText(SQLData::getLang($player),"§l» §r§7Pommes en Or","§l» §r§7Golden Apple"),0);
        $form->addSlider(Texts::getText(SQLData::getLang($player),"Quantité","Quantity"),1,64);
        $form->addToggle(Texts::getText(SQLData::getLang($player),"§l» §r§7Pommes Enchanté en Or","§l» §r§7Enchanted Golden Apple"),0);
        $form->addSlider(Texts::getText(SQLData::getLang($player),"Quantité","Quantity"),1,64);
        $form->addToggle(Texts::getText(SQLData::getLang($player),"§l» §r§7Boules de Neige","§l» §r§7Snowball"),0);
        $form->addSlider(Texts::getText(SQLData::getLang($player),"Quantité","Quantity"),16,183);
        $form->addToggle(Texts::getText(SQLData::getLang($player),"§l» §r§7Ender Pearl","§l» §r§7Ender Pearl"),0);
        $form->addSlider(Texts::getText(SQLData::getLang($player),"Quantité","Quantity"),1,16);
        /** Splash Potion */
        $form->addToggle(Texts::getText(SQLData::getLang($player),"§l» §r§7Potion jetable de Soins","§l» §r§7Splash Potion of Healing"),0);
        $form->addSlider(Texts::getText(SQLData::getLang($player),"Quantité","Quantity"),1,50);
        $form->addToggle(Texts::getText(SQLData::getLang($player),"§l» §r§7Potion jetable de Faiblesse","§l» §r§7Splash Potion of Weakness"),0);
        $form->addSlider(Texts::getText(SQLData::getLang($player),"Quantité","Quantity"),1,50);
        $form->addToggle(Texts::getText(SQLData::getLang($player),"§l» §r§7Potion jetable de Poison","§l» §r§7Splash Potion of Poison"),0);
        $form->addSlider(Texts::getText(SQLData::getLang($player),"Quantité","Quantity"),1,50);

        /** Blocs */
        $form->addToggle(Texts::getText(SQLData::getLang($player),"§l» §r§7Blocs","§l» §r§7Blocks"),0);
        $form->addSlider(Texts::getText(SQLData::getLang($player),"Quantité","Quantity"),1,256);

        $form->addDropdown(Texts::getText(SQLData::getLang($player),"§l» §r§7Que choisissez vous ?","§l» §r§7What do you choose ?"),["Play","Save"],1);
        $form->sendToPlayer($player);
    }
}