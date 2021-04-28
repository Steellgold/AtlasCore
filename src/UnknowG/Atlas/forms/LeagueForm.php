<?php

namespace UnknowG\Atlas\forms;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use UnknowG\Atlas\api\LeaguesAPI;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;

class LeagueForm extends SimpleForm
{
    public static function open(Player $p)
    {
        {
            $form = new SimpleForm
            (
                function (Player $p, $data) {
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

            $pts = LeaguesAPI::getPoints($p);
            $l = LeaguesAPI::getLeague($p);
            $nl = LeaguesAPI::getNextLeague($p);
            $mpts = LeaguesAPI::getMissingPoints($p,LeaguesAPI::getPoints($p));

            if(LeaguesAPI::getLeague($p) == "Challenger"){
                $max = "§c" . Texts::getText(SQLData::getLang($p),"Vous avez atteint le sommet de votre magnifique palmarès, attendez votre récompense","You've reached the top of your magnificent list of achievements, await your reward.");
            }else{
                $max = "§r§7" . Texts::getText(SQLData::getLang($p),"Il vous manque §3{$mpts} §fpoints pour passer à la ligue §3{$nl}§f.\n","You're missing §3{$mpts} §f points to move on to the league §3{$nl}§f.\n");
            }

            $actu = Texts::getText(SQLData::getLang($p),"Vous avez actuellement §3{$pts} §fpoints de ligue.","You currently have §3{$pts} §fleague points.");
            $kill = Texts::getText(SQLData::getLang($p),"Pour gagner des points de ligues vous devez tuer des adversaires.","To win league points you have to kill opponents.");
            $death = Texts::getText(SQLData::getLang($p),"Chaque mort vous fera perdre §l1 §r§7point à partir de la ligue en §lGold.","Each death will make you lose §l1 §r§7point from the league in §lGold.");

            $form->setTitle("§lLigue $l");
            $form->setContent("§7$actu\n\n§7$kill\n\n§7$death\n\n$max");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Quitter","Leave"));
            $p->sendForm($form);
        }
    }
}