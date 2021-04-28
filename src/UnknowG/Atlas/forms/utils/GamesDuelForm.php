<?php

namespace UnknowG\Atlas\forms\utils;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\mgr\PlayerProtectManager;
use UnknowG\Atlas\utils\RespawnUtil;
use UnknowG\Atlas\utils\texts\Texts;

class GamesDuelForm
{
    public static function openworlds(Player $p)
    {
        $form = new SimpleForm
        (
            function (Player $p, $data) {
                if ($data === null) {
                } else {
                    switch ($data) {
                        case 0:
                            $p->setGamemode(0);
                            $p->addEffect(new EffectInstance(Effect::getEffect(16), 20 * 999999));
                            $p->setFlying(false);
                            $p->setAllowFlight(false);
                            if (PlayerProtectManager::isIn($p)) {
                                PlayerProtectManager::delIn($p);
                            }

                            if (count(Server::getInstance()->getLevelByName("arena1")->getPlayers()) == 1) {
                                foreach (Server::getInstance()->getLevelByName("arena1")->getPlayers() as $players) {
                                    $pos = new Position(-179, 63, -67, Server::getInstance()->getLevelByName("arena1"));
                                    if ($players->getPosition() === $pos) {
                                        $p->teleport(new Position(-212, 64, -8, Server::getInstance()->getLevelByName("arena1")));
                                    } else {
                                        $p->teleport(new Position(-212, 64, -8, Server::getInstance()->getLevelByName("arena1")));
                                    }

                                    $players->setImmobile(false);
                                    RespawnUtil::giveGappleKit($p);
                                }
                            } else {
                                $p->teleport(new Position(-179, 63, -67, Server::getInstance()->getLevelByName("arena1")));
                                $p->setImmobile(true);
                                RespawnUtil::giveGappleKit($p);
                                $p->sendTip("Waiting for others players...");
                            }
                            break;
                        case 1:
                            $p->setGamemode(0);
                            $p->addEffect(new EffectInstance(Effect::getEffect(16), 20 * 999999));
                            $p->setFlying(false);
                            $p->setAllowFlight(false);
                            if (PlayerProtectManager::isIn($p)) {
                                PlayerProtectManager::delIn($p);
                            }

                            if (count(Server::getInstance()->getLevelByName("arena2")->getPlayers()) == 1) {
                                foreach (Server::getInstance()->getLevelByName("arena2")->getPlayers() as $players) {
                                    $pos = new Position(-179, 63, -67, Server::getInstance()->getLevelByName("arena2"));
                                    if ($players->getPosition() === $pos) {
                                        $p->teleport(new Position(-212, 64, -8, Server::getInstance()->getLevelByName("arena2")));
                                    } else {
                                        $p->teleport(new Position(-212, 64, -8, Server::getInstance()->getLevelByName("arena2")));
                                    }

                                    $players->setImmobile(false);
                                    RespawnUtil::giveArcKit($p);
                                }
                            } else {
                                $p->teleport(new Position(-179, 63, -67, Server::getInstance()->getLevelByName("arena2")));
                                $p->setImmobile(true);
                                RespawnUtil::giveArcKit($p);
                                $p->sendTip("Waiting for others players...");
                            }
                            break;
                        case 2:
                            $p->setGamemode(0);
                            $p->addEffect(new EffectInstance(Effect::getEffect(16), 20 * 999999));
                            $p->setFlying(false);
                            $p->setAllowFlight(false);
                            if (PlayerProtectManager::isIn($p)) {
                                PlayerProtectManager::delIn($p);
                            }

                            if (count(Server::getInstance()->getLevelByName("arena3")->getPlayers()) == 1) {
                                foreach (Server::getInstance()->getLevelByName("arena3")->getPlayers() as $players) {
                                    $pos = new Position(-179, 63, -67, Server::getInstance()->getLevelByName("arena3"));
                                    if ($players->getPosition() === $pos) {
                                        $p->teleport(new Position(-212, 64, -8, Server::getInstance()->getLevelByName("arena3")));
                                    } else {
                                        $p->teleport(new Position(-212, 64, -8, Server::getInstance()->getLevelByName("arena3")));
                                    }

                                    $players->setImmobile(false);
                                    RespawnUtil::giveNodeKit($p);
                                }
                            } else {
                                $p->teleport(new Position(-179, 63, -67, Server::getInstance()->getLevelByName("arena3")));
                                $p->setImmobile(true);
                                RespawnUtil::giveNodeKit($p);
                                $p->sendTip("Waiting for others players...");
                            }
                            break;
                        case 3:
                            $p->setGamemode(0);
                            $p->addEffect(new EffectInstance(Effect::getEffect(16), 20 * 999999));
                            $p->setFlying(false);
                            $p->setAllowFlight(false);

                            if (PlayerProtectManager::isIn($p)) {
                                PlayerProtectManager::delIn($p);
                            }

                            if (count(Server::getInstance()->getLevelByName("arena4")->getPlayers()) == 1) {
                                foreach (Server::getInstance()->getLevelByName("arena4")->getPlayers() as $players) {
                                    $pos = new Position(-179, 63, -67, Server::getInstance()->getLevelByName("arena4"));
                                    if ($players->getPosition() === $pos) {
                                        $p->teleport(new Position(-212, 64, -8, Server::getInstance()->getLevelByName("arena4")));
                                    } else {
                                        $p->teleport(new Position(-212, 64, -8, Server::getInstance()->getLevelByName("arena4")));
                                    }

                                    $players->setImmobile(false);
                                    RespawnUtil::giveGappleKit($p);
                                }
                            } else {
                                $p->teleport(new Position(-179, 63, -67, Server::getInstance()->getLevelByName("arena4")));
                                $p->setImmobile(true);
                                RespawnUtil::giveGappleKit($p);
                                $p->sendTip("Waiting for others players...");
                            }
                            break;
                            break;
                    }
                }
            }
        );

        $w1c = count(Server::getInstance()->getLevelByName("arena1")->getPlayers());
        $w2c = count(Server::getInstance()->getLevelByName("arena2")->getPlayers());
        $w3c = count(Server::getInstance()->getLevelByName("arena3")->getPlayers());
        $w4c = count(Server::getInstance()->getLevelByName("arena4")->getPlayers());

        $form->setTitle("§lDuels - §lBÊTA");
        $form->setContent(Texts::getText(SQLData::getLang($p), "§7Choisissez le monde que vous voulez !", "§7Choose your world do you want to play !") . "\n ");
        $form->addButton("§lArena Gapple\n$w1c/2 players");
        $form->addButton("§lArena Bow\n$w2c/2 players");
        $form->addButton("§lArena Nodebuff\n$w3c/2 players");
        $form->addButton("§lArena [RANKED - GAPPLE]\n$w4c/2 players");
        $p->sendForm($form);
    }
}