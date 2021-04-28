<?php

namespace UnknowG\Atlas\utils\texts;

use DiscordWebhookAPI\Embed;
use DiscordWebhookAPI\Message;
use DiscordWebhookAPI\Webhook;
use pocketmine\Player;
use UnknowG\Atlas\data\sql\SQLData;

class Texts
{
    public static $prefix = "§l§7[§r§3Atlas§r§l§7] §r§7";
    public static $prefixShop = "§l§7[§r§5Store§r§l§7] §r§7";
    public static $prefixVote = "§l§7[§r§5Vote§r§l§7] §r§7";
    public static $prefixPets = "§l§7[§r§3Pets§r§l§7] §r§7";
    public static $prefixPass = "§l§7[§r§3ALP§r§l§7] §r§7";
    public static $prefixParticles = "§l§7[§r§3Particles§r§l§7] §r§7";
    public static $prefixSeason = "§l§7[§r§3Season§r§l§7] §r§7";
    public static $prefixYtb = "§l§7[§r§cYouTube§r§l§7] §r§7";
    public static $prefixBoost = "§l§7[§r§dNitro Boost§r§l§7] §r§7";
    public static $discord = "§3discord.gg/XVcEvqf";

    public static $prefixUpdate = "§l§7[§r§3§lUpdate§r§l§7] §r§7";
    public static $prefixBoosts = "§l§7[§r§3§lBoosts§r§l§7] §r§7";
    public static $prefixNew = "§l§7[§r§3§lNew§r§l§7] §r§7";
    public static $prefixBeta = "§l§7[§r§3§lBeta§r§l§7] §r§7";
    public static $prefixBox = "§l§7[§r§3§lBox§r§l§7] §r§7";
    public static $prefixQuest = "§l§7[§r§3§lQuest§l§f§7] §r§7";

    public static $prefixNPC = "§l§7[§r§3Atlas§r§l§7]";
    public static $prefixPassNPC = "§l§7[§r§3ALP§r§l§7]";
    public static $prefixUpdateNPC = "§l§7[§r§3§lUPDATE§r§l§7]";
    public static $prefixNewNPC = "§l§7[§r§3§lNEW§r§l§7]";
    public static $prefixBetaNPC = "§l§7[§r§3§lBÊTA§r§l§7]";
    public static $prefixQuestNPC = "§l§7[§r§3§lQUEST§r§l§7]";
    public static $prefixBoostNPC = "§l§7[§r§3§lBOOSTS§r§l§7]";

    public static $prefixBoxNPC = "§l§7[§r§3§lBOX§r§l§7]";
    public static $prefixPrenium = "§l§7[§r§gPremium§r§l§7] §7";

    public static $prefixPreniumTitle = "§l§7[§r§gPremium§r§l§7]";
    public static $prefixStaffTitle = "§l§7[§r§6Staff§r§l§7]";
    public static $prefixPassTitle = "§l§7[§r§3ALP§r§l§7]";
    public static $prefixStaff = "§l§7[§r§6Staff§r§l§7] §r§7";

    public static $prefixHikaNPC = "§l§7[§r§bHIKABRAIN§r§l§7]";

    public static $prefixPreniumNPC = "§l§7[§r§gPremium§r§l§7] §7";

    public static $fondatorRank = "§3Owner §r";
    public static $adminRank = "§bAdmin §r";
    public static $staffRank = "§cStaff §r";
    public static $supportRank = "§4Support §r";
    public static $preniumRank = "§gPremium §r";
    public static $ytbRank = "§cYoutuber §r";
    public static $playerRank = "§7Player §r";

    public static $titleForm = "§7§l- §r§3Atlas §r§7§l-";

    public static function getText(string $lang, string $frMsg, string $enMsg)
    {
        if ($lang == "fr") {
            return $frMsg;
        } elseif ($lang == "en") {
            return $enMsg;
        } else {
            return "NOT FOUND";
        }
    }

    public static function returnNotPermission(Player$player){
        return self::getText(SQLData::getLang($player),self::$prefix . "Vous n'avez aucune permission sufisante pour utlisez ceci",self::$prefix . "You have no permission to use this.");
    }

    public static function sendMessage(Player $player, string $prefix, string $frMessage, string $enMessage){
        $lang = SQLData::getLang($player);
        if($lang == "fr"){
            $player->sendMessage($prefix . $frMessage);
        }else{
            $player->sendMessage($prefix . $enMessage);
        }
    }

    public static function sendTip(Player $player,string $frMessage, string $enMessage){
        $lang = SQLData::getLang($player);
        if($lang == "fr"){
            $player->sendTip($frMessage);
        }else{
            $player->sendTip($enMessage);
        }
    }

    public static function sendDiscord2players(Player $player, string $sender, string $message){
        $webhook = new Webhook("https://canary.discordapp.com/api/webhooks/718572072548171929/4cNH2zekegu_ACedFVDhFVQg3LoVVysBVPTXhV4MxuEDDdPLzEqcwZMIiERysK28dJi1");
        $msg = new Message();
        $embed = new Embed();

        $embed->setTitle($player->getName() . " -> " . $sender);
        $embed->setDescription("Contenu: " . $message);
        $msg->addEmbed($embed);
        $webhook->send($msg);
    }
}