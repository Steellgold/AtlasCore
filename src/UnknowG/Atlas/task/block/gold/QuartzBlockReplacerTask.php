<?php

namespace UnknowG\Atlas\task\block\gold;

use pocketmine\block\Block;
use pocketmine\scheduler\Task;
use UnknowG\Atlas\Atlas;

class QuartzBlockReplacerTask extends Task
{
    private $block;

    public function __construct(Block $block)
    {
        $this->block = $block;
    }

    public function onRun(int $currentTick)
    {
        $this->block->getLevel()->setBlock($this->block, Block::get(Block::QUARTZ_BLOCK));
    }
}