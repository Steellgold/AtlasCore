<?php

namespace UnknowG\Atlas\items;

use pocketmine\entity\Entity;
use pocketmine\item\Durable;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\AnimatePacket;
use pocketmine\Player;

class Rod extends Durable
{
    public function __construct($meta = 0){
        parent::__construct(\pocketmine\item\Item::FISHING_ROD, $meta, "Fishing Rod");
    }

    public function getMaxStackSize(): int{
        return 1;
    }

    public function getCooldownTicks(): int{
        return 5;
    }

    public function getMaxDurability(): int{
        return 355;
    }

    public function onClickAir(Player $player, Vector3 $directionVector): bool{
        if (!$player->hasItemCooldown($this)) {
            $player->resetItemCooldown($this);

            if (Item::getFishingHook($player) === NULL) {
                $motion = $player->getDirectionVector();
                $motion = $motion->multiply(0.4);
                $nbt = Entity::createBaseNBT($player->add(0, $player->getEyeHeight(), 0), $motion);
                $hook = Entity::createEntity("FishingHook", $player->level, $nbt, $player);
                $hook->spawnToAll();
            } else {
                $hook = Item::getFishingHook($player);
                $hook->flagForDespawn();
                Item::setFishingHook(NULL, $player);
            }
            $player->broadcastEntityEvent(AnimatePacket::ACTION_SWING_ARM);
            return TRUE;
        }
        return FALSE;
    }

    public function getProjectileEntityType(): string{
        return "Hook";
    }

    public function getThrowForce(): float{
        return 0.9;
    }
}