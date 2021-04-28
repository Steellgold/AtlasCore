<?php

namespace UnknowG\Atlas\events\block;

use pocketmine\event\block\BlockUpdateEvent;
use pocketmine\event\Listener;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\task\block\BlockPlacedTask;

class BlockUpdate implements Listener{

    public $plugin;
    public function __construct(Atlas $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onUpdate(BlockUpdateEvent $e){
        $b = $e->getBlock();
        if ($b->getId() == 10 or $b->getId() == 11 or $b->getId() == 8 or $b->getId() == 9) {
            $this->plugin->getScheduler()->scheduleDelayedTask(new BlockPlacedTask($b), 20 * 10);
        }
    }
}