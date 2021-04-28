<?php

namespace UnknowG\Atlas\commands\basic\headPrice;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\CoinsAPI;
use UnknowG\Atlas\api\LeaguesAPI;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\forms\CoinsForm;
use UnknowG\Atlas\utils\texts\Texts;
use UnknowG\Atlas\utils\texts\Unicodes;

class HeadPriceCommand extends Command{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if($player instanceof Player){
            if(isset($args[0]) && isset($args[1])){
                $pseudo = Server::getInstance()->getPlayer($args[0]);
                if($pseudo instanceof Player){
                    if(CoinsAPI::getCoins($player) >= $args[1]){
                        if(SQLData::getData($pseudo,"asHeadPrice") == "false"){
                            SQLData::setData($pseudo,"players","headPrice",$args[1]);
                            SQLData::setData($pseudo,"players","headPriceSeller",$player->getName());
                            SQLData::setData($pseudo,"players","asHeadPrice","true");

                            /** Edit player */
                            if(SQLData::getData($pseudo,"isNick") == 1){
                                if(SQLData::getData($pseudo,"asHeadPrice") == "true"){
                                    $uni = Unicodes::$coin;
                                    $price = SQLData::getData($pseudo,"headPrice");
                                    $pseudo->setNameTag("§2§lHead Price: $price". $uni."\n§r§a" . "Unranked" . " §f" . SQLData::getData($pseudo,"nickName"));
                                }else{
                                    $pseudo->setNameTag("§r§a" . "Unranked" . " §f" . SQLData::getData($pseudo,"nickName"));
                                }
                            }else{
                                if(SQLData::getData($pseudo,"asHeadPrice")){
                                    $price = SQLData::getData($pseudo,"headPrice");
                                    $pseudo->setNameTag("§2§lHead Price: $price\n§r§a" . LeaguesAPI::getLeague($pseudo) . " §f" . $pseudo->getName());
                                }else {
                                    $pseudo->setNameTag("§a" . LeaguesAPI::getLeague($pseudo) . " §f" . $pseudo->getName());
                                }
                            }
                            /** Edit player */

                            $uni = Unicodes::$coin;
                            Server::getInstance()->broadcastMessage(Texts::$prefix . "The head of §3{$pseudo->getName()} §7is put at a price for a value of §3{$args[1]}{$uni}");
                        }else{
                            Texts::sendMessage($player,Texts::$prefix,"Désolé, mais la personne a déjà un prix sur la tête","I'm sorry, but the person already has a price on their head");
                        }
                    }else{
                        Texts::sendMessage($player,Texts::$prefix,"Vous n'avez pas assez de coins","You don't have enough coins");
                    }
                }else{
                    Texts::sendMessage($player,Texts::$prefix,"Désolé, mais la personne n'est actuellement pas connecté(e)","Sorry, but the person is currently not logged in");
                }
            }
        }
    }
}