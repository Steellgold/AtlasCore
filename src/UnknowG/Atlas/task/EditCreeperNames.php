<?php


namespace UnknowG\Atlas\task;


use pocketmine\scheduler\Task;
use pocketmine\Server;
use UnknowG\Atlas\data\SQL;

class EditCreeperNames extends Task
{
    public function onRun(int $currentTick)
    {
        foreach (Server::getInstance()->getLevelByName("atlas")->getEntities() as $entity){
            if (isset($entity->namedtag["kills"])) {
                $msg = "";
                $top = 1;
                $conn = SQL::getDatabase();
                foreach ($conn->query("SELECT playerKillCount,playerName FROM players ORDER BY playerKillCount DESC LIMIT 20") as $row) {
                    $msg .= "§l#" . $top . " §r" . $row["playerName"] . " with " . $row["playerKillCount"] . " kills\n";
                    $top++;
                }

                $entity->setNameTagAlwaysVisible(true);
                $entity->setNameTag("§3---- §lTop Kills §r§3----" . "\n$msg" . "§3---- §lTop Kills §r§3----");
            }

            if (isset($entity->namedtag["alp"])) {
                $msg = "";
                $top = 1;
                $conn = SQL::getDatabase();
                foreach ($conn->query("SELECT playerLevel,playerXP,playerName FROM players ORDER BY playerLevel DESC LIMIT 20") as $row) {
                    $msg .= "§l#" .$top . " §r" . $row["playerName"] . " is level §l" . $row["playerLevel"] . " §rwith §l" . $row["playerXP"] . " XP\n";
                    $top++;
                }

                $entity->setNameTagAlwaysVisible(true);
                $entity->setNameTag("§3---- §lTop Levels on the ALP §r§3----" . "\n$msg" . "§3---- §lTop Levels on the ALP §r§3----");
            }
        }
    }
}