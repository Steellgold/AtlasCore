<?php

namespace UnknowG\Atlas\task\block;

use pocketmine\block\Block;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class BlockPlacedTask extends Task
{
    private $block;
    public function __construct(Block $block)
    {
        $this->block = $block;
    }

    public function onRun(int $currentTick)
    {
        $this->block->getLevel()->setBlock($this->block, Block::get(Block::AIR));
    }
}