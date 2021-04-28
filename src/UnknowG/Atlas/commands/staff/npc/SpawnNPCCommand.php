<?php

namespace UnknowG\Atlas\commands\staff\npc;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\entity\Human;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\utils\texts\Texts;

class SpawnNPCCommand extends Command
{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        $this->setPermission("npc.spawncommand");
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if ($player instanceof Player) {
            if (RankAPI::getIDRank($player) == "admin" || RankAPI::getIDRank($player) == "fonda") {
                if ($player->isOp()) {
                    if (isset($args[0])) {
                        if ($args[0] == "astro") {
                            if ($args[1] == "delete") {
                                foreach (Server::getInstance()->getLevels() as $level) {
                                    foreach ($level->getEntities() as $entity) {
                                        if (isset($entity->namedtag["astroQuest"])) {
                                            $entity->close();
                                        }
                                    }
                                }
                            } elseif ($args[1] == "spawn") {
                                if ($player instanceof Player) {
                                    $nbt = Entity::createBaseNBT($player->asVector3());
                                    $nbt->setString("astroQuest", uniqid());
                                    $nbt->setTag($player->namedtag->getTag("Skin"));
                                    $human = new Human($player->getLevel(), $nbt);
                                    $human->setNameTagVisible(true);
                                    $human->setScale(1);
                                    $human->setNameTag($this->getPrefix($args[3]) . "\n{$args[2]}");
                                    $human->setRotation($player->getYaw(), $player->getPitch());
                                    $human->sendSkin();
                                    $human->setImmobile(true);
                                    $human->spawnToAll();
                                }
                            }
                        } elseif ($args[0] == "ourson") {
                            if ($args[1] == "delete") {
                                foreach (Server::getInstance()->getLevels() as $level) {
                                    foreach ($level->getEntities() as $entity) {
                                        if (isset($entity->namedtag["astroOursonQuest"])) {
                                            $entity->close();
                                        }
                                    }
                                }
                            } elseif ($args[1] == "spawn") {
                                if ($player instanceof Player) {
                                    $nbt = Entity::createBaseNBT($player->asVector3());
                                    $nbt->setString("astroOursonQuest", uniqid());
                                    $nbt->setTag($player->namedtag->getTag("Skin"));
                                    $human = new Human($player->getLevel(), $nbt);
                                    $human->setNameTagVisible(true);
                                    $human->setScale(1);
                                    $human->setNameTag($this->getPrefix($args[3]) . "\n{$args[2]}");
                                    $human->setRotation($player->getYaw(), $player->getPitch());
                                    $human->sendSkin();
                                    $human->setImmobile(true);
                                    $human->spawnToAll();
                                }
                            }
                        } elseif ($args[0] == "compr") {
                            if ($args[1] == "delete") {
                                foreach (Server::getInstance()->getLevels() as $level) {
                                    foreach ($level->getEntities() as $entity) {
                                        if (isset($entity->namedtag["compressorPnj"])) {
                                            $entity->close();
                                        }
                                    }
                                }
                            } elseif ($args[1] == "spawn") {
                                if ($player instanceof Player) {
                                    $nbt = Entity::createBaseNBT($player->asVector3());
                                    $nbt->setString("compressorPnj", uniqid());
                                    $nbt->setTag($player->namedtag->getTag("Skin"));
                                    $human = new Human($player->getLevel(), $nbt);
                                    $human->setNameTagVisible(true);
                                    $human->setScale(1);
                                    $human->setNameTag($this->getPrefix($args[3]) . "\n{$args[2]}");
                                    $human->setRotation($player->getYaw(), $player->getPitch());
                                    $human->sendSkin();
                                    $human->setImmobile(true);
                                    $human->spawnToAll();
                                }
                            }
                        } elseif ($args[0] == "box") {
                            if ($args[1] == "delete") {
                                foreach (Server::getInstance()->getLevels() as $level) {
                                    foreach ($level->getEntities() as $entity) {
                                        if (isset($entity->namedtag["boxPnj"])) {
                                            $entity->close();
                                        }
                                    }
                                }
                            } elseif ($args[1] == "spawn") {
                                if ($player instanceof Player) {
                                    $nbt = Entity::createBaseNBT($player->asVector3());
                                    $nbt->setString("boxPnj", uniqid());
                                    $nbt->setTag($player->namedtag->getTag("Skin"));
                                    $human = new Human($player->getLevel(), $nbt);
                                    $human->setNameTagVisible(true);
                                    $human->setScale(1);
                                    $human->setNameTag($this->getPrefix($args[3]) . "\n{$args[2]}");
                                    $human->setRotation($player->getYaw(), $player->getPitch());
                                    $human->sendSkin();
                                    $human->setImmobile(true);
                                    $human->spawnToAll();
                                }
                            }
                        } elseif ($args[0] == "boosts") {
                            if ($args[1] == "delete") {
                                foreach (Server::getInstance()->getLevels() as $level) {
                                    foreach ($level->getEntities() as $entity) {
                                        if (isset($entity->namedtag["boostPnj"])) {
                                            $entity->close();
                                        }
                                    }
                                }
                            } elseif ($args[1] == "spawn") {
                                if ($player instanceof Player) {
                                    $nbt = Entity::createBaseNBT($player->asVector3());
                                    $nbt->setString("boostPnj", uniqid());
                                    $nbt->setTag($player->namedtag->getTag("Skin"));
                                    $human = new Human($player->getLevel(), $nbt);
                                    $human->setNameTagVisible(true);
                                    $human->setScale(1);
                                    $human->setNameTag($this->getPrefix($args[3]) . "\n{$args[2]}");
                                    $human->setRotation($player->getYaw(), $player->getPitch());
                                    $human->sendSkin();
                                    $human->setImmobile(true);
                                    $human->spawnToAll();
                                }
                            }
                        }elseif ($args[0] == "train") {
                            if ($args[1] == "delete") {
                                foreach (Server::getInstance()->getLevels() as $level) {
                                    foreach ($level->getEntities() as $entity) {
                                        if (isset($entity->namedtag["spawnTrainPnj"])) {
                                            $entity->close();
                                        }
                                    }
                                }
                            } elseif ($args[1] == "spawn") {
                                if ($player instanceof Player) {
                                    $nbt = Entity::createBaseNBT($player->asVector3());
                                    $nbt->setString("spawnTrainPnj", uniqid());
                                    $nbt->setTag($player->namedtag->getTag("Skin"));
                                    $human = new Human($player->getLevel(), $nbt);
                                    $human->setNameTagVisible(true);
                                    $human->setScale(1);
                                    $human->setNameTag($this->getPrefix($args[3]) . "\n{$args[2]}");
                                    $human->setRotation($player->getYaw(), $player->getPitch());
                                    $human->sendSkin();
                                    $human->setImmobile(true);
                                    $human->spawnToAll();
                                }
                            }
                        }elseif ($args[0] == "trader") {
                            if ($args[1] == "delete") {
                                foreach (Server::getInstance()->getLevels() as $level) {
                                    foreach ($level->getEntities() as $entity) {
                                        if (isset($entity->namedtag["trader"])) {
                                            $entity->close();
                                        }
                                    }
                                }
                            } elseif ($args[1] == "spawn") {
                                if ($player instanceof Player) {
                                    $nbt = Entity::createBaseNBT($player->asVector3());
                                    $nbt->setString("trader", uniqid());
                                    $nbt->setTag($player->namedtag->getTag("Skin"));
                                    $human = new Human($player->getLevel(), $nbt);
                                    $human->setNameTagVisible(true);
                                    $human->setScale(1);
                                    $human->setNameTag($this->getPrefix($args[3]) . "\n{$args[2]}");
                                    $human->setRotation($player->getYaw(), $player->getPitch());
                                    $human->sendSkin();
                                    $human->setImmobile(true);
                                    $human->spawnToAll();
                                }
                            }
                        } else {
                            $player->sendMessage("---");
                        }
                    } else {
                        $player->sendMessage(Texts::$prefix . "element manquant (contactez gaetan en mp)");
                    }
                } else {
                    $player->sendMessage(Texts::returnNotPermission($player));
                }
            } else {
                $player->sendMessage(Texts::returnNotPermission($player));
            }
        }
    }

    public function getPrefix(string $pr){
        switch ($pr){
            case "quest":
                return Texts::$prefixQuestNPC;
                break;

            case "new":
                return Texts::$prefixNewNPC;
                break;

            case "update":
                return Texts::$prefixUpdateNPC;
                break;

            case "youtube":
                return Texts::$prefixPreniumNPC;
                break;

            case "beta":
                return Texts::$prefixBetaNPC;
                break;

            case "box":
                return Texts::$prefixBoxNPC;
                break;

            case "boost":
                return Texts::$prefixBoostNPC;
                break;

            case "hika":
                return Texts::$prefixHikaNPC;
                break;

            default:
                return "";
                break;
        }
    }
}