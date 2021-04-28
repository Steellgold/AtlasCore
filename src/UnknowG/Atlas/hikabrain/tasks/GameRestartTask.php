<?php

namespace UnknowG\Atlas\hikabrain\tasks;

use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\level\Level;
use pocketmine\scheduler\Task;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\hikabrain\Texts;

class GameRestartTask extends Task {
    /** @var int $seconds */
    private $seconds = 0;

    public $level;
    public $plugin;

    public function __construct(Level $level, Atlas $plugin)
    {
        $this->level = $level;
        $this->plugin = $plugin;
    }

    public function onRun(int $tick) : void{
        $this->seconds++;
        $time = intval(4);
        $restartTime = $time - $this->seconds;
        switch($restartTime){
            case 3:
                foreach ($this->level->getPlayers() as $player){
                    $player->addTitle(Texts::$prefix,"Fight in 3 secondes");
                    $player->addEffect(new EffectInstance(Effect::getEffect(Effect::BLINDNESS),20 * 4,5));
                }
                return;
            case 2:
                foreach ($this->level->getPlayers() as $player){
                    $player->addTitle(Texts::$prefix,"Fight in 2 secondes");
                }
                return;
            case 1:
                foreach ($this->level->getPlayers() as $player){
                    $player->addTitle(Texts::$prefix,"Fight in 1 secondes");
                }
                return;
            case 0:
                foreach ($this->level->getPlayers() as $player){
                    $player->addTitle(Texts::$prefix,"FIGHT !",5,5,5);
                    $player->setImmobile(false);

                    $this->plugin->getScheduler()->cancelTask($this->getTaskId());
                }
                return;
        }
    }
}