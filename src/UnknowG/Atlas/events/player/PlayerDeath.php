<?php

namespace UnknowG\Atlas\events\player;

use pocketmine\entity\Entity;
use pocketmine\event\Listener;
use pocketmine\level\particle\FlameParticle;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\AddActorPacket;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\ParticlesAPI;
use pocketmine\utils\Random;
use UnknowG\Atlas\Atlas;


class PlayerDeath implements Listener
{
    public $plugin;
    public function __construct(Atlas $plugin)
    {
        $this->plugin = $plugin;
    }

    public static function spawnLG(Player $player)
    {
        $light = $player->getLevel();
        $light = new AddActorPacket();
        $light->type = 93;
        $light->entityRuntimeId = Entity::$entityCount++;
        $light->metadata = array();
        $light->motion = null;
        $light->yaw = $player->getYaw();
        $light->pitch = $player->getPitch();
        $light->position = new Vector3($player->getX(), $player->getY(), $player->getZ());
        Server::getInstance()->broadcastPacket($player->getLevel()->getPlayers(), $light);
        $sound = new PlaySoundPacket();
        $sound->x = $player->getX();
        $sound->y = $player->getY();
        $sound->z = $player->getZ();
        $sound->volume = 3;
        $sound->pitch = 2;
        $sound->soundName = "AMBIENT.WEATHER.LIGHTNING.IMPACT";
        Server::getInstance()->broadcastPacket($player->getLevel()->getPlayers(), $sound);
    }

    public static function spawnRocket(Player $player)
    {
        $rocket = $player->getLevel();
        $rocket = new AddActorPacket();
        $rocket->type = 72;
        $rocket->entityRuntimeId = Entity::$entityCount++;
        $rocket->metadata = array();
        $rocket->motion = null;
        $rocket->yaw = $player->getYaw();
        $rocket->pitch = $player->getPitch();
        $rocket->position = new Vector3($player->getX(), $player->getY(), $player->getZ());
        Server::getInstance()->broadcastPacket($player->getLevel()->getPlayers(), $rocket);
    }

    public function spawnFlame(Player $player)
    {

        $random = new Random((int) (microtime(true) * 1000) + mt_rand());
        $particle  = new FlameParticle(new Vector3($player->x, $player->y , $player->z));
        
        for($yaw = 0, $y = $player->y; $y < $player->y + 2; $yaw += (M_PI * 2) / 20, $y += 1 / 20){
            $x = -sin($yaw) + $player->x;
            $z = cos($yaw) + $player->z;
            for($i = 0; $i < ParticlesAPI::getParticleStatus($player,"partCounts"); ++$i){ // mini 1 ,max 10 - 20
                $particle->setComponents(
                    $player->x + $random->nextSignedFloat() * 1,
                    $player->y + $random->nextSignedFloat() * 1,
                    $player->z + $random->nextSignedFloat() * 1
                );
                $player->getLevel()->addParticle($particle);
            }

        }
    }

    public static function tpGappleSpawn(Player $player){
        $player->setScale(1);
        $player->setMaxHealth(20);
        $player->setHealth(20);
        $player->teleport(new Position(-51, 65, -166,Server::getInstance()->getLevelByName("gapple")));
    }

    public static function tpNodeBuffSpawn(Player $player){
        $player->setScale(1);
        $player->setMaxHealth(20);
        $player->setHealth(20);
        $player->teleport(new Position(93, 107, -27,Server::getInstance()->getLevelByName("nodebuff")));
    }

    public static function tpGravitySpawn(Player $player){
        $player->setScale(1);
        $player->setMaxHealth(20);
        $player->setHealth(20);
        $player->teleport(new Position(229, 102, -26,Server::getInstance()->getLevelByName("gravity")));
    }

    public static function tpStickSpawn(Player $player){
        $player->setScale(1);
        $player->setMaxHealth(20);
        $player->setHealth(20);
        $player->teleport(new Position(-49, 73, -43,Server::getInstance()->getLevelByName("stick")));
    }

    public static function tpBowSpawn(Player $player){
        $player->setScale(1);
        $player->setMaxHealth(20);
        $player->setHealth(20);
        $player->teleport(new Position(-47, 102, -28,Server::getInstance()->getLevelByName("bow")));
    }

    public static function tpLobbySpawn(Player $player){
        $player->setScale(1);
        $player->setMaxHealth(20);
        $player->setHealth(20);
        $player->teleport(new Position(-33, 102, -31,Server::getInstance()->getLevelByName("atlas")));
        $player->setImmobile(false);
    }

    public static function tpNinjaSpawn(Player $player){
        $player->setScale(1);
        $player->setMaxHealth(20);
        $player->setHealth(20);
        $player->teleport(new Position(-314, 56, 338,Server::getInstance()->getLevelByName("ninja")));
    }

    public static function tpBuildUHC(Player $player){
        $player->setScale(1);
        $player->setMaxHealth(20);
        $player->setHealth(20);
        $player->teleport(new Position(-287, 58, 136,Server::getInstance()->getLevelByName("builduhc")));
    }

    public static function tpCombo(Player $player){
        $player->setScale(1);
        $player->setMaxHealth(20);
        $player->setHealth(20);
        $player->teleport(new Position(-297, 89, 11,Server::getInstance()->getLevelByName("combo")));
    }
}