<?php

namespace UnknowG\Atlas\hikabrain\tasks;

use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\hikabrain\manager\Game;
use UnknowG\Atlas\hikabrain\Texts;
use UnknowG\Atlas\utils\RespawnUtil;

class StartGameTask extends Task
{
    /** @var int $seconds */
    private $seconds = 0;

    public $plugin;
    public $level;
    public $bluePlayer;
    public $redPlayer;

    public function __construct(Level $level, Atlas $plugin, Player $bluePlayer, Player $redPlayer)
    {
        $this->level = $level;
        $this->plugin = $plugin;
        $this->bluePlayer = $bluePlayer;
        $this->redPlayer = $redPlayer;
    }

    public function onRun(int $tick): void
    {
        $wFile = Atlas::getHikabrainFileData("WFile");
        $bP = $wFile->get($this->level->getName())["bluePlayer"];
        $rP = $wFile->get($this->level->getName())["redPlayer"];

        if (Server::getInstance()->getPlayer($bP) instanceof Player) {
            if (Server::getInstance()->getPlayer($rP) instanceof Player) {

                Server::getInstance()->getPlayer($bP)->teleport(new Position(256, 73, 243, $this->level));
                Server::getInstance()->getPlayer($bP)->setImmobile(true);
                Server::getInstance()->getPlayer($bP)->addEffect(new EffectInstance(Effect::getEffect(Effect::BLINDNESS), 20 * 4, 5));

                Server::getInstance()->getPlayer($rP)->teleport(new Position(256, 73, 270, $this->level));
                Server::getInstance()->getPlayer($rP)->setImmobile(true);
                Server::getInstance()->getPlayer($rP)->addEffect(new EffectInstance(Effect::getEffect(Effect::BLINDNESS), 20 * 4, 5));

                RespawnUtil::giveHIKAKit(Server::getInstance()->getPlayer($bP));
                RespawnUtil::giveHIKAKit(Server::getInstance()->getPlayer($rP));

                Server::getInstance()->getPlayer($bP)->setGamemode(0);
                Server::getInstance()->getPlayer($rP)->setGamemode(0);


                Game::getGame()->buildGame($this->level, Server::getInstance()->getPlayer($bP), Server::getInstance()->getPlayer($rP), 5);
                $this->plugin->getScheduler()->scheduleRepeatingTask(new GameRestartTask($this->level, Atlas::getInstance()), 20);
                $this->plugin->getScheduler()->cancelTask($this->getTaskId());
            } else {
                Server::getInstance()->getPlayer($rP)->sendMessage(Texts::$prefix . "The game can't launch, a player is not connected");
                $this->plugin->getScheduler()->cancelTask($this->getTaskId());
            }
        } else {
            Server::getInstance()->getPlayer($rP)->sendMessage(Texts::$prefix . "The game can't launch, a player is not connected");
            $this->plugin->getScheduler()->cancelTask($this->getTaskId());
        }
    }
}