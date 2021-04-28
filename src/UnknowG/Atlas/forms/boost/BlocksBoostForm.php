<?php

namespace UnknowG\Atlas\forms\boost;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\item\Item;
use pocketmine\Player;
use UnknowG\Atlas\api\CoinsAPI;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;
use UnknowG\Atlas\utils\texts\Unicodes;

class BlocksBoostForm extends SimpleForm
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
                                if(self::delP($p,64)){
                                    if(RankAPI::isPremium($p)){
                                        $p->getInventory()->addItem(Item::get(41,0,64)->setCustomName($p->getName()));
                                    }else{
                                        $p->getInventory()->addItem(Item::get(236,14,64)->setCustomName($p->getName()));
                                    }
                                    CoinsAPI::delCoins($p,64);
                                }else{
                                    Texts::sendMessage($p,Texts::$prefixBoosts,"Vous n'avez pas assez de  pour vous achetez ces blocs","You don't have enough  to buy yourself these blocks...");
                                }
                                break;
                            case 1:
                                if(self::delP($p,50)){
                                    $p->getInventory()->addItem(Item::get(261,0,1));
                                    $p->getInventory()->addItem(Item::get(262,0,64));
                                    CoinsAPI::delCoins($p,50);
                                }else{
                                    Texts::sendMessage($p,Texts::$prefixBoosts,"Vous n'avez pas assez de  pour vous achetez ces blocs","You don't have enough  to buy yourself these blocks...");
                                }
                                break;
                                break;
                        }
                    }
                }
            );

            $uni = Unicodes::$coin;

            $form->setTitle("§lBlock");
            $form->setContent("§l§7» §r§7" . Texts::getText(SQLData::getLang($p),"§7Une fois posé, il disparaîtra au bout de §310 secondes.","§7Once placed, it will disappear after §310 seconds."));
            $form->addButton(Texts::getText(SQLData::getLang($p),"Acheter 64 blocs\n64 $uni","Buy 64 blocks\n64 $uni"));
            $form->addButton(Texts::getText(SQLData::getLang($p),"Acheter un Arc\n50 $uni","Buy a Bow\n50 $uni"));
            $p->sendForm($form);
        }
    }

    private static function delP(Player $player, int $ness)
    {
        if (CoinsAPI::getCoins($player) >= $ness) {
            return true;
        } else {
            return false;
        }
    }
}