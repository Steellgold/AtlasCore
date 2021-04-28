<?php

namespace UnknowG\Atlas\commands\staff\manager;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\CoinsAPI;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;

class FloatingTextCommand extends Command
{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if ($player instanceof Player) {
            if (RankAPI::isManager($player)) {
                if(!isset($args[0])){
                    $player->sendMessage(Texts::$prefixStaff . "Vous avez oublié l'argument §6type §7en position 1");
                    return;
                }
                if(!in_array($args[0],["kills","alp","delete"])){
                    $player->sendMessage(Texts::$prefixStaff . "Une erreur c'est produite, voici les types disponibles: §6kills§7, §6coins§7, §6alp§7, §6points§7, §6delete");
                    return;
                }

                switch ($args[0]){
                    case "kills":
                        $msg = "";
                        $top = 1;
                        $conn = SQL::getDatabase();
                        foreach ($conn->query("SELECT playerKillCount,playerName FROM players ORDER BY playerKillCount DESC LIMIT 20") as $row) {
                            $msg .= "§l#" . $top . " §r" . $row["playerName"] . " with " . $row["playerKillCount"] . " kills\n";
                            $top++;
                        }

                        $nbt = Entity::createBaseNBT($player->asVector3(),$player->getMotion(), $player->getYaw(),$player->getPitch());
                        $nbt->setString("kills",uniqid());

                        $entity = Entity::createEntity("Creeper",$player->getLevel(),$nbt);
                        $entity->setNameTag("§3---- §lTop Kills §r§3----" . "\n$msg" . "§3---- §lTop Kills §r§3----");
                        $entity->setNameTagAlwaysVisible(true);
                        $entity->setInvisible(false);
                        $entity->spawnToAll();
                        break;

                    case "alp":
                        $msg = "";
                        $top = 1;
                        $conn = SQL::getDatabase();
                        foreach ($conn->query("SELECT playerLevel,playerXP,playerName FROM players ORDER BY playerLevel DESC LIMIT 20") as $row) {
                            $msg .= "§l#" .$top . " §r" . $row["playerName"] . " is level §l" . $row["playerLevel"] . " §rwith §l" . $row["playerXP"] . " XP\n";
                            $top++;
                        }

                        $nbt = Entity::createBaseNBT($player->asVector3(),$player->getMotion(), $player->getYaw(),$player->getPitch());
                        $nbt->setString("alp",uniqid());

                        $entity = Entity::createEntity("Creeper",$player->getLevel(),$nbt);
                        $entity->setNameTag("§3---- §lTop Levels on the ALP §r§3----" . "\n$msg" . "§3---- §lTop Levels on the ALP §r§3----");
                        $entity->setNameTagAlwaysVisible(true);
                        $entity->setInvisible(false);
                        $entity->spawnToAll();
                        break;

                    case "delete":
                        if(isset($args[1])){
                            if(!in_array($args[1],["kills","alp"])){
                                $player->sendMessage(Texts::$prefixStaff . "Une erreur c'est produite, voici les types disponibles: §6kills§7, §6alp");
                                return;
                            }

                            switch ($args[1]){
                                case "kills":
                                    foreach (Server::getInstance()->getLevelByName("atlas")->getEntities() as $entity){
                                        if($entity->namedtag->getName() == "kills"){
                                            $entity->kill();
                                        }
                                    }
                                    break;

                                case "alp":
                                    foreach (Server::getInstance()->getLevelByName("atlas")->getEntities() as $entity){
                                        if($entity->namedtag->getName() == "alp"){
                                            $entity->kill();
                                        }
                                    }
                                    break;
                            }
                        }else{
                            $player->sendMessage(Texts::$prefixStaff . "Une erreur c'est produite, voici les types disponibles: §6kills§7, §6alp");
                        }
                        break;
                }
            } else {
                Texts::returnNotPermission($player);
            }
        }
    }
}