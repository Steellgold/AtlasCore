<?php


namespace UnknowG\Atlas\pets\task;

use pocketmine\entity\EntityIds;
use pocketmine\inventory\CraftingGrid;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\MoveActorAbsolutePacket;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\pets\manager\Pets;
use UnknowG\Atlas\pets\manager\PetsSession;

class PetsTask extends Task
{
    public static $petsBigPlayer = [
        34,
        32,
        23,
        49,
        35,
        52,
        84,
        62,
        113,
        96,
        12,
        31,
        16,
        21,
        20
    ];
    public $plugin;

    /**
     * PetsTask constructor.
     * @param Atlas $plugin
     */
    public function __construct(Atlas $plugin)
    {
        $this->plugin = $plugin;
    }


    /**
     * @param int $refreshTick
     */
    public function onRun(int $refreshTick)
    {

        foreach (Server::getInstance()->getOnlinePlayers() as $p) {

            if (PetsSession::getPetsPlayer($p)) {

                $pk = new MoveActorAbsolutePacket();
                $pk->entityRuntimeId = PetsSession::$players[$p->getName()]["entity"];

                if(PetsSession::getPetsPlayerName($p) == 58 || PetsSession::getPetsPlayerName($p) == 65 || PetsSession::getPetsPlayerName($p) == 79){
                    $pk->position = new Vector3($p->getX(), $p->getY() + 3, $p->getZ());
                }elseif(PetsSession::getPetsPlayerName($p) == 62){
                    $pk->position = new Vector3($p->getX() + 1, $p->getY(), $p->getZ() + 1);
                }elseif(PetsSession::getPetsPlayerName($p) == 96 || PetsSession::getPetsPlayerName($p) == 84){
                    $pk->position = new Vector3($p->getX(), $p->getY() + 0.5, $p->getZ());
                }elseif(PetsSession::getPetsPlayerName($p) == 30){
                    $pk->position = new Vector3($p->getX(), $p->getY() + 1.4, $p->getZ() + 0.4);
                }else {
                    $pk->position = new Vector3($p->getX() + 1.5, $p->getY(), $p->getZ());
                }

                if(PetsSession::getPetsPlayerName($p) == 96 || PetsSession::getPetsPlayerName($p) == 84){
                    $pk->xRot = 0;
                    $pk->yRot = $p->yaw;
                    $pk->zRot = $p->yaw;
                }else{
                    $pk->xRot = $p->pitch;
                    $pk->yRot = $p->yaw;
                    $pk->zRot = $p->yaw;
                }

                $pk->flags = MoveActorAbsolutePacket::FLAG_GROUND;
                $p->sendDataPacket($pk);
                Server::getInstance()->broadcastPacket(Server::getInstance()->getOnlinePlayers(), $pk);

            }
        }
    }
}