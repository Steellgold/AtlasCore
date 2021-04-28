<?php

namespace UnknowG\Atlas\forms\box;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use UnknowG\Atlas\api\ApiXP;
use UnknowG\Atlas\api\CoinsAPI;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\forms\CoinsForm;
use UnknowG\Atlas\utils\texts\Texts;
use UnknowG\Atlas\utils\texts\Unicodes;

class BoxForms extends SimpleForm{
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
                                if(SQLData::getData($p,"playerKeyCountsPrenium") == 0){
                                    Texts::sendMessage($p,Texts::$prefixBox,"Vous n'avez pas de clef de coffres §gPremium §7en étant premium vous pouvez en avoir une gratuitement toutes les 24 heures, si vous êtes un joueur vous pouvez en acheter sur la boutique au prix de départ de §30.50e §7sur le lien suivant: \n§l§7» §r§7§3shop.atlas-mc.fr","You don't have a safe deposit box key §gPremium §7by being premium you can get one for free every 24 hours, if you are a player you can buy one on the shop at the starting price of §30.50e §7 on the following link: \n§3shop.atlas-mc.fr");
                                    return true;
                                }

                                $coins = Unicodes::$coin;

                                $rand = mt_rand(1,6);
                                switch ($rand) {
                                    case 1:
                                        Texts::sendMessage($p, Texts::$prefixBox, "Vous avez gagner §3100 $coins", "You've earned §3100 $coins");
                                        CoinsAPI::addCoins($p, 100);
                                        break;
                                    case 2:
                                        Texts::sendMessage($p, Texts::$prefixBox, "Vous avez gagner §350 $coins", "You've earned §350 $coins");
                                        CoinsAPI::addCoins($p, 50);
                                        break;
                                    case 3:
                                        if (SQLData::getData($p, "asALP") == 1) {
                                            Texts::sendMessage($p, Texts::$prefixBox, "Vous avez gagner §31000 XP §7pour votre ALP", "You have earned §31000 XP §7for your ALP");
                                            ApiXP::addXp($p, 1000);
                                        } else {
                                            Texts::sendMessage($p, Texts::$prefixBox, "Comme vous n'avez pas l'ALP, nous vous donnons §3100 $coins §7en échange des 1000 XP", "As you don't have the ALP we will give you 100 corners in exchange for the 1000 X");
                                            CoinsAPI::addCoins($p, 100);
                                        }
                                        break;
                                    case 4:
                                        if (SQLData::getData($p, "asALP") == 1) {
                                            Texts::sendMessage($p, Texts::$prefixBox, "Vous avez gagner §3500 XP §7pour votre ALP", "You have earned §3500 XP §7for your ALP");
                                            ApiXP::addXp($p, 500);
                                        } else {
                                            Texts::sendMessage($p, Texts::$prefixBox, "Comme vous n'avez pas l'ALP, nous vous donnons §3100 $coins §7en échange des 1000 XP", "As you don't have the ALP we will give you 100 corners in exchange for the 1000 X");
                                            CoinsAPI::addCoins($p, 50);
                                        }
                                        break;
                                    case 5:
                                        $kV = SQLData::getData($p, "playerKeyCountsVote");
                                        $total = $kV + 2;
                                        SQLData::setData($p, "players", "playerKeyCountsVote", $total);
                                        Texts::sendMessage($p, Texts::$prefixBox, "Vous avez gagner §32 clef§7 de box de §3type §3Vote", "You have won §32 box keys §7of §3type §3Vote");
                                        break;
                                    case 6:
                                        $rand2 = mt_rand(1, 3);
                                        if ($rand2 == 3) {
                                            $rand3 = mt_rand(1, 3);
                                            if ($rand3 == 2) {
                                                Server::getInstance()->broadcastMessage(Texts::$prefixBox . "§3{$p->getName()} §7just received §33000 XP §7in the premium box! §l§7(§3ULTRA RARE§7)");
                                                ApiXP::addXp($p, 3000);
                                            }else{
                                                Texts::sendMessage($p, Texts::$prefixBox, "Vous avez reçu §3100 $coins", "You received §3100 $coins");
                                                CoinsAPI::addCoins($p, 100);
                                            }
                                        }else{
                                            Texts::sendMessage($p, Texts::$prefixBox, "Vous avez reçu §3100 $coins", "You received §3100 $coins");
                                            CoinsAPI::addCoins($p, 100);
                                        }
                                }

                                $kV = SQLData::getData($p, "playerKeyCountsPrenium");
                                $total = $kV - 1;
                                SQLData::setData($p, "players", "playerKeyCountsPrenium", $total);
                                break;
                            case 1:
                                if(SQLData::getData($p,"playerKeyCountsVote") == 0){
                                    Texts::sendMessage($p,Texts::$prefixBox,"Vous n'avez pas de clef de coffres §3Vote §7vous pouvez en obtenir gratuitement en votant sur le site de vote du serveur via le lien ci dessous:\n§l§7» §r§7§3shop.atlas-mc.fr","You don't have a vault key §3Vote §7you can get one for free by voting on the server's voting site via the link below: \n§3shop.atlas-mc.fr");
                                    return true;
                                }

                                $coins = Unicodes::$coin;

                                $rand = mt_rand(1,5);
                                switch ($rand){
                                    case 1:
                                        Texts::sendMessage($p,Texts::$prefixBox,"Vous avez gagner §350 $coins","You've earned §350 $coins");
                                        CoinsAPI::addCoins($p,100);
                                        break;
                                    case 2:
                                        Texts::sendMessage($p,Texts::$prefixBox,"Vous avez gagner §325 $coins","You've earned §325 $coins");
                                        CoinsAPI::addCoins($p,50);
                                        break;
                                    case 3:
                                        if(SQLData::getData($p,"asALP") == 1){
                                            Texts::sendMessage($p,Texts::$prefixBox,"Vous avez gagner §3500 XP §7pour votre ALP","You have earned §3500 XP §7for your ALP");
                                            ApiXP::addXp($p,500);
                                        }else{
                                            Texts::sendMessage($p,Texts::$prefixBox,"Comme vous n'avez pas l'ALP, nous vous donnons §350 $coins §7en échange des 500 XP","As you don't have the ALP we will give you 50 corners in exchange for the 500 XP");
                                            CoinsAPI::addCoins($p,50);
                                        }
                                        break;
                                    case 4:
                                        if(SQLData::getData($p,"asALP") == 1){
                                            Texts::sendMessage($p,Texts::$prefixBox,"Vous avez gagner §3200 XP §7pour votre ALP","You have earned §3200 XP §7for your ALP");
                                            ApiXP::addXp($p,200);
                                        }else{
                                            Texts::sendMessage($p,Texts::$prefixBox,"Comme vous n'avez pas l'ALP, nous vous donnons §3100 $coins §7en échange des 200 XP","As you don't have the ALP we will give you 20 corners in exchange for the 200 XP");
                                            CoinsAPI::addCoins($p,20);
                                        }
                                        break;
                                    case 5:
                                        $rand2 = mt_rand(1, 4   );
                                        if ($rand2 == 6) {
                                            $rand3 = mt_rand(1, 4);
                                            if ($rand3 == 6) {
                                                Server::getInstance()->broadcastMessage(Texts::$prefixBox . "§3{$p->getName()} §7just received §32500 XP §7in the premium box! §l§7(§3ULTRA RARE§7)");
                                                ApiXP::addXp($p, 2500);
                                            }else{
                                                Texts::sendMessage($p, Texts::$prefixBox, "Vous avez reçu §3100 $coins", "You received §3100 $coins");
                                                CoinsAPI::addCoins($p, 100);
                                            }
                                        }else{
                                            Texts::sendMessage($p, Texts::$prefixBox, "Vous avez reçu §3100 $coins", "You received §3100 $coins");
                                            CoinsAPI::addCoins($p, 100);
                                        }
                                        break;
                                }

                                $kV = SQLData::getData($p, "playerKeyCountsVote");
                                $total = $kV - 1;
                                SQLData::setData($p, "players", "playerKeyCountsVote", $total);

                                break;
                                break;
                        }
                    }
                }
            );

            $uni = Unicodes::$coin;
            $kP = SQLData::getData($p,"playerKeyCountsPrenium");
            $kV = SQLData::getData($p,"playerKeyCountsVote");
            $p1 = "§l§7» §r§7". Texts::getText(SQLData::getLang($p),"Bienvenue dans l'interface des §3coffres de récompenses §7vous pouvez y en acheter ou en ouvrir si vous en possédé la clef qui permet de la débloqué","Welcome to the §3Reward chest §7interface where you can buy rewards or open them if you have the key to unlock them.");
            $p2 = "§l§7» §r§7". Texts::getText(SQLData::getLang($p),"Vous avez un total de §3$kP §7clef premiums et §3$kV §7clef de vote cliquez sur l'un des deux boutons pour ouvrir le §3coffre de récompense §7du même type de votre clef","You have a total of §3$kP §7keys premiums and §3$kV §7keys voting, click on one of the two buttons to open the §3reward chest §7of the same type of your key");

            $p3 = "§l§7» §r§7". Texts::getText(SQLData::getLang($p),"§7Dans la box §lPremium§r§7 se trouve: ","§7In the box §lPremium§r§7 is :");
            $pr1 = "§l§3> §r§7". Texts::getText(SQLData::getLang($p),"§7100 $uni","§7100 $uni");
            $pr2 = "§l§3> §r§7". Texts::getText(SQLData::getLang($p),"§750 $uni","§750 $uni");
            $pr3 = "§l§3> §r§7". Texts::getText(SQLData::getLang($p),"§71000 XP pour le ALP","§71000 XP for the ALP");
            $pr4 = "§l§3> §r§7". Texts::getText(SQLData::getLang($p),"§7500 XP pour le ALP","§7500 XP for the ALP");
            $pr5 = "§l§3> §r§7". Texts::getText(SQLData::getLang($p),"§72 clef pour lest coffres de récompense de type §lVote","§72 keys for the §lvote §r§7chest reward");
            $pr6 = "§l§3> §r§7". Texts::getText(SQLData::getLang($p),"§3§lULTRA RARE: §r§73000 XP for the ALP","§3§lULTRA RARE: §r§73000 XP for the ALP");

            $p4 = "§l§7» §r§7". Texts::getText(SQLData::getLang($p),"§7Dans la box §lVote§r§7 se trouve: ","§7In the box §lVote§r§7 is :");
            $v1 = "§l§3> §r§7". Texts::getText(SQLData::getLang($p),"§750 $uni","§750 $uni");
            $v2 = "§l§3> §r§7". Texts::getText(SQLData::getLang($p),"§725 $uni","§725 $uni");
            $v3 = "§l§3> §r§7". Texts::getText(SQLData::getLang($p),"§7500 XP pour le ALP","§7500 XP for the ALP");
            $v4 = "§l§3> §r§7". Texts::getText(SQLData::getLang($p),"§7200 XP pour le ALP","§7200 XP for the ALP");
            $v5 = "§l§3> §r§7". Texts::getText(SQLData::getLang($p),"§3§lULTRA RARE: §r§72500 XP for the ALP","§3§lULTRA RARE: §r§72500 XP for the ALP");


            $achat = "§l§3INFO §7» §r§7". Texts::getText(SQLData::getLang($p),"Vous pouvez acheter des clef de box §lpremium §7en étant joueur §lou §r§7premium, directement sur la boutique §3shop.atlas-mc.fr","You can buy §lpremium §7box keys as a §lpremium §7player or §r§7premium, directly from the shop §3shop.atlas-mc.fr");
            $vote = "§l§3INFO §7» §r§7". Texts::getText(SQLData::getLang($p),"Vous pouvez voter et récuperer une clef de vote sur §3vote.atlas-mc.fr §7retournez en jeu et executer la commande §3/vote","You can vote and retrieve a voting key on §3vote.atlas-mc.fr §7go back in the game and execute the command §3/vote");
            $text = $p1."\n\n".$p2."\n".$p4."\n\n".$v1."\n".$v2."\n".$v3."\n".$v4."\n".$v5."\n\n".$p3."\n".$pr1."\n".$pr2."\n".$pr3."\n".$pr4."\n".$pr5."\n".$pr6."\n\n".$achat."\n".$vote;

            $form->setTitle("§l- Box -");
            $form->setContent($text);
            $form->addButton(Texts::getText(SQLData::getLang($p),"Ouvrir un Coffre §lPremium\n§r$kP clefs","Open a §lPremium§r Chest\n§r$kP keys"));
            $form->addButton(Texts::getText(SQLData::getLang($p),"Ouvrir un Coffre §lVote\n§r$kV clefs","Open a §lVote§r Chest\n§r$kV keys"));

            $p->sendForm($form);
        }
    }
}