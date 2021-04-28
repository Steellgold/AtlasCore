<?php

namespace UnknowG\Atlas\hikabrain;

use pocketmine\block\Block;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\math\VoxelRayTrace;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\events\player\PlayerDeath;
use UnknowG\Atlas\events\player\PlayerJoin;
use UnknowG\Atlas\hikabrain\forms\EndGameForm;
use UnknowG\Atlas\hikabrain\manager\Accessory;
use UnknowG\Atlas\hikabrain\manager\Game;
use UnknowG\Atlas\hikabrain\manager\Rewards;
use UnknowG\Atlas\hikabrain\manager\Team;
use UnknowG\Atlas\hikabrain\manager\Utils;
use UnknowG\Atlas\hikabrain\tasks\GameRestartTask;
use UnknowG\Atlas\utils\RespawnUtil;

class EventListener implements Listener
{
    public $plugin;
    public $game;

    public function __construct(Atlas $plugin, Game $game)
    {
        $this->plugin = $plugin;
        $this->game = $game;
    }

    public function onDrop(PlayerDropItemEvent $event)
    {
        $p = $event->getPlayer();
        if (!in_array($event->getPlayer()->getLevel()->getName(), Game::$worlds)) {
            return;
        }

        $event->setCancelled();
    }

    public function onInteract(PlayerInteractEvent $event)
    {
        $p = $event->getPlayer();
        if (!in_array($event->getPlayer()->getLevel()->getName(), Game::$worlds)) {
            return;
        }

        if ($event->getItem()->getId() == 383 && $event->getItem()->getDamage() == 105) {
            $p->getLevel()->setBlock(new Vector3($p->getX() + 1, $p->getY() - 1, $p->getZ()), Block::get(Block::SANDSTONE));
            $p->getLevel()->setBlock(new Vector3($p->getX() + 2, $p->getY() - 1, $p->getZ()), Block::get(Block::SANDSTONE));
            $p->getLevel()->setBlock(new Vector3($p->getX() + 3, $p->getY() - 1, $p->getZ()), Block::get(Block::SANDSTONE));
            $p->getLevel()->setBlock(new Vector3($p->getX() + 4, $p->getY() - 1, $p->getZ()), Block::get(Block::SANDSTONE));
            $p->getLevel()->setBlock(new Vector3($p->getX() + 5, $p->getY() - 1, $p->getZ()), Block::get(Block::SANDSTONE));
        }


        if ($event->getItem()->getId() == 383 && $event->getItem()->getDamage() == 35) {
            $bluePlayer = Server::getInstance()->getPlayer(Team::getTeam()->getPlayerBlue($p->getLevel()));
            $redPlayer = Server::getInstance()->getPlayer(Team::getTeam()->getPlayerRed($p->getLevel()));

            if ($redPlayer->getName() == $p->getName()) {
                if (time() > Accessory::getUtils()->getInfo($p->getLevel(), "redTime")) {
                    $p->addEffect(new EffectInstance(Effect::getEffect(1), 20 * 5, 1));
                    Accessory::getUtils()->setRedTime($p->getLevel(), time() + 30);
                    $event->setCancelled();
                } else {
                    $p->sendMessage(Texts::$prefix . "Item is not recharged (30s)");
                }
            } elseif ($bluePlayer->getName() == $p->getName()) {
                if (time() > Accessory::getUtils()->getInfo($p->getLevel(), "blueTime")) {
                    $p->addEffect(new EffectInstance(Effect::getEffect(1), 20 * 5, 1));
                    Accessory::getUtils()->setBlueTime($p->getLevel(), time() + 30);
                    $event->setCancelled();
                } else {
                    $p->sendMessage(Texts::$prefix . "Item is not recharged (30s)");
                }
            } else {

            }
        }

        if ($event->getItem()->getId() == 383 && $event->getItem()->getDamage() == 11) {
            $bluePlayer = Server::getInstance()->getPlayer(Team::getTeam()->getPlayerBlue($p->getLevel()));
            $redPlayer = Server::getInstance()->getPlayer(Team::getTeam()->getPlayerRed($p->getLevel()));

            if ($redPlayer->getName() == $p->getName()) {
                if (time() > Accessory::getUtils()->getInfo($p->getLevel(), "redTime")) {
                    $p->addEffect(new EffectInstance(Effect::getEffect(5), 20 * 3, 0));
                    Accessory::getUtils()->setRedTime($p->getLevel(), time() + 50);
                    $event->setCancelled();
                } else {
                    $p->sendMessage(Texts::$prefix . "Item is not recharged (50s)");
                }
            } elseif ($bluePlayer->getName() == $p->getName()) {
                if (time() > Accessory::getUtils()->getInfo($p->getLevel(), "blueTime")) {
                    $p->addEffect(new EffectInstance(Effect::getEffect(5), 20 * 3, 0));
                    Accessory::getUtils()->setRedTime($p->getLevel(), time() + 50);
                    $event->setCancelled();
                } else {
                    $p->sendMessage(Texts::$prefix . "Item is not recharged (50s)");
                }
            } else {

            }
        }

        if ($event->getItem()->getId() == 383 && $event->getItem()->getDamage() == 32) {
            $bluePlayer = Server::getInstance()->getPlayer(Team::getTeam()->getPlayerBlue($p->getLevel()));
            $redPlayer = Server::getInstance()->getPlayer(Team::getTeam()->getPlayerRed($p->getLevel()));

            if ($bluePlayer->getName() == $p->getName()) {
                if (time() > Accessory::getUtils()->getInfo($p->getLevel(), "blueTime")) {
                    $redPlayer->addEffect(new EffectInstance(Effect::getEffect(9), 20 * 10, 3));
                    Accessory::getUtils()->setBlueTime($p->getLevel(), time() + 120);
                    $event->setCancelled();
                } else {
                    $p->sendMessage(Texts::$prefix . "Item is not recharged (120s)");
                }
            } elseif ($redPlayer->getName() == $p->getName()) {
                if (time() > Accessory::getUtils()->getInfo($p->getLevel(), "blueTime")) {
                    $bluePlayer->addEffect(new EffectInstance(Effect::getEffect(9), 20 * 10, 3));
                    Accessory::getUtils()->setRedTime($p->getLevel(), time() + 120);
                    $event->setCancelled();
                } else {
                    $p->sendMessage(Texts::$prefix . "Item is not recharged (120s)");
                }
            } else {
                $p->sendMessage("Item Error #952");
            }
        }


        if (!$event->getBlock()->getId() == 26) {
            if (!$p->isOp()) {
                $event->setCancelled();
            }
        }
        if (!$event->getBlock()->getId() == 26 && $event->getBlock()->getDamage() == 2) {
            if (!$p->isOp()) {
                $event->setCancelled();
            }
        }
    }

    public function onBreak(BlockBreakEvent $event)
    {
        $p = $event->getPlayer();
        $b = $event->getBlock();
        if (!in_array($event->getPlayer()->getLevel()->getName(), Game::$worlds)) {
            return;
        }
        if (!$event->getBlock()->getId() == 24 && $event->getBlock()->getDamage() == 0) {
            $event->setCancelled();
        }
    }

    public function onPlace(BlockPlaceEvent $event)
    {
        $p = $event->getPlayer();
        $b = $event->getBlock();
        if (!in_array($event->getPlayer()->getLevel()->getName(), Game::$worlds)) {
            return;
        }
        if (!$event->getBlock()->getId() == 24 && $event->getBlock()->getDamage() == 0) {
            $event->setCancelled();
        }
    }

    public function onBed(PlayerMoveEvent $event)
    {
        $p = $event->getPlayer();
        $l = $p->getLevel();
        $b = $p->getLevel()->getBlockAt($p->x, ($p->y - 0.2), $p->z);
        $file = Atlas::getHikabrainFileData("games");
        if (!in_array($event->getPlayer()->getLevel()->getName(), Game::$worlds)) {
            return;
        }
        if (!$file->exists($p->getLevel()->getName())) {
            return;
        }

        if ($b->getId() == 26) {
            $bluePlayer = Server::getInstance()->getPlayer(Team::getTeam()->getPlayerBlue($l));
            $redPlayer = Server::getInstance()->getPlayer(Team::getTeam()->getPlayerRed($l));

            if ($bluePlayer instanceof Player) {
                if ($redPlayer instanceof Player) {
                    $redPlayer->setHealth(20);
                    $bluePlayer->setHealth(20);
                    if ($b->getId() == 26 && $b->getDamage() == 0) {
                        if ($redPlayer->getName() == $p->getName()) {
                            $redPlayer->sendMessage(Texts::$prefix . " You can't do this, this is your team!");
                            return;
                        } else {
                            if ($this->game->getPoint($l, "bluePts") == $this->game->getWinPoints($l) - 1) {
                                $xpBlue = Rewards::getReward()->getXp(Utils::getUtils()->getInfo($l, "blueKill"), Utils::getUtils()->getInfo($l, "blueDeath"));
                                $xpRed = Rewards::getReward()->getXp(Utils::getUtils()->getInfo($l, "redKill"), Utils::getUtils()->getInfo($l, "redDeath"));

                                EndGameForm::openWin($bluePlayer, $l->getName(), $xpBlue, 10, $this->game->getWinPoints($l), $this->game->getPoint($l, "redPts"));
                                EndGameForm::openLose($redPlayer, $l->getName(), $xpRed, 10, $this->game->getWinPoints($l), $this->game->getPoint($l, "redPts"));

                                $redPlayer->getInventory()->setContents([]);
                                $redPlayer->getArmorInventory()->setContents([]);
                                $bluePlayer->getInventory()->setContents([]);
                                $bluePlayer->getArmorInventory()->setContents([]);
                                PlayerJoin::giveCompass($bluePlayer);
                                PlayerJoin::giveCompass($redPlayer);
                                PlayerDeath::tpLobbySpawn($bluePlayer);
                                PlayerDeath::tpLobbySpawn($redPlayer);
                                return;
                            } else {
                                $this->game->addPoint($l, "bluePts");
                                RespawnUtil::giveHIKAKit($bluePlayer);
                                RespawnUtil::giveHIKAKit($bluePlayer);
                                Utils::getUtils()->addEmeraldBlue($l, 10);
                                $this->setEmerald($l, $redPlayer, "red");
                                $this->setEmerald($l, $bluePlayer, "blue");
                            }
                        }
                    } else {
                        if ($bluePlayer->getName() == $p->getName()) {
                            $bluePlayer->sendMessage(Texts::$prefix . " You can't do this, this is your team!");
                            return;
                        } else {
                            if ($this->game->getPoint($l, "redPts") == $this->game->getWinPoints($l) - 1) {
                                $xpBlue = Rewards::getReward()->getXp(Utils::getUtils()->getInfo($l, "blueKill"), Utils::getUtils()->getInfo($l, "blueDeath"));
                                $xpRed = Rewards::getReward()->getXp(Utils::getUtils()->getInfo($l, "redKill"), Utils::getUtils()->getInfo($l, "redDeath"));

                                EndGameForm::openWin($redPlayer, $l->getName(), $xpRed, 10, $this->game->getWinPoints($l), $this->game->getPoint($l, "bluePts"));
                                EndGameForm::openLose($bluePlayer, $l->getName(), $xpBlue, 10, $this->game->getWinPoints($l), $this->game->getPoint($l, "bluePts"));

                                $redPlayer->getInventory()->setContents([]);
                                $redPlayer->getArmorInventory()->setContents([]);
                                $bluePlayer->getInventory()->setContents([]);
                                $bluePlayer->getArmorInventory()->setContents([]);
                                PlayerJoin::giveCompass($bluePlayer);
                                PlayerJoin::giveCompass($redPlayer);
                                PlayerDeath::tpLobbySpawn($redPlayer);
                                PlayerDeath::tpLobbySpawn($bluePlayer);
                                return;
                            } else {
                                $this->game->addPoint($l, "redPts");
                                RespawnUtil::giveHIKAKit($bluePlayer);
                                RespawnUtil::giveHIKAKit($bluePlayer);
                                Utils::getUtils()->addEmeraldRed($l, 10);
                                $this->setEmerald($l, $redPlayer, "red");
                                $this->setEmerald($l, $bluePlayer, "blue");
                            }
                        }
                    }

                    $bluePlayer->teleport(new Position(258, 72, 222, $l));
                    $bluePlayer->addEffect(new EffectInstance(Effect::getEffect(Effect::BLINDNESS), 20 * 4, 5));

                    $redPlayer->teleport(new Position(257, 72, 257, $l));
                    $redPlayer->addEffect(new EffectInstance(Effect::getEffect(Effect::BLINDNESS), 20 * 4, 5));
                    $redPlayer->setImmobile(true);
                    $bluePlayer->setImmobile(true);
                    RespawnUtil::giveHIKAKit($redPlayer);
                    RespawnUtil::giveHIKAKit($bluePlayer);
                    $this->setEmerald($l, $redPlayer, "red");
                    $this->setEmerald($l, $bluePlayer, "blue");
                    $this->plugin->getScheduler()->scheduleRepeatingTask(new GameRestartTask($l, Atlas::getInstance()), 20);
                } else {
                    return;
                }
            } else {
                return;
            }
        } else {
            return;
        }
    }

    public function onVoid(PlayerMoveEvent $event)
    {
        $p = $event->getPlayer();
        $l = $p->getLevel();
        $b = $p->getLevel()->getBlockAt($p->x, ($p->y - 0.2), $p->z);
        $file = Atlas::getHikabrainFileData("games");
        if (!in_array($event->getPlayer()->getLevel()->getName(), Game::$worlds)) {
            return;
        }
        if (!$file->exists($p->getLevel()->getName())) {
            return;
        }

        if ($b->getId() == 95) {
            $p->setHealth(20);
            $bluePlayer = Server::getInstance()->getPlayer(Team::getTeam()->getPlayerBlue($l));
            $redPlayer = Server::getInstance()->getPlayer(Team::getTeam()->getPlayerRed($l));

            if ($redPlayer->getName() == $p->getName()) {
                $redPlayer->teleport(new Position(256, 73, 270, $l));
                Utils::getUtils()->addRedDeath($l, 1);
                RespawnUtil::giveHIKAKit($redPlayer);
                $this->setEmerald($l, $redPlayer, "red");
                return;
            }

            if ($bluePlayer->getName() == $p->getName()) {
                $bluePlayer->teleport(new Position(256, 73, 243, $l));
                Utils::getUtils()->addBlueDeath($l, 1);
                RespawnUtil::giveHIKAKit($bluePlayer);
                $this->setEmerald($l, $bluePlayer, "blue");
                return;
            }
        }
    }

    public function sendHUD(PlayerMoveEvent $event)
    {
        $p = $event->getPlayer();
        $file = Atlas::getHikabrainFileData("games");
        if (!in_array($event->getPlayer()->getLevel()->getName(), Game::$worlds)) {
            return;
        }
        if (!$file->exists($p->getLevel()->getName())) {
            return;
        }

        $blue = Game::getGame()->getFile($p->getLevel()->getName())["bluePts"];
        $red = Game::getGame()->getFile($p->getLevel()->getName())["redPts"];
        $winPts = Game::getGame()->getFile($p->getLevel()->getName())["ptsWin"];
        $p->sendPopup("§b§lBLUE: $blue §r§7- §c§lRED: $red\n§r§7Objective of the game : $winPts points");
    }

    public function onFight(EntityDamageByEntityEvent $ev)
    {
        $entity = $ev->getEntity();
        $level = $ev->getEntity()->getLevel();

        if ($entity instanceof Player) {
            if ($entity->getLevel()->getName() == "hika1" or $entity->getLevel()->getName() == "hika2" or $entity->getLevel()->getName() == "hika3" or $entity->getLevel()->getName() == "hika4" or $entity->getLevel()->getName() == "hikaOriginal") {
                $damager = $ev->getDamager();
                if ($entity->getHealth() - $ev->getFinalDamage() <= 0) {
                    $bluePlayer = Server::getInstance()->getPlayer(Team::getTeam()->getPlayerBlue($level));
                    $redPlayer = Server::getInstance()->getPlayer(Team::getTeam()->getPlayerRed($level));

                    # MORT -----------------------------------------------------------------
                    if ($entity->getName() == $bluePlayer->getName()) {
                        $bluePlayer->teleport(new Position(256, 73, 243, $level));
                        Utils::getUtils()->addBlueDeath($level, 1);
                        Utils::getUtils()->resetSerialBlue($level);
                    } elseif ($entity->getName() == $redPlayer->getName()) {
                        $redPlayer->teleport(new Position(256, 73, 270, $level));
                        Utils::getUtils()->addRedDeath($level, 1);
                        Utils::getUtils()->resetSerialRed($level);
                    } else {

                    }

                    $entity->setHealth(20);


                    # TUEUR ----------------------------------------------------------------
                    if ($damager instanceof Player) {
                        if ($damager->getName() == $bluePlayer->getName()) {
                            Utils::getUtils()->addBlueKill($level, 1);
                            Utils::getUtils()->addSerialBlueKill($level, 1);
                            Utils::getUtils()->addEmeraldBlue($level, 1);
                            self::setEmerald($level, $damager, "blue");

                            if (Utils::getUtils()->getInfo($level, "blueSerialKill") == 3) {
                                RespawnUtil::giveHIKAKit2($damager);
                                $this->setEmerald($level, $damager, "blue");
                            }

                            if (Utils::getUtils()->getInfo($level, "blueSerialKill") == 5) {
                                RespawnUtil::giveHIKAKit3($damager);
                                $this->setEmerald($level, $damager, "blue");
                            }
                        } elseif ($damager->getName() == $redPlayer->getName()) {
                            Utils::getUtils()->addRedKill($level, 1);
                            Utils::getUtils()->addSerialRedKill($level, 1);
                            Utils::getUtils()->addEmeraldRed($level, 1);
                            self::setEmerald($level, $damager, "red");

                            if (Utils::getUtils()->getInfo($level, "redSerialKill") == 3) {
                                RespawnUtil::giveHIKAKit2($damager);
                                $this->setEmerald($level, $damager, "red");
                            }

                            if (Utils::getUtils()->getInfo($level, "redSerialKill") == 5) {
                                RespawnUtil::giveHIKAKit3($damager);
                                $this->setEmerald($level, $damager, "red");
                            }
                        } else {

                        }
                    }
                }
            }
        }
    }

    public function leaveWaintingFile(PlayerInteractEvent $event){
        if(!$event->getPlayer()->getLevel()->getName() == "atlas"){ $event->setCancelled(); }

        $wfile = Atlas::getHikabrainFileData("WFile");
        if($event->getItem()->getId() == 355 && $event->getItem()->getDamage() == 10 && $event->getItem()->getCustomName() == "Leave the Wainting File"){
            if(Team::getTeam()->isWaintingFile($event->getPlayer())){
                var_dump(Game::$wfile);
                $worldName = Game::$wfile[$event->getPlayer()->getName()];
                var_dump($worldName);
                $wfile->set($worldName,["bluePlayer" => "none","redPlayer" => "none"]);
                $wfile->save();
                $event->getPlayer()->sendMessage(Texts::$prefix . " You have been leaved the waiting file for the " . Game::$wfile[$event->getPlayer()->getName()]);
                $event->getPlayer()->getInventory()->clearAll();
                PlayerJoin::giveCompass($event->getPlayer());
            }
        }
    }

    public static function setEmerald(Level $level, Player $player, string $team)
    {
        if ($player->getLevel()->getName() == "hikaOriginal") {
            $item = Item::get(24, 0, 64);
            $player->getInventory()->setItem(3, $item);
            $player->getInventory()->setItem(8, $item);
        } else {
            $em = Item::get(388);
            if ($team == "red") {
                $em->setCount(Utils::getUtils()->getInfo($player->getLevel(), "emeraldRed"));
                switch (Accessory::getUtils()->getInfo($level, "redItem")) {
                    case "blp":
                        $item = Item::get(383, 122);
                        $player->getInventory()->setItem(3, $item);
                        break;
                    case "str":
                        $item = Item::get(383, 11);
                        $player->getInventory()->setItem(3, $item);
                        break;
                    case "speed":
                        $item = Item::get(383, 35);
                        $player->getInventory()->setItem(3, $item);
                        break;
                    case "nau":
                        $item = Item::get(383, 32);
                        $player->getInventory()->setItem(3, $item);
                        break;
                    case "none":
                        $item = Item::get(24, 0, 64);
                        $player->getInventory()->setItem(3, $item);
                        break;
                }
            } else {
                switch (Accessory::getUtils()->getInfo($level, "blueItem")) {
                    case "blp":
                        $item = Item::get(383, 122);
                        $player->getInventory()->setItem(3, $item);
                        break;
                    case "str":
                        $item = Item::get(383, 11);
                        $player->getInventory()->setItem(3, $item);
                        break;
                    case "speed":
                        $item = Item::get(383, 35);
                        $player->getInventory()->setItem(3, $item);
                        break;
                    case "nau":
                        $item = Item::get(383, 32);
                        $player->getInventory()->setItem(3, $item);
                        break;
                    case "none":
                        $item = Item::get(24, 0, 64);
                        $player->getInventory()->setItem(3, $item);
                        break;
                }
                $em->setCount(Utils::getUtils()->getInfo($player->getLevel(), "emeraldBlue"));
            }

            $player->getInventory()->setItem(8, $em);
        }
    }
}