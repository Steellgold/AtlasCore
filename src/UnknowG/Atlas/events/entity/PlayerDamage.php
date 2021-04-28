<?php

namespace UnknowG\Atlas\events\entity;

use pocketmine\block\Block;
use pocketmine\entity\projectile\Snowball;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageByChildEntityEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\level\particle\AngryVillagerParticle;
use pocketmine\level\particle\BlockForceFieldParticle;
use pocketmine\level\particle\CriticalParticle;
use pocketmine\level\particle\DestroyBlockParticle;
use pocketmine\level\particle\HappyVillagerParticle;
use pocketmine\level\particle\HeartParticle;
use pocketmine\level\particle\SmokeParticle;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\ApiXP;
use UnknowG\Atlas\api\CoinsAPI;
use UnknowG\Atlas\api\ParticlesAPI;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\data\sql\SQLDataServer;
use UnknowG\Atlas\events\player\PlayerDeath;
use UnknowG\Atlas\events\player\PlayerJoin;
use UnknowG\Atlas\task\StickTpTask;
use UnknowG\Atlas\utils\Rand;
use UnknowG\Atlas\utils\RespawnUtil;
use UnknowG\Atlas\utils\texts\Texts;
use UnknowG\Atlas\utils\texts\Unicodes;

class PlayerDamage implements Listener
{
    public $plugin;

    public function __construct(Atlas $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onDamage(EntityDamageEvent $event): void
    {
        if ($event instanceof EntityDamageByEntityEvent) {
            $player = $event->getEntity();
            $damager = $event->getDamager();

            if ($damager instanceof Player) {
                $particle = ParticlesAPI::getParticleStatus($damager, "particleUsed");

                switch ($particle) {
                    case "none":
                        break;
                    case "heartParticles":
                        $player->getLevel()->addParticle(new HeartParticle(new Vector3($player->x, $player->y + 1, $player->z)), [$damager]);
                        break;
                    case "greenParticles";
                        $player->getLevel()->addParticle(new HappyVillagerParticle(new Vector3($player->x, $player->y + 1, $player->z)), [$damager]);
                        break;
                    case "damageParticles";
                        $player->getLevel()->addParticle(new CriticalParticle(new Vector3($player->x, $player->y + 1, $player->z)), [$damager]);
                        break;
                    case "bloodParticles";
                        $player->getLevel()->addParticle(new DestroyBlockParticle(new Vector3($player->x, $player->y + 1, $player->z), Block::get(215)), [$damager]);
                        break;
                    case "cobwebParticles";
                        $player->getLevel()->addParticle(new DestroyBlockParticle(new Vector3($player->x, $player->y + 1, $player->z), Block::get(30)), [$damager]);
                        break;
                    case "dirtParticles";
                        $player->getLevel()->addParticle(new DestroyBlockParticle(new Vector3($player->x, $player->y + 1, $player->z), Block::get(3)), [$damager]);
                        break;

                    case "nitro";
                        $player->getLevel()->addParticle(new DestroyBlockParticle(new Vector3($player->x, $player->y + 1, $player->z), Block::get(222)), [$damager]);
                        $player->getLevel()->addParticle(new DestroyBlockParticle(new Vector3($player->x, $player->y + 1, $player->z), Block::get(226)), [$damager]);
                        break;

                    case "angry";
                        $player->getLevel()->addParticle(new AngryVillagerParticle(new Vector3($player->x, $player->y + 1, $player->z)), [$damager]);
                        break;
                    case "cactus";
                        $player->getLevel()->addParticle(new DestroyBlockParticle(new Vector3($player->x, $player->y + 1, $player->z), Block::get(81)), [$damager]);
                        break;
                    case "obsidian";
                        $player->getLevel()->addParticle(new DestroyBlockParticle(new Vector3($player->x, $player->y + 1, $player->z), Block::get(49)), [$damager]);
                        break;
                    case "sand";
                        $player->getLevel()->addParticle(new DestroyBlockParticle(new Vector3($player->x, $player->y + 1, $player->z), Block::get(12)), [$damager]);
                        break;
                    case "purpur";
                        $player->getLevel()->addParticle(new DestroyBlockParticle(new Vector3($player->x, $player->y + 1, $player->z), Block::get(201)), [$damager]);
                        break;
                    case "diamond";
                        $player->getLevel()->addParticle(new DestroyBlockParticle(new Vector3($player->x, $player->y + 1, $player->z), Block::get(57)), [$damager]);
                        break;
                }
            }
        }
    }

    public function onTapStick(EntityDamageEvent $event): void
    {
        if ($event instanceof EntityDamageByEntityEvent) {
            $player = $event->getEntity();
            $damager = $event->getDamager();

            $level = Server::getInstance()->getLevelByName("stick");

            if ($damager instanceof Player) {
                if ($player instanceof Player) {
                    if ($damager->getLevel() === $level) {
                        if ($damager->getInventory()->getItemInHand()->getId() == 280) {
                            Rand::giveRandCoin($damager);
                        }
                    }
                }
            }
        }
    }

    public function DamageFall(EntityDamageEvent $ev)
    {
        $entity = $ev->getEntity();
        if ($entity instanceof Player) {
            if ($ev->getCause() == EntityDamageEvent::CAUSE_FALL) {
                $ev->setCancelled();
            }

            if ($ev->getCause() == EntityDamageEvent::CAUSE_FIRE) {
                if(!$entity->getLevel()->getName() == "builduhc"){
                    if($entity->getHealth() >= 2){
                        $entity->setOnFire(0);
                    }

                    $entity->getPlayer()->getArmorInventory()->setContents([]);
                    $entity->getPlayer()->getInventory()->setContents([]);
                    $entity->getPlayer()->removeAllEffects();
                    PlayerJoin::giveCompass($entity->getPlayer());
                    PlayerDeath::tpLobbySpawn($entity->getPlayer());
                }
            }

            if ($ev->getCause() == EntityDamageEvent::CAUSE_LAVA) {
                if(!$entity->getLevel()->getName() == "builduhc"){
                    if($entity->getHealth() >= 2){
                        $entity->setOnFire(0);
                    }

                    $entity->getPlayer()->getArmorInventory()->setContents([]);
                    $entity->getPlayer()->getInventory()->setContents([]);
                    $entity->getPlayer()->removeAllEffects();
                    PlayerJoin::giveCompass($entity->getPlayer());
                    PlayerDeath::tpLobbySpawn($entity->getPlayer());
                }
            }

            // if ($ev->getCause() == EntityDamageEvent::CAUSE_SUICIDE) {
            // PlayerDeath::tpLobbySpawn($entity->getPlayer());
            // }

            if ($ev->getCause() == EntityDamageEvent::CAUSE_SUFFOCATION) {
                $entity->getPlayer()->getArmorInventory()->setContents([]);
                $entity->getPlayer()->getInventory()->setContents([]);
                $entity->getPlayer()->removeAllEffects();
                PlayerJoin::giveCompass($entity->getPlayer());
                PlayerDeath::tpLobbySpawn($entity->getPlayer());
            }

            if ($ev->getCause() == EntityDamageEvent::CAUSE_ENTITY_EXPLOSION) {
                $entity->getPlayer()->getArmorInventory()->setContents([]);
                $entity->getPlayer()->getInventory()->setContents([]);
                $entity->getPlayer()->removeAllEffects();
                PlayerJoin::giveCompass($entity->getPlayer());
                PlayerDeath::tpLobbySpawn($entity->getPlayer());
            }

            if ($ev->getCause() == EntityDamageEvent::CAUSE_VOID) {
                $entity->getPlayer()->getArmorInventory()->setContents([]);
                $entity->getPlayer()->getInventory()->setContents([]);
                $entity->getPlayer()->removeAllEffects();
                PlayerJoin::giveCompass($entity->getPlayer());
                PlayerDeath::tpLobbySpawn($entity->getPlayer());
            }
        }
    }

    public function snowballDamanger(EntityDamageEvent $e)
    {
        if ($e instanceof EntityDamageByChildEntityEvent) {
            $p = $e->getEntity();
            $child = $e->getChild();
            if ($child instanceof Snowball) {
                $e->setModifier(SQLDataServer::getServerData("snowball"), EntityDamageEvent::CAUSE_ENTITY_ATTACK);
            }

            if ($p->getHealth() - $e->getFinalDamage() <= 0) {
                $damager = $e->getDamager();
                if ($damager instanceof Player) {
                    if($damager->getLevel()->getName() == "ninja"){
                        RespawnUtil::giveNinjaKit($damager);
                    }
                }

                if ($p instanceof Player) {
                    $p->getInventory()->setContents([]);
                    $p->getArmorInventory()->setContents([]);
                    $p->removeAllEffects();
                    PlayerJoin::giveCompass($p);
                    PlayerDeath::tpLobbySpawn($p);
                }


                if(SQLData::getData($damager,"asALP") == 1){
                    if(RankAPI::isPremium($damager)){
                        if(RankAPI::isNitro($damager)){
                            $mt = mt_rand(100,150);
                            $num = $mt+ 50;
                        }else{
                            $mt = mt_rand(100,150);
                            $num = $mt+ 25;
                        }
                    }else{
                        $num = mt_rand(50,100);
                    }

                    $mt = mt_rand(1,30);
                    if($mt == 1){
                        $fl = SQLData::getData($p, "doubleXpBottles");
                        $ota = $fl + 1;
                        SQLData::setData($damager, "players", "doubleXpBottles",$ota);
                        Texts::sendMessage($damager,Texts::$prefixPass,"Vous avez gagné(e) un flocon de double xp, activez dans l'interface du §3ALP §7!","You have won a vial of double xp, activate in the §3ALP §7interface!");
                    }


                    if(SQLData::getData($damager,"doubleXpActive") == 1){
                        if(time() > SQLData::getData($damager,"doubleXpTime")){
                            Texts::sendMessage($damager, Texts::$prefixPass, "Votre double effet XP s'évapore, réutilisez-le en une seule fois pour l'obtenir à nouveau.", "Your double XP effect is evaporate, reuse in one to get it again.");
                            SQLData::setData($damager, "players", "doubleXpTime", 0);
                            SQLData::setData($damager, "players", "doubleXpActive", 0);

                            return;
                        }

                        ApiXP::addXp($damager,$num * 2);
                        $damager->getLevel()->dropExperience($damager->asVector3(),20);
                        $damager->getLevel()->dropExperience($damager->asVector3(),20);
                        $damager->getLevel()->dropExperience($damager->asVector3(),20);
                        $damager->getLevel()->dropExperience($damager->asVector3(),20);
                        $damager->getLevel()->dropExperience($damager->asVector3(),20);
                        $damager->getLevel()->dropExperience($damager->asVector3(),20);
                        $damager->getLevel()->dropExperience($damager->asVector3(),20);
                        $damager->getLevel()->dropExperience($damager->asVector3(),20);
                        $damager->getLevel()->dropExperience($damager->asVector3(),20);
                    }else{
                        ApiXP::addXp($damager,$num);
                    }

                    ApiXP::getLevelByXp($damager);
                }
            }
        }
    }
}