<?php

namespace UnknowG\Atlas\forms\utils;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\block\Gold;
use pocketmine\Player;
use UnknowG\Atlas\api\CoinsAPI;
use UnknowG\Atlas\api\GoldAPI;
use UnknowG\Atlas\api\LeaguesAPI;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;
use UnknowG\Atlas\utils\texts\Unicodes;

class ResetStatsForm
{
    public static function open(Player $p)
    {
        $form = new SimpleForm
        (
            function (Player $p, $data) {
                if ($data === null) {
                } else {
                    switch ($data) {
                        case 0:
                            SQLData::setLang($p,"en");
                            LeaguesAPI::delPoints($p,LeaguesAPI::getPoints($p));
                            CoinsAPI::delCoins($p,CoinsAPI::getCoins($p));
                            SQLData::setData($p,"players","playerKillCount",0);
                            SQLData::setData($p,"players","playerDeathCount",0);
                            SQLData::setData($p,"players","playerKeyCountsPrenium",0);
                            SQLData::setData($p,"players","playerKeyCountsVote",0);
                            SQLData::setData($p,"players","playerPremiumCoinsCount",0);
                            SQLData::setData($p,"players","playerGoldCount",0);
                            SQLData::setData($p,"players","timeKeyPrenium",0);
                            SQLData::setData($p,"players","showPopus",0);
                            SQLData::setData($p,"players","flyLobby",0);
                            SQLData::setData($p,"players","showRank",0);
                            SQLData::setData($p,"players","lgShow",0);
                            SQLData::setData($p,"players","rulesAccept",0);
                            SQLData::setData($p,"players","isNick",0);
                            SQLData::setData($p,"players","nickName",0);
                            SQLData::setData($p,"players","fakeRole",0);
                            SQLData::setData($p,"players","endTimeSeason",0);
                            SQLData::setData($p,"players","bestSeason",0);
                            SQLData::setData($p,"players","headPrice",0);
                            SQLData::setData($p,"players","headPriceSeller",0);
                            SQLData::setData($p,"players","asHeadPrice",0);

                            $p->close("","§cAll data as been deleted");
                            break;
                            break;
                    }
                }
            }
        );

        $ingot = GoldAPI::getGold($p);
        $uni = Unicodes::$coin;

        $form->setTitle(Texts::getText(SQLData::getLang($p), "§lOuverture d'une poubelle", "§lTrash"));
        $form->setContent(Texts::getText(SQLData::getLang($p),"§7Cette action est irréversible voulez vous vraiment faire ceci?\n§l§7» §r§7Cela supprimera les données suivantes: Points de Ligues, Nombre de morts et de meurtre, vos paramètres, vos clefs §cseul §7le grade, le pseudo et l'ip resteront enregistrées (et ce  qui n'a pas été cité)","§7This action is irreversible do you really want to do this?\n§l§7\" §r§7It will delete the following data: Bets, Capes, Corners, League Points, Number of Deaths and Murders, your settings, your keys, rank, nickname, and IP will saved"));
        $form->addButton(Texts::getText(SQLData::getLang($p), "§lOUI", "§lYES"));
        $p->sendForm($form);
    }
}