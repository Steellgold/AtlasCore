<?php

namespace UnknowG\Atlas\hikabrain\manager;

use pocketmine\block\Block;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\Atlas;

class Game{
    private static $game;
    public static $wfile = [];

    public static $worlds = ["hika1","hika2","hika3","hika4","hikaOriginal"];

    public static function getGame(): Game{
        if (is_null(self::$game))
            self::$game = new Game();
        return self::$game;
    }

    public function getFile(string $level){
        $file = Atlas::getHikabrainFileData("games");
        return $file->get($level);
    }

    public function buildGame(Level $level, Player $blue, Player $red, int $ptsToWin = 5){
        $file = Atlas::getHikabrainFileData("games");
        $file2 = Atlas::getHikabrainFileData("gamesPlaSco");
        $file3 = Atlas::getHikabrainFileData("gamesItems");

        $gameId = mt_rand(999,10000);

        $array = [
            "gameId" => $gameId,
            "bluePlayer" => $blue->getName(),
            "redPlayer" => $red->getName(),
            "bluePts" => 0,
            "redPts" => 0,
            "ptsWin" => $ptsToWin,
            "teamWinner" => "none"
        ];

        $array2 = [
            "redKill" => 0,
            "blueKill" => 0,
            "redDeath" => 0,
            "blueDeath" => 0,
            "redSerialKill" => 0,
            "blueSerialKill" => 0,
            "emeraldBlue" => 0,
            "emeraldRed" => 0
        ];

        $array3 = [
            "redItem" => "none",
            "blueItem" => "none",
            "redTime" => 0,
            "blueTime" => 0
        ];

        $file->set($level->getName(),$array);
        $file->save();
        $file2->set($level->getName(),$array2);
        $file2->save();
        $file3->set($level->getName(),$array3);
        $file3->save();
    }

    public function addPoint(Level $level, string $team){
        if(!in_array($level->getName(), self::$worlds)){ return; }

        if($team == "bluePts"){
            $toEdit = [
                "gameId" => self::getGame()->getGameId($level),
                "bluePlayer" => Team::getTeam()->getPlayerBlue($level),
                "redPlayer" => Team::getTeam()->getPlayerRed($level),
                "bluePts" => $this->getFile($level->getName())[$team] + 1,
                "redPts" => self::getGame()->getPoint($level,"redPts"),
                "ptsWin" =>  self::getGame()->getWinPoints($level),
                "teamWinner" => "none",
            ];
        }else{
            $toEdit = [
                "gameId" => self::getGame()->getGameId($level),
                "bluePlayer" => Team::getTeam()->getPlayerBlue($level),
                "redPlayer" => Team::getTeam()->getPlayerRed($level),
                "bluePts" => self::getGame()->getPoint($level,"bluePts"),
                "redPts" => $this->getFile($level->getName())[$team] + 1,
                "ptsWin" =>  self::getGame()->getWinPoints($level),
                "teamWinner" => "none"
            ];
        }

        $file = Atlas::getHikabrainFileData("games");
        $file->set($level->getName(),$toEdit);
        $file->save();

        self::getGame()->resetMap($level);
    }

    public function getPoint(Level $level, string $team){
        return Atlas::getHikabrainFileData("games")->get($level->getName())[$team];
    }

    public function getWinPoints(Level $level){
        return Atlas::getHikabrainFileData("games")->get($level->getName())["ptsWin"];
    }

    public function isWinRed(Level $level){
        $file = Atlas::getHikabrainFileData("games");

        if($file->get($level->getName())["redPts"] == $file->get($level->getName())["ptsWin"]){
            return true;
        }else{
            return false;
        }
    }

    public function isWinBlue(Level $level){
        $file = Atlas::getHikabrainFileData("games");

        if($file->get($level->getName())["bluePts"] == $file->get($level->getName())["ptsWin"]){
            return true;
        }else{
            return false;
        }
    }

    public function resetMap(Level $level)
    {
        for ($y = 64; $y < 80; $y++) {
            for ($x = 249; $x < 263; $x++) {
                for ($z = 240; $z < 273; $z++) {
                    $b = Server::getInstance()->getLevelByName($level->getName())->getBlockAt($x, $y, $z);
                    if($b->getId() == 24 && $b->getDamage() == 0){
                        Server::getInstance()->getLevelByName($level->getName())->setBlock(new Vector3($x, $y, $z), Block::get(Block::AIR));
                    }
                }
            }
        }
    }

    public function deleteGame(string $level){
        $file = Atlas::getHikabrainFileData("games");
        $file->remove($level);
        $file->save();

        $fileScores = Atlas::getHikabrainFileData("gamesPlaSco");
        $fileScores->remove($level);
        $fileScores->save();

        $fileScores = Atlas::getHikabrainFileData("gamesItems");
        $fileScores->remove($level);
        $fileScores->save();

        $fileWainting = Atlas::getHikabrainFileData("WFile");
        $array = [
            "bluePlayer" => "none",
            "redPlayer" => "none"
        ];

        $fileWainting->set($level, $array);
        $fileWainting->save();
    }

    public function getGameId(Level $level){
        $file = Atlas::getHikabrainFileData("games");
        return $file->get($level->getName())["gameId"];
    }

    public function canPartyJoin(Level $level){
        if(count($level->getPlayers()) == 2){
            return false;
        }else{
            return true;
        }
    }
}