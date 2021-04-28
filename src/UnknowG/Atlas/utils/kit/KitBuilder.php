<?php

namespace UnknowG\Atlas\utils\kit;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\Player;

class KitBuilder{
    public static function buildSword(Player $player, string $type, int $unbreakingLevel, int $fireAspect, int $sharpnessLevel, int $knockbackLevel){
        if($type == "diamond") {
            $sword = Item::get(276);
        }elseif($type == "iron") {
            $sword = Item::get(267);
        }else{
            $sword = Item::get(267);
        }

        if(!$unbreakingLevel == 0){
            $encUnbreaking = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), $unbreakingLevel);
            $sword->addEnchantment($encUnbreaking);
        }
        if(!$fireAspect == 0){
            $encFireAspect = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::FIRE_ASPECT), $fireAspect);
            $sword->addEnchantment($encFireAspect);
        }
        if(!$sharpnessLevel == 0){
            $encSharpness = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS), $sharpnessLevel);
            $sword->addEnchantment($encSharpness);
        }
        if(!$knockbackLevel == 0){
            $encKnockback = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::KNOCKBACK), $knockbackLevel);
            $sword->addEnchantment($encKnockback);
        }

        $player->getInventory()->addItem($sword);
    }

    public static function buildArmor(Player $player, string $type, int $unbreakingLevel, int $protectionLevel){
        if($type == "diamond") {
            $diamondHelmet = Item::get(310);
            $diamondChestplate = Item::get(311);
            $diamondLeggings = Item::get(312);
            $diamondBoots = Item::get(313);
        }elseif($type == "iron") {
            $ironHelmet = Item::get(306);
            $ironChestplate = Item::get(307);
            $ironLeggings = Item::get(308);
            $ironBoots = Item::get(309);
        }else{
            $ironHelmet = Item::get(306);
            $ironChestplate = Item::get(307);
            $ironLeggings = Item::get(308);
            $ironBoots = Item::get(309);
        }

        if(!$unbreakingLevel == 0){
            $encUnbreaking = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), $unbreakingLevel);
            if($type == "diamond") {
                $diamondHelmet->addEnchantment($encUnbreaking);
                $diamondChestplate->addEnchantment($encUnbreaking);
                $diamondLeggings->addEnchantment($encUnbreaking);
                $diamondBoots->addEnchantment($encUnbreaking);
            }elseif($type == "iron") {
                $ironHelmet->addEnchantment($encUnbreaking);
                $ironChestplate->addEnchantment($encUnbreaking);
                $ironLeggings->addEnchantment($encUnbreaking);
                $ironBoots->addEnchantment($encUnbreaking);
            }else{
                $ironHelmet->addEnchantment($encUnbreaking);
                $ironChestplate->addEnchantment($encUnbreaking);
                $ironLeggings->addEnchantment($encUnbreaking);
                $ironBoots->addEnchantment($encUnbreaking);
            }
        }
        if(!$protectionLevel == 0){
            $encProtection = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), $protectionLevel);
            if($type == "diamond") {
                $diamondHelmet->addEnchantment($encProtection);
                $diamondChestplate->addEnchantment($encProtection);
                $diamondLeggings->addEnchantment($encProtection);
                $diamondBoots->addEnchantment($encProtection);
            }elseif($type == "iron") {
                $ironHelmet->addEnchantment($encProtection);
                $ironChestplate->addEnchantment($encProtection);
                $ironLeggings->addEnchantment($encProtection);
                $ironBoots->addEnchantment($encProtection);
            }else{
                $ironHelmet->addEnchantment($encProtection);
                $ironChestplate->addEnchantment($encProtection);
                $ironLeggings->addEnchantment($encProtection);
                $ironBoots->addEnchantment($encProtection);
            }
        }

        if($type == "diamond") {
            $player->getArmorInventory()->setHelmet($diamondHelmet);
            $player->getArmorInventory()->setChestplate($diamondChestplate);
            $player->getArmorInventory()->setLeggings($diamondLeggings);
            $player->getArmorInventory()->setBoots($diamondBoots);
        }elseif($type == "iron") {
            $player->getArmorInventory()->setHelmet($ironHelmet);
            $player->getArmorInventory()->setChestplate($ironChestplate);
            $player->getArmorInventory()->setLeggings($ironLeggings);
            $player->getArmorInventory()->setBoots($ironBoots);
        }else{
            $player->getArmorInventory()->setHelmet($ironHelmet);
            $player->getArmorInventory()->setChestplate($ironChestplate);
            $player->getArmorInventory()->setLeggings($ironLeggings);
            $player->getArmorInventory()->setBoots($ironBoots);
        }
    }

    public static function buildBow(Player $player, int $unbreakingLevel, int $punchLevel, $powerLevel){
        $bow = Item::get(261);
        $arrow = Item::get(262)->setCount(128);

        if(!$unbreakingLevel == 0){
            $encUnbreaking = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), $unbreakingLevel);
            $bow->addEnchantment($encUnbreaking);
        }
        if(!$punchLevel == 0){
            $encKnockback = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PUNCH), $punchLevel);
            $bow->addEnchantment($encKnockback);
        }
        if(!$powerLevel == 0){
            $encPower = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS), $powerLevel);
            $bow->addEnchantment($encPower);
        }

        $player->getInventory()->addItem($bow);
        $player->getInventory()->addItem($arrow);
    }
}