<?php


namespace UnknowG\Atlas\events\entity;


use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\ApiXP;
use UnknowG\Atlas\api\CoinsAPI;
use UnknowG\Atlas\api\LeaguesAPI;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\events\player\PlayerDeath;
use UnknowG\Atlas\events\player\PlayerJoin;
use UnknowG\Atlas\mgr\PlayerProtectManager as PPM;
use UnknowG\Atlas\task\respawns\BowTask;
use UnknowG\Atlas\task\respawns\GappleTask;
use UnknowG\Atlas\task\respawns\GravityTask;
use UnknowG\Atlas\task\respawns\NodeBuffTask;
use UnknowG\Atlas\utils\Rand;
use UnknowG\Atlas\utils\RespawnUtil;
use UnknowG\Atlas\utils\texts\Texts;
use UnknowG\Atlas\utils\texts\Unicodes;

class PlayerFastRespawn implements Listener
{
    public $plugin;

    public function __construct(Atlas $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onFight(EntityDamageByEntityEvent $ev)
    {
        $entity = $ev->getEntity();
        if ($entity instanceof Player) {
            if ($entity->getLevel()->getName() == "hika1" or $entity->getLevel()->getName() == "hika2" or $entity->getLevel()->getName() == "hika3" or $entity->getLevel()->getName() == "hika4" or $entity->getLevel()->getName() == "hikaOriginal") {

            }else{
                if ($entity->getHealth() - $ev->getFinalDamage() <= 0) {
                    if ($ev->getCause() == EntityDamageEvent::CAUSE_ENTITY_ATTACK) {
                        $killer = $entity->getLastDamageCause()->getDamager();

                        if ($entity instanceof Player) {
                            if (PPM::isIn($entity)) {
                                PPM::delIn($entity);
                            }

                            /** Partie Points*/
                            LeaguesAPI::addDeath($entity, 1);

                            $leveldeath = $entity->getLevel();
                            if ($leveldeath->getName() === "gravity" or $leveldeath->getName() === "train1" or $leveldeath->getName() === "train2" or $leveldeath->getName() === "train3" or $leveldeath->getName() === "train4" or $leveldeath->getName() === "train5" or $leveldeath->getName() === "arena1" or $leveldeath->getName() === "arena2" or $leveldeath->getName() === "arena3" or $leveldeath->getName() === "arena5" or $leveldeath->getName() === "stick" or $leveldeath->getName() === "combo" or $leveldeath->getName() === "sumo" or $leveldeath->getName() === "ninja") {

                            } else {
                                if (LeaguesAPI::getPoints($entity) >= 200) {
                                    LeaguesAPI::delPoints($entity, 1);
                                }
                            }

                            if ($entity->getInventory())

                                $entity->getPlayer()->getInventory()->clearAll();
                            $entity->getArmorInventory()->setContents([]);
                            $entity->removeAllEffects();

                            PlayerJoin::giveCompass($entity);
                        }

                        // Mec qui bute

                        if ($killer instanceof Player) {
                            if (PPM::isIn($killer)) {
                                PPM::delIn($killer);
                            }

                            /** Partie Points */
                            LeaguesAPI::addKill($killer, 1);

                            $leveldeath = $killer->getLevel();
                            if ($leveldeath->getName() === "gravity" or $leveldeath->getName() === "train1" or $leveldeath->getName() === "train2" or $leveldeath->getName() === "train3" or $leveldeath->getName() === "train4" or $leveldeath->getName() === "train5" or $leveldeath->getName() === "arena1" or $leveldeath->getName() === "arena2" or $leveldeath->getName() === "arena3" or $leveldeath->getName() === "arena5" or $leveldeath->getName() === "stick" or $leveldeath->getName() === "combo" or $leveldeath->getName() === "sumo" or $leveldeath->getName() === "ninja") {

                            } else {
                                if ($leveldeath->getName() == "arena4") {
                                    $entity->getInventory()->setContents([]);
                                    $entity->getArmorInventory()->setContents([]);
                                    $killer->getInventory()->setContents([]);
                                    $killer->getArmorInventory()->setContents([]);

                                    PlayerDeath::tpLobbySpawn($killer);
                                    PlayerJoin::giveCompass($killer);

                                    PlayerDeath::tpLobbySpawn($entity);
                                    PlayerJoin::giveCompass($entity);
                                }
                                LeaguesAPI::addPoints($killer, 1);

                                if (SQLData::getData($killer, "asALP") == 1) {
                                    if (RankAPI::isPremium($killer)) {
                                        if (RankAPI::isNitro($killer)) {
                                            $mt = mt_rand(100, 150);
                                            $num = $mt + 50;
                                        } else {
                                            $mt = mt_rand(100, 150);
                                            $num = $mt + 25;
                                        }
                                    } else {
                                        $num = mt_rand(50, 100);
                                    }

                                    $mt = mt_rand(1, 30);
                                    if ($mt == 1) {
                                        $fl = SQLData::getData($killer, "doubleXpBottles");
                                        $ota = $fl + 1;
                                        SQLData::setData($killer, "players", "doubleXpBottles", $ota);
                                        Texts::sendMessage($killer, Texts::$prefixPass, "Vous avez gagné(e) un flocon de double xp, activez dans l'interface du §3ALP §7!", "You have won a vial of double xp, activate in the §3ALP §7interface!");
                                    }


                                    if (SQLData::getData($killer, "doubleXpActive") == 1) {
                                        if (time() > SQLData::getData($killer, "doubleXpTime")) {
                                            Texts::sendMessage($killer, Texts::$prefixPass, "Votre double effet XP s'évapore, réutilisez-le en une seule fois pour l'obtenir à nouveau.", "Your double XP effect is evaporate, reuse in one to get it again.");
                                            SQLData::setData($killer, "players", "doubleXpTime", 0);
                                            SQLData::setData($killer, "players", "doubleXpActive", 0);

                                            return;
                                        }

                                        ApiXP::addXp($killer, $num * 2);
                                        $killer->getLevel()->dropExperience($killer->asVector3(), 20);
                                        $killer->getLevel()->dropExperience($killer->asVector3(), 20);
                                        $killer->getLevel()->dropExperience($killer->asVector3(), 20);
                                        $killer->getLevel()->dropExperience($killer->asVector3(), 20);
                                        $killer->getLevel()->dropExperience($killer->asVector3(), 20);
                                        $killer->getLevel()->dropExperience($killer->asVector3(), 20);
                                        $killer->getLevel()->dropExperience($killer->asVector3(), 20);
                                        $killer->getLevel()->dropExperience($killer->asVector3(), 20);
                                        $killer->getLevel()->dropExperience($killer->asVector3(), 20);
                                    } else {
                                        ApiXP::addXp($killer, $num);
                                    }

                                    ApiXP::getLevelByXp($killer);
                                }
                            }

                            /** Partie Effets */
                            if (RankAPI::isPremium($killer)) {
                                PlayerDeath::spawnLG($entity);
                                /**
                                 * if(SQLData::getData($killer,"lgShow") == 1){
                                 * switch (SQLData::getData($killer,"lgUsed")){
                                 * case "lg":
                                 * PlayerDeath::spawnLG($entity);
                                 * break;
                                 *
                                 * case "rk":
                                 * PlayerDeath::spawnRocket($entity);
                                 * break;
                                 *
                                 * default:
                                 *
                                 * break;
                                 * }
                                 * }
                                 *  */

                                // Texts::sendMessage($killer,Texts::$prefixPrenium,"Les effets de kills reviennent sous peu","The effects of the kills are coming back soon");
                            }
                            PlayerDeath::tpLobbySpawn($entity);
                            $entity->setGamemode(2);

                            /** Coins on Kill */
                            Rand::giveRandCoin($killer);

                            /** HP */
                            $killer->setHealth(20);
                            $killer->setFood(20);

                            // ------ Regive de kit
                            $leveldeath = $killer->getLevel();
                            if ($leveldeath->getName() === "gravity") {
                                RespawnUtil::giveGappleKit($killer);
                            }
                            if ($leveldeath->getName() === "bow") {
                                RespawnUtil::giveArcKit($killer);

                                PlayerDeath::tpLobbySpawn($entity);
                                $entity->getInventory()->setContents([]);
                                $entity->getArmorInventory()->setContents([]);
                                $killer->getInventory()->setContents([]);
                                $killer->getArmorInventory()->setContents([]);
                                PlayerJoin::giveCompass($entity);
                            }
                            if ($leveldeath->getName() === "gapple") {
                                RespawnUtil::giveGappleKit($killer);
                            }
                            if ($leveldeath->getName() === "ninja") {
                                RespawnUtil::giveNinjaKit($killer);
                            }
                            if ($leveldeath->getName() === "nodebuff") {
                                RespawnUtil::giveNodeKit($killer);
                            }
                            if ($leveldeath->getName() === "builduhc") {
                                RespawnUtil::giveBuildKit($killer);
                            }

                            /** Training */
                            if ($leveldeath->getName() === "train1" || $leveldeath->getName() === "train2" || $leveldeath->getName() === "train3" || $leveldeath->getName() === "train4" || $leveldeath->getName() === "train5") {
                                /** Remove all inventory */
                                $entity->getArmorInventory()->setContents([]);
                                $entity->getInventory()->clearAll();
                                $killer->getArmorInventory()->setContents([]);
                                $killer->getInventory()->clearAll();
                                $killer->removeAllEffects();
                                $entity->removeAllEffects();

                                PlayerDeath::tpLobbySpawn($killer);
                                PlayerJoin::giveCompass($killer);
                                PlayerDeath::tpLobbySpawn($entity);
                                PlayerJoin::giveCompass($entity);

                                foreach (Server::getInstance()->getLevelByName($leveldeath->getName())->getPlayers() as $entitys) {
                                    PlayerDeath::tpLobbySpawn($entitys);
                                    $entitys->setGamemode(2);
                                    /** Remove all effetcs */
                                    $entitys->removeAllEffects();

                                    /** Remove all inventory */
                                    $entitys->getArmorInventory()->setContents([]);
                                    $entitys->getInventory()->clearAll();
                                    $entitys->removeAllEffects();

                                    /** Tp Lobby */
                                    PlayerDeath::tpLobbySpawn($entitys);
                                    PlayerJoin::giveCompass($entitys);
                                    Texts::sendMessage($entitys, Texts::$prefix, "§7Vous sortez du mode §3entrainement §7j'espère que vous vous êtes améliorer !", "§7You're going out of the game mode §3training §7I hope you've improved !");
                                }
                            }
                            if ($leveldeath->getName() === "arena1" || $leveldeath->getName() === "arena2" || $leveldeath->getName() === "arena3" || $leveldeath->getName() === "arena5") {
                                /** Remove all inventory */
                                $entity->getArmorInventory()->setContents([]);
                                $entity->getInventory()->clearAll();
                                $killer->getArmorInventory()->setContents([]);
                                $killer->getInventory()->clearAll();

                                PlayerDeath::tpLobbySpawn($killer);
                                PlayerJoin::giveCompass($killer);
                                PlayerDeath::tpLobbySpawn($entity);
                                PlayerJoin::giveCompass($entity);


                                foreach (Server::getInstance()->getLevelByName($leveldeath->getName())->getPlayers() as $entitys) {
                                    PlayerDeath::tpLobbySpawn($entitys);
                                    $entitys->setGamemode(2);
                                    /** Remove all effetcs */
                                    $entitys->removeAllEffects();

                                    /** Remove all inventory */
                                    $entitys->getArmorInventory()->setContents([]);
                                    $entitys->getInventory()->clearAll();
                                    $entitys->removeAllEffects();

                                    /** Tp Lobby */
                                    PlayerDeath::tpLobbySpawn($entitys);
                                    PlayerJoin::giveCompass($entitys);


                                    $reward = LeaguesAPI::getKillsRewardByPoints($entity);
                                    $uni = Unicodes::$coin;

                                    Texts::sendMessage($entitys, Texts::$prefix, "§7Vous sortez du mode §3duels §7j'espère que vous vous êtes améliorer !", "§7You're going out of the game mode §3duals §7I hope you've improved !");
                                    Texts::sendMessage($killer, Texts::$prefix, "§7Vous avez tué(e) un joueur en §31v1 §7vous recevez §3{$reward}$uni §7par rapport à ca ligue !", "§7You killed a player in §31v1 §7you receive §3{$reward}$uni §7compared to this league!");
                                    CoinsAPI::addCoins($killer, $reward);
                                }
                            }


                            if (SQLData::getData($entity, "asHeadPrice") == "true") {
                                $c = SQLData::getData($entity, "headPrice");
                                $uni = Unicodes::$coin;

                                CoinsAPI::addCoins($killer, SQLData::getData($entity, "headPrice"));
                                Texts::sendMessage($killer, Texts::$prefix, "Vous avez éliminé un joueur, à qui il y avait une tête à prix, vous avez donc récuperer §3$c" . " $uni", "You have eliminated a player, to whom there was a prize head, so you got §3$c" . " $uni");

                                Server::getInstance()->broadcastMessage(Texts::$prefix . "§3{$entity->getName()}§7's head is worthless, he was killed by §3{$killer->getName()} !");

                                CoinsAPI::delOffCoins(SQLData::getData($entity, "headPriceSeller"), SQLData::getData($entity, "headPrice"));

                                SQLData::setData($entity, "players", "headPrice", 0);
                                SQLData::setData($entity, "players", "headPriceSeller", "none");
                                SQLData::setData($entity, "players", "asHeadPrice", "false");
                            }
                        }


                        foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer) {
                            if (SQLData::getData($onlinePlayer, "showPopus") == 1) {
                                if (SQLData::getData($killer, "isNick") == 1) {
                                    if (SQLData::getData($entity, "isNick") == 1) {
                                        $onlinePlayer->sendTip("§e" . SQLData::getData($entity, "nickName") . "§7 killed by §e" . SQLData::getData($killer, "nickName"));
                                    } else {
                                        $onlinePlayer->sendTip("§e" . $entity->getName() . "§7 killed by §e" . SQLData::getData($killer, "nickName"));
                                    }
                                } else {
                                    if (SQLData::getData($entity, "isNick")) {
                                        $onlinePlayer->sendTip("§e" . SQLData::getData($entity, "nickName") . "§7 killed by §e" . $killer->getName());
                                    } else {
                                        $onlinePlayer->sendTip("§e" . $entity->getName() . "§7 killed by §e" . $killer->getName());
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}