<?php

namespace UnknowG\Atlas\hikabrain\forms;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\hikabrain\manager\Game;
use UnknowG\Atlas\hikabrain\manager\Team;
use UnknowG\Atlas\utils\texts\Texts;
use UnknowG\Atlas\utils\texts\Unicodes;

class EndGameForm extends SimpleForm{
    public static function openWin(Player $p, string $levelName, int $xp, int $coins, int $maxPts, int $minPts)
    {
        $form = new SimpleForm
        (
            function (Player $p, $data) use ($levelName, $xp, $coins, $maxPts, $minPts) {
                if ($data === null) {
                    Game::getGame()->deleteGame($levelName);
                } else {
                    switch ($data) {
                        case 0:
                            Game::getGame()->deleteGame($levelName);
                            break;
                            break;
                    }
                }
            }
        );

        $tw = Team::getTeam()->getWinTeam($levelName);
        if($tw == "red"){
           $team = "§cRed§7";
        }else{
            $team = "§3Blue§7";
        }

        $t1 = "§7§l» §r§7" . Texts::getText(SQLData::getLang($p),"Fin de la partie l'équipe $team à gagner !","Game ended, team $team win!");
        $t2 = "§7§l» §r§7" . Texts::getText(SQLData::getLang($p),"Vous avez gagner §3$xp xp §7pour votre ALP ansi que §3$coins §7coins","You have earned §3$xp xp §7for your ALP as well as §3$coins §7coins");

        $form->setTitle("§l- Hikabrain §0[§r§7$maxPts" . "§0/§7$minPts"."§0§l]");
        $form->setContent($t1 . "\n\n" . $t2 . "\n\n\n\n\n\n\n");
        $form->addButton("OK");
        $p->sendForm($form);
    }

    public static function openLose(Player $p, string $levelName, int $xp, int $coins, int $maxPts, int $minPts)
    {
        $form = new SimpleForm
        (
            function (Player $p, $data) use ($levelName, $xp, $coins, $maxPts, $minPts) {
                if ($data === null) {
                } else {
                    switch ($data) {
                        case 0:

                            break;
                            break;
                    }
                }
            }
        );

        $tw = Team::getTeam()->getWinTeam($levelName);
        if($tw == "red"){
            $team = "§cRed§7";
        }else{
            $team = "§3Blue§7";
        }

        $t1 = "§7§l» §r§7" . Texts::getText(SQLData::getLang($p),"Fin de la partie l'équipe $team à gagner !","Game ended, team $team win!");
        $t2 = "§7§l» §r§7" . Texts::getText(SQLData::getLang($p),"Vous avez gagner §3$xp xp §7pour votre ALP ansi que §3$coins §7coins","You have earned §3$xp xp §7for your ALP as well as §3$coins §7coins");

        $form->setTitle("§l- Hikabrain §0[§r§7$maxPts" . "§0/§7$minPts"."§0§l]");
        $form->setContent($t1 . "\n\n" . $t2 . "\n\n\n\n\n\n\n");
        $form->addButton("OK");
        $p->sendForm($form);
    }
}