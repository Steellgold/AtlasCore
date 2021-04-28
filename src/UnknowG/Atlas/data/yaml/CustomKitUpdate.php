<?php

namespace UnknowG\Atlas\data\yaml;

use pocketmine\Player;
use UnknowG\Atlas\Atlas;

class CustomKitUpdate
{
    public static function saveCKit(Player $player, int $healthCount, int $typeSword, int $typeArmor, int $asBow, int $bowEnchantUnbreaking, int $bowEnchantKnockback, int $bowEnchantPower, int $swordEnchantUnbreaking, int $swordEnchantFireAspect, int $swordEnchantSharpness, int $swordEnchantKnockback, int $armorEnchantUnbreaking, int $armorEnchantProtection, int $effectRegeneration, int $effectStrength, int $effectSpeed, int $effectResistance, int $effectJumpBoost, int $asGoldenApple, int $itemGoldenAppleCount, int $asEnchantedGoldenApple, int $itemEnchantedGoldenAppleCount, int $asSnowball, int $itemSnowballCount, int $asEnderPearl, int $itemEnderPearlCount, int $asSplashHealth, int $itemSplashHealth, int $asSplashWeakness, int $itemSplashWeakness, int $asSplashPoison, int $itemSplashPoison, int $asBlock, int $blocksCount){
        $file = Atlas::getFileData("CustomKits");

        $array = [
            "healthCounts" => $healthCount,
            "typeSword" => $typeSword,
            "typeArmor" => $typeArmor,
            "asBow" => $asBow,
            "bowEnchantUnbreaking" => $bowEnchantUnbreaking,
            "bowEnchantKnockback" => $bowEnchantKnockback,
            "bowEnchantPower" => $bowEnchantPower,
            "swordEnchantUnbreaking" => $swordEnchantUnbreaking,
            "swordEnchantFireAspect" => $swordEnchantFireAspect,
            "swordEnchantSharpness" => $swordEnchantSharpness,
            "swordEnchantKnockback" => $swordEnchantKnockback,
            "armorEnchantUnbreaking" => $armorEnchantUnbreaking,
            "armorEnchantProtection" => $armorEnchantProtection,
            "effectRegeneration" => $effectRegeneration,
            "effectStrength" => $effectStrength,
            "effectSpeed" => $effectSpeed,
            "effectResistance" => $effectResistance,
            "effectJumpBoost" => $effectJumpBoost,
            "asGoldenApple" => $asGoldenApple,
            "itemGoldenAppleCount" => $itemGoldenAppleCount,
            "asEnchantedGoldenApple" => $asEnchantedGoldenApple,
            "itemEnchantedGoldenAppleCount" => $itemEnchantedGoldenAppleCount,
            "asSnowball" => $asSnowball,
            "itemSnowballCount" => $itemSnowballCount,
            "asEnderPearl" => $asEnderPearl,
            "itemEnderPearlCount" => $itemEnderPearlCount,
            "asSplashHealth" => $asSplashHealth,
            "itemSplashHealth" => $itemSplashHealth,
            "asSplashWeakness" => $asSplashWeakness,
            "itemSplashWeakness" => $itemSplashWeakness,
            "asSplashPoison" => $asSplashPoison,
            "itemSplashPoison" => $itemSplashPoison,
            "asBlocks" => $asBlock,
            "blocksCount" => $blocksCount
        ];

        $file->set($player->getName(), $array);
        $file->save();
    }
}