<?php

namespace UnknowG\Atlas\forms;

use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\CoinsAPI;
use UnknowG\Atlas\api\LeaguesAPI;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;

class CoinsForm extends SimpleForm
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
                                self::delCoins($p);
                                break;
                                break;
                        }
                    }
                }
            );

            $l = LeaguesAPI::getLeague($p);
            $lc = LeaguesAPI::getRewardByPoints($p);
            $c = SQLData::getData($p,"playerCoinsCount");

            $form->setTitle("§lCoins ");
            $actu = Texts::getText(SQLData::getLang($p),"§7Vous avez actuellement §3$c"."","§7You currently have §3$c"."");
            $shop = Texts::getText(SQLData::getLang($p),"§7Vous pouvez les utilisées dans la boutique de cosmétiques","§7You can use them in the cosmetics store");
            $saison = Texts::getText(SQLData::getLang($p),"§7Avec votre grade, en fin de saison vous récupérerez §3$lc"."","§7With your rank, at the end of the season you will win §3$lc"."");
            $form->setContent("$actu\n\n$shop\n\n$saison");
            $form->addButton(Texts::getText(SQLData::getLang($p),"Offir des coins","Gift coins"));
            $form->addButton(Texts::getText(SQLData::getLang($p),"Quitter","Leave"));
            $p->sendForm($form);
        }
    }

    public static function delCoins($player)
    {
        $form = new CustomForm(function (Player $player, array $data = null) {
            if (isset($data[0]) && isset($data[1])) {
                $pseudo = Server::getInstance()->getPlayer($data[0]);

                if($pseudo instanceof Player){
                    if(is_numeric($data[1])){
                        if(CoinsAPI::getCoins($player) >= $data[1]) {
                            CoinsAPI::delCoins($player, $data[1]);
                            CoinsAPI::addCoins($pseudo, $data[1]);
                            $pseudo->sendMessage(Texts::getText(SQLData::getLang($player),Texts::$prefix . "§3{$player->getName()} §7vous a envoyé §3{$data[1]}",Texts::$prefix . "§3{$player->getName()} §7 sent you §3{$data[1]}"));
                            $player->sendMessage(Texts::getText(SQLData::getLang($player),Texts::$prefix . "Vous avez envoyé(e) §3{$data[1]} §7à §3{$pseudo->getName()}",Texts::$prefix . "You sent §3{$data[1]} §7to §3{$pseudo->getName()}§7."));
                        }else{
                            $player->sendMessage(Texts::getText(SQLData::getLang($player),Texts::$prefix . "Vous n'avez pas assez de Coins",Texts::$prefix . "You don't have enough coins"));
                        }
                    }else{
                        $player->sendMessage(Texts::getText(SQLData::getLang($player),Texts::$prefix . "Merci de communiquer des nombres",Texts::$prefix . "Please provide numbers"));
                    }
                }else{
                    $player->sendMessage(Texts::getText(SQLData::getLang($player),Texts::$prefix . "Cette personne n'est pas connecté(e)",Texts::$prefix . "This person is not logged in"));
                }
            } else {
                $player->sendMessage(Texts::getText(SQLData::getLang($player),Texts::$prefix . "Merci de communiquer des informations via cette interface",Texts::$prefix . "Please communicate information via this interface"));
            }
        });

        $form->setTitle("§lCoins");
        $form->addInput(Texts::getText(SQLData::getLang($player),"Pseudo du Joueur","Player Name"));
        $form->addInput(Texts::getText(SQLData::getLang($player),"Montant des ","Amount of "));
        $form->sendToPlayer($player);
    }
}