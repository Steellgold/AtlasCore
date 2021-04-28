<?php

namespace UnknowG\Atlas\hikabrain\forms;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\hikabrain\EventListener;
use UnknowG\Atlas\hikabrain\manager\Accessory;
use UnknowG\Atlas\hikabrain\manager\Team;
use UnknowG\Atlas\hikabrain\manager\Utils;
use UnknowG\Atlas\utils\texts\Texts;

class AccessoryForm extends SimpleForm
{
    public static function open(Player $p)
    {
        $form = new SimpleForm
        (
            function (Player $p, $data) {
                if ($data === null) {
                } else {
                    switch ($data) {
                        case 0:
                            $bluePlayer = Server::getInstance()->getPlayer(Team::getTeam()->getPlayerBlue($p->getLevel()));
                            $redPlayer = Server::getInstance()->getPlayer(Team::getTeam()->getPlayerRed($p->getLevel()));

                            if ($redPlayer instanceof Player) {
                                if ($bluePlayer instanceof Player) {
                                    if ($redPlayer->getName() == $p->getName()) {
                                        if (Accessory::getUtils()->getInfo($p->getLevel(), "redItem") == "none") {
                                            if ($p->getInventory()->contains(Item::get(388, 0, 30))) {
                                                $p->getInventory()->remove(Item::get(388, 0, 30));
                                                $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " You have paid a Speed Effect II usable every 10 secondes !");
                                                Accessory::getUtils()->setRedItem($p->getLevel(), "speed");
                                                Utils::getUtils()->delEmeraldRed($p->getLevel(), 30);
                                                EventListener::setEmerald($p->getLevel(), $p, "red");
                                                return;
                                            } else {
                                                $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " You don't have any more emerald to paid this !");
                                                return;
                                            }
                                        } else {
                                            $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " You have aleardy an item, wait the next game to get a new !");
                                            return;
                                        }
                                    }

                                    if ($bluePlayer->getName() == $p->getName()) {
                                        if (Accessory::getUtils()->getInfo($p->getLevel(), "blueItem") == "none") {
                                            if ($p->getInventory()->contains(Item::get(388, 0, 30))) {
                                                $p->getInventory()->remove(Item::get(388, 0, 30));
                                                $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " You have paid a Speed Effect II usable every 10 secondes !");
                                                Accessory::getUtils()->setRedItem($p->getLevel(), "speed");
                                                Utils::getUtils()->delEmeraldBlue($p->getLevel(), 30);
                                                EventListener::setEmerald($p->getLevel(), $p, "blue");
                                                return;
                                            } else {
                                                $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " You don't have any more emerald to paid this !");
                                                return;
                                            }
                                        } else {
                                            $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " You have aleardy an item, wait the next game to get a new !");
                                            return;
                                        }
                                    }
                                }
                            }
                            break;
                        case 1:
                            $bluePlayer = Server::getInstance()->getPlayer(Team::getTeam()->getPlayerBlue($p->getLevel()));
                            $redPlayer = Server::getInstance()->getPlayer(Team::getTeam()->getPlayerRed($p->getLevel()));

                            if ($redPlayer instanceof Player) {
                                if ($bluePlayer instanceof Player) {
                                    if ($redPlayer->getName() == $p->getName()) {
                                        if (Accessory::getUtils()->getInfo($p->getLevel(), "redItem") == "none") {
                                            if ($p->getInventory()->contains(Item::get(388, 0, 50))) {
                                                $p->getInventory()->remove(Item::get(388, 0, 50));
                                                $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " You have paid a Strength Effect I usable every 30 secondes !");
                                                Accessory::getUtils()->setRedItem($p->getLevel(), "str");
                                                Utils::getUtils()->delEmeraldRed($p->getLevel(), 50);
                                                EventListener::setEmerald($p->getLevel(), $p, "red");
                                                return;
                                            } else {
                                                $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " You don't have any more emerald to paid this !");
                                                return;
                                            }
                                        } else {
                                            $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " You have aleardy an item, wait the next game to get a new !");
                                            return;
                                        }
                                    }
                                }

                                if ($bluePlayer->getName() == $p->getName()) {
                                    if (Accessory::getUtils()->getInfo($p->getLevel(), "blueItem") == "none") {
                                        if ($p->getInventory()->contains(Item::get(388, 0, 50))) {
                                            $p->getInventory()->remove(Item::get(388, 0, 50));
                                            $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " You have paid a Speed Effect II usable every 30 secondes !");
                                            Accessory::getUtils()->setBlueItem($p->getLevel(), "str");
                                            Utils::getUtils()->delEmeraldBlue($p->getLevel(), 50);
                                            EventListener::setEmerald($p->getLevel(), $p, "blue");
                                            return;
                                        } else {
                                            $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " You don't have any more emerald to paid this !");
                                            return;
                                        }
                                    } else {
                                        $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " You have aleardy an item, wait the next game to get a new !");
                                        return;
                                    }
                                }
                            }
                            break;
                        case 2:
                            $bluePlayer = Server::getInstance()->getPlayer(Team::getTeam()->getPlayerBlue($p->getLevel()));
                            $redPlayer = Server::getInstance()->getPlayer(Team::getTeam()->getPlayerRed($p->getLevel()));

                            if ($redPlayer instanceof Player) {
                                if ($bluePlayer instanceof Player) {
                                    if ($redPlayer->getName() == $p->getName()) {
                                        if (Accessory::getUtils()->getInfo($p->getLevel(), "redItem") == "none") {
                                            if ($p->getInventory()->contains(Item::get(388, 0, 64))) {
                                                $p->getInventory()->remove(Item::get(388, 0, 64));
                                                $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " You have paid a Nausea Effect I usable every 60 secondes !");
                                                Accessory::getUtils()->setRedItem($p->getLevel(), "nau");
                                                Utils::getUtils()->delEmeraldRed($p->getLevel(), 64);
                                                EventListener::setEmerald($p->getLevel(), $p, "red");
                                                return;
                                            } else {
                                                $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " You don't have any more emerald to paid this !");
                                                return;
                                            }
                                        } else {
                                            $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " You have aleardy an item, wait the next game to get a new !");
                                            return;
                                        }
                                    }
                                }

                                if ($bluePlayer->getName() == $p->getName()) {
                                    if (Accessory::getUtils()->getInfo($p->getLevel(), "blueItem") == "none") {
                                        if ($p->getInventory()->contains(Item::get(388, 0, 64))) {
                                            $p->getInventory()->remove(Item::get(388, 0, 64));
                                            $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " You have paid a Nausea Effect I usable every 60 secondes !");
                                            Accessory::getUtils()->setBlueItem($p->getLevel(), "str");
                                            Utils::getUtils()->delEmeraldBlue($p->getLevel(), 64);
                                            EventListener::setEmerald($p->getLevel(), $p, "blue");
                                            return;
                                        } else {
                                            $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " You don't have any more emerald to paid this !");
                                            return;
                                        }
                                    } else {
                                        $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " You have aleardy an item, wait the next game to get a new !");
                                        return;
                                    }
                                }
                            }
                            break;
                            break;
                    }
                }
            }
        );

        $t1 = "§7§l» §r§7" . Texts::getText(SQLData::getLang($p), "Achetez des items spécials pour vous aider dans votre partie, attention, un item par partie !", "Buy special items to help you in your game, be careful, one item per game !");
        $t2 = "§7§l» §r§7" . Texts::getText(SQLData::getLang($p), "Pour obtenir des émeraudes faîtes une de ces actions, chaque kill vous donnera §31 §7émeraudes ou §32 §7si vous êtes chanceux, et chaque lit atteint vous donnera §310 ! §7à vous de jouer !", "To get emeralds making kills, each kill will give you §31 §7emerald or §32 §7if you're lucky, and each bed reached will give you §310 §7you go to play !");

        $form->setTitle("§l- Hikabrain");
        $form->setContent($t1 . "\n\n" . $t2);
        $form->addButton(Texts::getText(SQLData::getLang($p), "§rVitesse II (§35s§r) - 30em\nTemp de recharge: 10s", "§rBoost II (§35s§r) - 5Em\nRecharging time: 10s"), 1, "https://rv-shock.net/minecraft/forms/hika/speed.png");
        $form->addButton(Texts::getText(SQLData::getLang($p), "§rForce I (§33s§r) - 50em\nTemp de recharge: 30s", "§rBoost I (§33s§r) - 10Em\nRecharging time: 30s"), 1, "https://rv-shock.net/minecraft/forms/hika/strength.png");
        $form->addButton(Texts::getText(SQLData::getLang($p), "§rNausée adverse (§34s§r) - 64em\nTemp de recharge: 60s", "§rAdverse Nausea (§34s§r) - 3Em\nRecharging time: 60s"), 1, "https://rv-shock.net/minecraft/forms/hika/nause.png");
        $p->sendForm($form);
    }
}