<?php

namespace UnknowG\Atlas\events\block;

use pocketmine\block\Block;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\Server;
use UnknowG\Atlas\api\GoldAPI;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\task\block\gold\EndStoneReplacerTask;
use UnknowG\Atlas\task\block\gold\GoldBlockReplaceTask;
use UnknowG\Atlas\task\block\gold\GoldOreReplaceTask;
use UnknowG\Atlas\task\block\gold\QuartzBlockReplacerTask;

class BlockBreak implements Listener
{
    public $plugin;

    public function __construct(Atlas $atlas)
    {
        $this->plugin = $atlas;
    }

    public function onBreak(BlockBreakEvent $e)
    {
        $p = $e->getPlayer();
        $b = $e->getBlock();
        $i = $e->getItem();

        if ($b->getId() == Block::GOLD_ORE) {
            $mtRand = mt_rand(1,2);
            if($mtRand == 2){
                $e->setDrops([Item::get(266,0)->setCount(2)]);
                GoldAPI::addGold($p,2);
            }else{
                $e->setDrops([Item::get(266,0)->setCount(1)]);
                GoldAPI::addGold($p,1);
            }
            $this->plugin->getScheduler()->scheduleDelayedTask(new GoldOreReplaceTask($b), 20 * 180);
        }elseif($p->getLevel()->getName() == "builduhc") {
            if ($b->getId() == Block::COBBLESTONE or $b->getId() == 5 && $b->getDamage() == 0 or $b->getDamage() == 1 or $b->getDamage() == 2 or $b->getDamage() == 3 or $b->getDamage() == 4 or $b->getDamage() == 5 or $b->getId() == 10 or $b->getId() == 11 or $b->getId() == 8 or $b->getId() == 9) {

            } else {
                if (!$p->isOp()) {
                    $e->setCancelled();
                }
            }
        }else{
            if(!$p->isOp()){
                $e->setCancelled();
            }
        }
    }
}