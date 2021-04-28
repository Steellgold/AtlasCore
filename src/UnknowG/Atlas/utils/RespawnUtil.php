<?php

namespace UnknowG\Atlas\utils;

use pocketmine\entity\Effect;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\Player;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\hikabrain\manager\Utils;

class RespawnUtil
{
    public static function giveGappleKit(Player $player)
    {
        $helmet = Item::get(310);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 3);
        $helmet->addEnchantment($eff);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3);
        $helmet->addEnchantment($eff);

        $chest = Item::get(311);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 3);
        $chest->addEnchantment($eff);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3);
        $chest->addEnchantment($eff);

        $jamb = Item::get(312);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 3);
        $jamb->addEnchantment($eff);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3);
        $jamb->addEnchantment($eff);

        $botte = Item::get(313);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 3);
        $botte->addEnchantment($eff);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3);
        $botte->addEnchantment($eff);

        $player->getArmorInventory()->setItem(0, $helmet);
        $player->getArmorInventory()->setItem(1, $chest);
        $player->getArmorInventory()->setItem(2, $jamb);
        $player->getArmorInventory()->setItem(3, $botte);

        $sw = Item::get(276);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS), 3);
        $sw->addEnchantment($eff);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3);
        $sw->addEnchantment($eff);

        $gap = Item::get(322);
        $gap->setCount(5);

        $pioche = Item::get(278);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::EFFICIENCY), 1);
        $pioche->addEnchantment($eff);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::EFFICIENCY), 1);
        $pioche->addEnchantment($eff);

        $player->getInventory()->clearAll();
        $player->getInventory()->setItem(0,$sw);
        $player->getInventory()->setItem(1,$gap);
        $player->getInventory()->setItem(8,$pioche);
    }

    public static function giveBuildKit(Player $player)
    {
        $helmet = Item::get(310);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 3);
        $helmet->addEnchantment($eff);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3);
        $helmet->addEnchantment($eff);
        $player->getArmorInventory()->setHelmet($helmet);

        $chest = Item::get(311);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 3);
        $chest->addEnchantment($eff);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3);
        $chest->addEnchantment($eff);
        $player->getArmorInventory()->setChestplate($chest);

        $jamb = Item::get(312);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 3);
        $jamb->addEnchantment($eff);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3);
        $jamb->addEnchantment($eff);
        $player->getArmorInventory()->setLeggings($jamb);

        $botte = Item::get(313);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 3);
        $botte->addEnchantment($eff);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3);
        $botte->addEnchantment($eff);
        $player->getArmorInventory()->setBoots($botte);

        $lava = Item::get(Item::BUCKET,10);
        $lava->setCount(1);
        $lava->setCustomName("Build UHC");
        $water = Item::get(Item::BUCKET,8);
        $water->setCount(1);
        $water->setCustomName("Build UHC");

        $planks = Item::get(Item::PLANKS,mt_rand(0,5));
        $planks->setCount(64);
        $planks->setCustomName("Build UHC");
        $cobble = Item::get(Item::COBBLESTONE);
        $cobble->setCount(64);
        $cobble->setCustomName("Build UHC");

        $bow = Item::get(Item::BOW);
        $bow->setCount(1);
        $pioche = Item::get(Item::DIAMOND_PICKAXE);
        $pioche->setCount(1);
        $hache = Item::get(Item::DIAMOND_AXE);
        $hache->setCount(1);
        $arrow = Item::get(Item::ARROW,0);
        $arrow->setCount(128);
        $gapple = Item::get(Item::GOLDEN_APPLE);
        $gapple->setCount(10);

        $sharpness = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS),3);
        $unbreaking = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING),3);
        $sw = Item::get(Item::DIAMOND_SWORD);
        $sw->setCount(1);
        $sw->addEnchantment($sharpness);
        $sw->addEnchantment($unbreaking);

        $player->getInventory()->clearAll();
        $player->getInventory()->addItem($sw);
        $player->getInventory()->addItem($lava);
        $player->getInventory()->addItem($bow);
        $player->getInventory()->addItem($pioche);
        $player->getInventory()->addItem($hache);
        $player->getInventory()->addItem($cobble);
        $player->getInventory()->addItem($planks);
        $player->getInventory()->addItem($gapple);
        $player->getInventory()->addItem($water);
        $player->getInventory()->addItem($water);
        $player->getInventory()->addItem($arrow);
        $player->getInventory()->addItem($lava);
        $player->getInventory()->addItem($water);
        $player->getInventory()->addItem($lava);
        $player->getInventory()->addItem($water);
    }

    public static function giveNodeKit(Player $player)
    {
        $helmet = Item::get(310);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 3);
        $helmet->addEnchantment($eff);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3);
        $helmet->addEnchantment($eff);

        $chest = Item::get(311);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 3);
        $chest->addEnchantment($eff);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3);
        $chest->addEnchantment($eff);

        $jamb = Item::get(312);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 3);
        $jamb->addEnchantment($eff);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3);
        $jamb->addEnchantment($eff);

        $botte = Item::get(313);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 3);
        $botte->addEnchantment($eff);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3);
        $botte->addEnchantment($eff);

        $player->getArmorInventory()->setItem(0, $helmet);
        $player->getArmorInventory()->setItem(1, $chest);
        $player->getArmorInventory()->setItem(2, $jamb);
        $player->getArmorInventory()->setItem(3, $botte);

        $sw = Item::get(276);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS), 3);
        $sw->addEnchantment($eff);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3);
        $sw->addEnchantment($eff);

        $popoheal = Item::get(438, 22, 34);
        $ep = Item::get(368, 0, 16);

        $player->getInventory()->clearAll();
        $player->getInventory()->setItem(0, $sw);
        $player->getInventory()->setItem(1, $ep);
        $player->getInventory()->addItem($popoheal);
    }

    public static function giveArcKit(Player $player)
    {
        $helmet = Item::get(298);
        $chest = Item::get(299);
        $jamb = Item::get(300);
        $botte = Item::get(301);

        $player->getArmorInventory()->setItem(0, $helmet);
        $player->getArmorInventory()->setItem(1, $chest);
        $player->getArmorInventory()->setItem(2, $jamb);
        $player->getArmorInventory()->setItem(3, $botte);

        $arc = Item::get(261);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::POWER), 1);
        $arc->addEnchantment($eff);
        $eff = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3);
        $arc->addEnchantment($eff);

        $arr = Item::get(262);
        $arr->setCount(1028);

        $player->getInventory()->clearAll();
        $player->getInventory()->setItem(0,$arc);
        $player->getInventory()->addItem($arr);
    }

    public static function giveNinjaKit(Player $player)
    {
        $helmet = Item::get(310);
        $chest = Item::get(311);
        $jamb = Item::get(312);
        $botte = Item::get(313);

        $player->getArmorInventory()->setItem(0, $helmet);
        $player->getArmorInventory()->setItem(1, $chest);
        $player->getArmorInventory()->setItem(2, $jamb);
        $player->getArmorInventory()->setItem(3, $botte);

        $sword = Item::get(276);
        $snow = Item::get(332);
        $snow->setCount((int) 576);

        $player->setHealth(20);

        $player->getInventory()->clearAll();
        $player->getInventory()->setItem(0,$sword);
        $player->getInventory()->addItem($snow);

    }

    public static function giveHIKAKit(Player $player)
    {
        $prCuir = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 2);
        $prIron = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 3);

        $helmet = Item::get(298);
        $chest = Item::get(299);
        $jamb = Item::get(308);
        $botte = Item::get(309);

        $helmet->addEnchantment($prCuir);
        $chest->addEnchantment($prCuir);
        $jamb->addEnchantment($prIron);
        $botte->addEnchantment($prIron);

        $player->getArmorInventory()->setItem(0, $helmet);
        $player->getArmorInventory()->setItem(1, $chest);
        $player->getArmorInventory()->setItem(2, $jamb);
        $player->getArmorInventory()->setItem(3, $botte);

        $sword = Item::get(Item::IRON_SWORD);
        $sharpness = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS), 1);
        $sword->addEnchantment($sharpness);

        $pickaxe = Item::get(Item::IRON_PICKAXE);
        $efficieny = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::EFFICIENCY), 3);
        $pickaxe->addEnchantment($efficieny);

        $gapp = Item::get(322);
        $gapp->setCount(2);

        $sand = Item::get(24,0);
        $sand->setCount(2112);

        $player->getInventory()->clearAll();
        $player->getInventory()->setItem(0,$sword);
        $player->getInventory()->addItem($gapp);
        $player->getInventory()->addItem($pickaxe);
        $player->getInventory()->addItem($sand);
    }

    public static function giveHIKAKit2(Player $player)
    {
        $prCuir = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 2);
        $prIron = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 3);

        $helmet = Item::get(298);
        $chest = Item::get(299);
        $jamb = Item::get(308);
        $botte = Item::get(309);

        $helmet->addEnchantment($prCuir);
        $chest->addEnchantment($prCuir);
        $jamb->addEnchantment($prIron);
        $botte->addEnchantment($prIron);

        $player->getArmorInventory()->setItem(0, $helmet);
        $player->getArmorInventory()->setItem(1, $chest);
        $player->getArmorInventory()->setItem(2, $jamb);
        $player->getArmorInventory()->setItem(3, $botte);

        $sword = Item::get(Item::IRON_SWORD);
        $sharpness = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS), 2);
        $sword->addEnchantment($sharpness);

        $pickaxe = Item::get(Item::IRON_PICKAXE);
        $efficieny = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::EFFICIENCY), 3);
        $pickaxe->addEnchantment($efficieny);

        $gapp = Item::get(322);
        $gapp->setCount(2);

        $sand = Item::get(24,0);
        $sand->setCount(2112);

        $player->getInventory()->clearAll();
        $player->getInventory()->setItem(0,$sword);
        $player->getInventory()->addItem($gapp);
        $player->getInventory()->addItem($pickaxe);
        $player->getInventory()->addItem($sand);
    }

    public static function giveHIKAKit3(Player $player)
    {
        $prCuir = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 2);
        $prIron = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 3);

        $helmet = Item::get(298);
        $chest = Item::get(299);
        $jamb = Item::get(312);
        $botte = Item::get(313);

        $helmet->addEnchantment($prCuir);
        $chest->addEnchantment($prCuir);
        $jamb->addEnchantment($prIron);
        $botte->addEnchantment($prIron);

        $player->getArmorInventory()->setItem(0, $helmet);
        $player->getArmorInventory()->setItem(1, $chest);
        $player->getArmorInventory()->setItem(2, $jamb);
        $player->getArmorInventory()->setItem(3, $botte);

        $sword = Item::get(Item::IRON_SWORD);
        $sharpness = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS), 2);
        $sword->addEnchantment($sharpness);

        $pickaxe = Item::get(Item::IRON_PICKAXE);
        $efficieny = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::EFFICIENCY), 3);
        $pickaxe->addEnchantment($efficieny);

        $gapp = Item::get(322);
        $gapp->setCount(2);

        $sand = Item::get(24,0);
        $sand->setCount(2112);

        $player->getInventory()->clearAll();
        $player->getInventory()->setItem(0,$sword);
        $player->getInventory()->addItem($gapp);
        $player->getInventory()->addItem($pickaxe);
        $player->getInventory()->addItem($sand);
    }
}