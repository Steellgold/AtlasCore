<?php


namespace UnknowG\Atlas\pets\manager;

use pocketmine\entity\Entity;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\AddActorPacket;
use pocketmine\network\mcpe\protocol\RemoveActorPacket;
use pocketmine\Player;
use pocketmine\Server;

class PetsSession
{
    public static $players = [];

    const BIGGEST_PETS_BY_ID = [
        "53",
        "41"
    ];

    /**
     * @param Player $player
     * @return bool|mixed
     */
    public static function getPetsPlayerName(Player $player)
    {
        if (isset(PetsSession::$players[$player->getName()])) {
            return PetsSession::$players[$player->getName()]["id"];
        }
        return false;
    }

    /**
     * @param Player $player
     * @return bool|mixed
     */
    public static function getPetsPlayer(Player $player)
    {
        if (isset(PetsSession::$players[$player->getName()])) {
            return PetsSession::$players[$player->getName()];
        }
        return false;
    }


    /**
     * @param Player $player
     * @param string $name
     */
    public static function setPets(Player $player, string $name)
    {
        if (isset(Pets::$pets[$name])) {
            self::removePets($player);
            PetsSession::$players[$player->getName()]["entity"] = Entity::$entityCount++;
            PetsSession::$players[$player->getName()]["id"] = Pets::$pets[$name];

            $pk = new AddActorPacket();
            $pk->entityRuntimeId = PetsSession::$players[$player->getName()]["entity"];
            $pk->type = PetsSession::$players[$player->getName()]["id"];
            $pk->position = $player->asVector3()->add(0, 3, 0);
            $pk->yaw = $player->getYaw();
            $pk->pitch = $player->getPitch();
            if (in_array(PetsSession::$players[$player->getName()]["id"], self::BIGGEST_PETS_BY_ID)) {
                $pk->metadata = [Entity::DATA_SCALE => [Entity::DATA_TYPE_FLOAT, 0.5]];
            }

            Server::getInstance()->broadcastPacket(Server::getInstance()->getOnlinePlayers(), $pk);
        }
    }

    /**
     * @param Player $player
     * @return bool
     */
    public static function removePets(Player $player)
    {

        if (isset(PetsSession::$players[$player->getName()])) {

            $pk = new RemoveActorPacket();
            $pk->entityUniqueId = PetsSession::$players[$player->getName()]["entity"];
            $player->sendDataPacket($pk);

            Server::getInstance()->broadcastPacket(Server::getInstance()->getOnlinePlayers(), $pk);
            unset(PetsSession::$players[$player->getName()]);

            return true;
        }
        return false;
    }
}