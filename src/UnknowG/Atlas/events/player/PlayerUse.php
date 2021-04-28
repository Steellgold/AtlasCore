<?php

namespace UnknowG\Atlas\events\player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\forms\alp\ALPForm;
use UnknowG\Atlas\forms\capes\CapesForm;
use UnknowG\Atlas\forms\CosmetiquesForm;
use UnknowG\Atlas\forms\NitroForm;
use UnknowG\Atlas\forms\staff\HomePageForm;
use UnknowG\Atlas\forms\utils\GamesDuelForm;
use UnknowG\Atlas\forms\utils\GamesForm;
use UnknowG\Atlas\forms\utils\SettingsForm;
use UnknowG\Atlas\forms\utils\StatisticsForm;
use UnknowG\Atlas\pets\manager\Pets;
use UnknowG\Atlas\task\util\texts\WorldTextTask;
use UnknowG\Atlas\utils\texts\Texts;

class PlayerUse implements Listener
{
    public $plugin;

    public function __construct(Atlas $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onUse(PlayerInteractEvent $event)
    {
        if ($event->getItem()->getId() == 399) {
            if ($event->getItem()->getName() == "Games") {
                GamesForm::open($event->getPlayer());
            }
        }

        /**
        if ($event->getItem()->getId() == 383) {
            if(SQL::getData($event->getPlayer(),"playerSSRank") == "nitro"){
                NitroForm::choose($event->getPlayer());
            }else{
                Texts::sendMessage($event->getPlayer(),Texts::$prefixBoost,"§7Si vous avez déjà boosté le serveur Discord, exécutez la commande §d&boost {$event->getPlayer()->getName()} §7sur le discord puis se reconnecter !","§7If you have boosted the Discord server at the moment, execute the command §d&boost {$event->getPlayer()->getName()} §7on the discord then reconnect!");
            }
        }
         */

        if ($event->getItem()->getId() == 397 && $event->getItem()->getDamage() == 3) {
            if ($event->getItem()->getName() == "Statistics") {
                $event->setCancelled();
                StatisticsForm::open($event->getPlayer());
            }
        }

        if ($event->getItem()->getId() == 345) {
            if ($event->getItem()->getName() == "§3§lSTAFF") {
                $event->setCancelled();
                HomePageForm::owner($event->getPlayer());
            }
        }

        if ($event->getItem()->getId() == 145) {
            if ($event->getItem()->getName() == "Settings") {
                $event->setCancelled();
                SettingsForm::open($event->getPlayer());
            }
        }

        if ($event->getItem()->getId() == 342) {
            if ($event->getItem()->getName() == "Cosmetics") {
                $event->setCancelled();
                CosmetiquesForm::open($event->getPlayer());
            }
        }

        if ($event->getItem()->getId() == 384) {
            if ($event->getItem()->getName() == "Atlas Level Pass") {
                $event->setCancelled();
                if(SQLData::getData($event->getPlayer(),"asALP") == 1){
                    ALPForm::open($event->getPlayer());
                }else{
                    ALPForm::openBuy($event->getPlayer());
                }
            }
        }

        if ($event->getItem()->getId() == 450) {
            if ($event->getItem()->getName() == "Duels") {
                GamesDuelForm::openworlds($event->getPlayer());
            }
        }

        if ($event->getItem()->getId() == 355 && $event->getItem()->getDamage() == 7) {
            if ($event->getItem()->getName() == "Return to Lobby") {
                $event->setCancelled();
                PlayerUse::showPlayers($event->getPlayer());
                if(SQLData::getData($event->getPlayer(),"flyLobby") == 1){
                    $event->getPlayer()->setAllowFlight(true);
                    $event->getPlayer()->setFlying(true);
                }else{
                    $event->getPlayer()->setAllowFlight(false);
                    $event->getPlayer()->setFlying(false);
                }

                $event->getPlayer()->setImmobile(false);
                $event->getPlayer()->getInventory()->clearAll();
                $event->getPlayer()->removeAllEffects();
                $event->getPlayer()->getArmorInventory()->setContents([]);


                PlayerJoin::giveCompass($event->getPlayer());
                PlayerDeath::tpLobbySpawn($event->getPlayer());
            }
        }


        if ($event->getItem()->getId() == 368) {
            PlayerUse::showPlayers($event->getPlayer());
            if ($event->getItem()->getName() == "Training") {
                $event->setCancelled();
                $event->getPlayer()->sendMessage(Texts::$prefix . Texts::getText(SQLData::getLang($event->getPlayer()), "En recherche de monde disponibles..", "Searching for available worlds"));

                $w1 = count(Server::getInstance()->getLevelByName("train1")->getPlayers());
                $w2 = count(Server::getInstance()->getLevelByName("train2")->getPlayers());
                $w3 = count(Server::getInstance()->getLevelByName("train3")->getPlayers());
                $w4 = count(Server::getInstance()->getLevelByName("train4")->getPlayers());
                $w5 = count(Server::getInstance()->getLevelByName("train5")->getPlayers());

                if ($w1 >= 2) {
                    if ($w2 >= 2) {
                        if ($w3 >= 2) {
                            if ($w4 >= 2) {
                                if ($w5 >= 2) {
                                    Texts::sendMessage($event->getPlayer(), Texts::$prefix, "Aucun mondes disponibles", "No worlds avaibles");
                                } else {
                                    $event->getPlayer()->setAllowFlight(false);
                                    $event->getPlayer()->setFlying(false);

                                    $this->plugin->getScheduler()->scheduleDelayedTask(new WorldTextTask($event->getPlayer(), Texts::$prefix . Texts::getText(SQLData::getLang($event->getPlayer()), "Téléportation au §3train5", "Teleportation to §3train5"), 5), 20 * 2);
                                }
                            } else {
                                $event->getPlayer()->setAllowFlight(false);
                                $event->getPlayer()->setFlying(false);

                                $this->plugin->getScheduler()->scheduleDelayedTask(new WorldTextTask($event->getPlayer(), Texts::$prefix . Texts::getText(SQLData::getLang($event->getPlayer()), "Téléportation au §3train4", "Teleportation to §3train4"), 4), 20 * 2);
                            }
                        } else {
                            $event->getPlayer()->setAllowFlight(false);
                            $event->getPlayer()->setFlying(false);

                            $this->plugin->getScheduler()->scheduleDelayedTask(new WorldTextTask($event->getPlayer(), Texts::$prefix . Texts::getText(SQLData::getLang($event->getPlayer()), "Téléportation au §3train3", "Teleportation to §3train3"), 3), 20 * 2);
                        }
                    } else {
                        $event->getPlayer()->setAllowFlight(false);
                        $event->getPlayer()->setFlying(false);

                        $this->plugin->getScheduler()->scheduleDelayedTask(new WorldTextTask($event->getPlayer(), Texts::$prefix . Texts::getText(SQLData::getLang($event->getPlayer()), "Téléportation au §3train2", "Teleportation to §3train2"), 3), 20 * 2);
                    }
                } else {
                    $event->getPlayer()->setAllowFlight(false);
                    $event->getPlayer()->setFlying(false);

                    $this->plugin->getScheduler()->scheduleDelayedTask(new WorldTextTask($event->getPlayer(), Texts::$prefix . Texts::getText(SQLData::getLang($event->getPlayer()), "Téléportation au §3train1", "Teleportation to §3train1"), 1), 20 * 2);
                }
            }
        }
    }

    public static function showPlayers(Player $player)
    {
        Pets::isBig($player);
        foreach (Server::getInstance()->getOnlinePlayers() as $players) {
            $player->showPlayer($players);
        }
    }
}