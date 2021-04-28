<?php

namespace UnknowG\Atlas\events\npc;

use korado531m7\InventoryMenuAPI\InventoryMenu;
use korado531m7\InventoryMenuAPI\InventoryType;
use korado531m7\InventoryMenuAPI\utils\TradingRecipe;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityMotionEvent;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\Player;
use UnknowG\Atlas\api\CoinsAPI;
use UnknowG\Atlas\api\QuestAPI;
use UnknowG\Atlas\forms\boost\BlocksBoostForm;
use UnknowG\Atlas\forms\box\BoxForms;
use UnknowG\Atlas\forms\npc\quest\astronautQuest\AstronautQuest;
use UnknowG\Atlas\forms\utils\TrainKitForm;
use UnknowG\Atlas\hikabrain\forms\AccessoryForm;
use UnknowG\Atlas\mgr\PlayerProtectManager;
use UnknowG\Atlas\utils\texts\Texts;
use UnknowG\Atlas\utils\texts\Unicodes;

class NPCAtions implements Listener
{
    public function onMove(EntityMotionEvent $event)
    {
        if ($event->getEntity()->namedtag["astroQuest"] != null) {
            $event->setCancelled();
        }
        if ($event->getEntity()->namedtag["astroOursonQuest"] != null) {
            $event->setCancelled();
        }
        if ($event->getEntity()->namedtag["compressorPnj"] != null) {
            $event->setCancelled();
        }
        if ($event->getEntity()->namedtag["boxPnj"] != null) {
            $event->setCancelled();
        }
        if ($event->getEntity()->namedtag["boostPnj"] != null) {
            $event->setCancelled();
        }
        if ($event->getEntity()->namedtag["spawnTrainPnj"] != null) {
            $event->setCancelled();
        }
        if ($event->getEntity()->namedtag["trader"] != null) {
            $event->setCancelled();
        }
    }

    public function onTap(EntityDamageEvent $event)
    {
        if ($event->getEntity()->namedtag["astroQuest"] != null) {
            $event->setCancelled();
        }
        if ($event->getEntity()->namedtag["astroOursonQuest"] != null) {
            $event->setCancelled();
        }
        if ($event->getEntity()->namedtag["compressorPnj"] != null) {
            $event->setCancelled();
        }
        if ($event->getEntity()->namedtag["boxPnj"] != null) {
            $event->setCancelled();
        }
        if ($event->getEntity()->namedtag["boostPnj"] != null) {
            $event->setCancelled();
        }
        if ($event->getEntity()->namedtag["spawnTrainPnj"] != null) {
            $event->setCancelled();
        }
        if ($event->getEntity()->namedtag["trader"] != null) {
            $event->setCancelled();
        }
    }

    public function openGui(EntityDamageByEntityEvent $event)
    {
        if ($event->getEntity()->namedtag["astroQuest"] != null) {
            $damager = $event->getDamager();
            if ($damager instanceof Player) {
                if (QuestAPI::isFinished($damager) == 0) {
                    if (QuestAPI::getHaveSon($damager) == 1) {
                        AstronautQuest::end($damager);
                    } else {
                        AstronautQuest::first($damager);
                    }
                } else {
                    Texts::sendMessage($damager, Texts::$prefix, "Vous avez déjà fait la quête !", "You have aleardy finished this quest");
                }
                $event->setCancelled();
            }
        }

        if ($event->getEntity()->namedtag["astroOursonQuest"] != null) {
            $damager = $event->getDamager();
            if ($damager instanceof Player) {
                if (QuestAPI::isFinished($damager) == 0) {
                    AstronautQuest::fiston($damager);
                    QuestAPI::setHaveSon($damager);
                    Texts::sendMessage($damager, Texts::$prefixQuest, "Retournez voir le père !", "Go back to the father!");
                    $event->setCancelled();
                } else {
                    Texts::sendMessage($damager, Texts::$prefix, "Vous avez déjà fait la quête !", "You have aleardy finished this quest");
                }
            }
        }

        if ($event->getEntity()->namedtag["compressorPnj"] != null) {
            $damager = $event->getDamager();
            if ($damager instanceof Player) {
                if ($damager->getInventory()->contains(Item::get(266, 0, 2))) {
                    $damager->getInventory()->removeItem(Item::get(266, 0, 2));

                    /** Messages */
                    $uni = Unicodes::$coin;
                    Texts::sendMessage($damager, Texts::$prefix, "§7Merci, voici §31{$uni} §7en échange de cet or !", "§7Thank you, here's §31{$uni} §7in exchange for this gold!");

                    /** Coins */
                    CoinsAPI::addCoins($damager, 1);
                } else {
                    Texts::sendMessage($damager, Texts::$prefix, "§7Vous n'avez pas assez d'or !", "§7You don't have enough gold!");
                }
            }
        }

        if ($event->getEntity()->namedtag["boxPnj"] != null) {
            $damager = $event->getDamager();
            if ($damager instanceof Player) {
                BoxForms::open($damager);
            }
        }

        if ($event->getEntity()->namedtag["boostPnj"] != null) {
            $damager = $event->getDamager();
            if ($damager instanceof Player) {
                BlocksBoostForm::open($damager);
            }
        }

        if ($event->getEntity()->namedtag["spawnTrainPnj"] != null) {
            $damager = $event->getDamager();
            if ($damager instanceof Player) {
                if (!PlayerProtectManager::isIn($damager)) {
                    TrainKitForm::open($damager);
                } else {
                    Texts::sendMessage($damager, Texts::$prefix, "Vous êtes en combat !", "You are in now fight !");
                }
            }
        }

        if ($event->getEntity()->namedtag["trader"] != null) {
            $damager = $event->getDamager();
            if ($damager instanceof Player) {
                $p = $damager->getPlayer();
                AccessoryForm::open($p);
            }
        }
    }
}