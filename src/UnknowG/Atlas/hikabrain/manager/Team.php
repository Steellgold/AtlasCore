<?php

namespace UnknowG\Atlas\hikabrain\manager;

use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\hikabrain\tasks\StartGameTask;

class Team extends Game
{
    private static $team;

    public static $teams = ["Blue", "Red"];

    public static function getTeam(): Team
    {
        if (is_null(self::$team))
            self::$team = new Team();
        return self::$team;
    }

    public function getPlayerRed(Level $level)
    {
        $file = Atlas::getHikabrainFileData("games");
        return $file->get($level->getName())["redPlayer"];
    }

    public function getPlayerBlue(Level $level)
    {
        $file = Atlas::getHikabrainFileData("games");
        return $file->get($level->getName())["bluePlayer"];
    }

    public function getWinTeam(string $levelName)
    {
        $file = Atlas::getHikabrainFileData("games");
        return $file->get($levelName)["teamWinner"];
    }

    public function addWaintingFile(string $levelName, string $playerName, Atlas $server)
    {
        Game::$wfile[$playerName] = $levelName;

        $file = Atlas::getHikabrainFileData("WFile");

        $p1 = $file->get($levelName)["bluePlayer"];
        $p2 = $file->get($levelName)["redPlayer"];
        $p = Server::getInstance()->getPlayer($playerName);;


        if (Server::getInstance()->getPlayer($p1) instanceof Player) {
            if (Server::getInstance()->getPlayer($p2) instanceof Player) {
                $p->sendMessage("COMPLET");
            } else {
                $array = [
                    "bluePlayer" => $p1,
                    "redPlayer" => $playerName
                ];

                $file->set($levelName, $array);
                $file->save();

                $p->sendMessage("Add p2");

                $p11 = $file->get($levelName)["bluePlayer"];
                $p22 = $file->get($levelName)["redPlayer"];
                $pl1 = Server::getInstance()->getPlayer($p11);
                $pl2 = Server::getInstance()->getPlayer($p22);
                if($pl1 instanceof Player){
                    if($pl2 instanceof Player) {
                        $server->getScheduler()->scheduleRepeatingTask(new StartGameTask(Server::getInstance()->getLevelByName($levelName), $server, $pl1, $pl2), 20 * 2);
                    }else{
                        $p->sendMessage("erreur de lancement #2");
                    }
                }else{
                    $p->sendMessage("erreur de lancement #1");
                }
            }
        } else {
            $array = [
                "bluePlayer" => $playerName,
                "redPlayer" => $p2
            ];

            $file->set($levelName, $array);
            $file->save();

            $p->sendMessage("Add p1");
        }
    }

    public function isWaintingFile(Player $player){
        $wfile = Atlas::getHikabrainFileData("WFile");
        if($wfile->exists("hika1")){
            if($wfile->get("hika1")["redPlayer"] == $player->getName()){
                return true;
            }elseif($wfile->get("hika1")["bluePlayer"] == $player->getName()){
                return true;
            }else{
                return false;
            }
        }

        if($wfile->exists("hika2")){
            if($wfile->get("hika4")["redPlayer"] == $player->getName()){
                return true;
            }elseif($wfile->get("hika2")["bluePlayer"] == $player->getName()){
                return true;
            }else{
                return false;
            }
        }

        if($wfile->exists("hika3")){
            if($wfile->get("hika3")["redPlayer"] == $player->getName()){
                return true;
            }elseif($wfile->get("hika3")["bluePlayer"] == $player->getName()){
                return true;
            }else{
                return false;
            }
        }

        if($wfile->exists("hika4")){
            if($wfile->get("hika4")["redPlayer"] == $player->getName()){
                return true;
            }elseif($wfile->get("hika4")["bluePlayer"] == $player->getName()){
                return true;
            }else{
                return false;
            }
        }

        if($wfile->exists("hikaOriginal")){
            if($wfile->get("hikaOriginal")["redPlayer"] == $player->getName()){
                return true;
            }elseif($wfile->get("hikaOriginal")["bluePlayer"] == $player->getName()){
                return true;
            }else{
                return false;
            }
        }
    }

    public function defaultWFile(string $levelName)
    {
        $file = Atlas::getHikabrainFileData("WFile");

        $array = [
            "bluePlayer" => "none",
            "redPlayer" => "none"
        ];

        $file->set($levelName, $array);
        $file->save();
    }
}