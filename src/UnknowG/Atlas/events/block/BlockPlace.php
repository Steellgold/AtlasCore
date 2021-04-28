<?php

namespace UnknowG\Atlas\events\block;

use pocketmine\block\Block;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\task\block\BlockPlacedTask;

class BlockPlace implements Listener
{
    public $plugin;

    public function __construct(Atlas $atlas)
    {
        $this->plugin = $atlas;
    }

    public function onPlace(BlockPlaceEvent $e)
    {
        $p = $e->getPlayer();
        $b = $e->getBlock();
        $i = $e->getItem();

        if ($i->getCustomName() == $p->getName()) {
            $this->plugin->getScheduler()->scheduleDelayedTask(new BlockPlacedTask($b), 20 * 10);
        } elseif ($p->getLevel()->getName() == "builduhc") {
            if($i->getName() == "Build UHC"){
                $this->plugin->getScheduler()->scheduleDelayedTask(new BlockPlacedTask($b), 20 * 30);
            }else{
                if (!$p->isOp()) {
                    $e->setCancelled();
                }
            }
        } else {
            if (!$p->isOp()) {
                $e->setCancelled();
            }
        }
    }
}