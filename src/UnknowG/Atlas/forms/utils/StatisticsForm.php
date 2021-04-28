<?php

namespace UnknowG\Atlas\forms\utils;

use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\CoinsAPI;
use UnknowG\Atlas\api\LeaguesAPI;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;

class StatisticsForm extends SimpleForm
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
            $kills = SQLData::getData($p,"playerKillCount");
            $deaths = SQLData::getData($p,"playerDeathCount");

            if(!$kills == 0){
                if(!$deaths == 0){
                    $ratio = $kills / $deaths;
                }else{
                    $ratio = "no";
                }
            }else{
                $ratio = "no";
            }

            $kil = Texts::getText(SQLData::getLang($p),"§fVous avez §e$kills §fkills","§fYou've §e$kills §fkills") . "\n\n";
            $dea = Texts::getText(SQLData::getLang($p),"§fVous avez §e$ratio §fde ratio kills par morts","§fYou have §e$ratio §fde kill death ratio") . "\n\n";
            $rat = Texts::getText(SQLData::getLang($p),"§fVous avez §e$deaths §fmorts","§fYou've §e$deaths §fdeaths") . "\n\n";

            $form->setTitle(Texts::getText(SQLData::getLang($p),"§lStatistiques","§lStatistics"));
            $form->setContent($kil.$dea.$rat."\n\n");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Quitter","Leave"));
            $p->sendForm($form);
        }
    }
}