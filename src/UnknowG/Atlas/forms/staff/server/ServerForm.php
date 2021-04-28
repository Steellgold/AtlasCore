<?php

namespace UnknowG\Atlas\forms\staff\server;

use DiscordWebhookAPI\Embed;
use DiscordWebhookAPI\Message;
use DiscordWebhookAPI\Webhook;
use jojoe77777\FormAPI\CustomForm;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\data\sql\SQLDataServer;
use UnknowG\Atlas\utils\texts\Texts;

class ServerForm extends CustomForm {
    public static function open($player)
    {
        $form = new CustomForm(function (Player $player, array $data = null) {
            if (isset($data[0]) && isset($data[1]) && isset($data[2]) && isset($data[3])) {
                SQLDataServer::setKB($data[0]);
                SQLDataServer::setArrowDamage($data[1]);
                SQLDataServer::setWhitelist($data[2]);
                SQLDataServer::setWhitelistReason($data[3]);

                if($data[2] > 0){
                    self::sendWhitelist1($data[3]);
                }else{
                    self::sendWhitelist0();
                }

                SQLDataServer::setChat($data[4]);
                $player->sendMessage("Modifications sauvegardées !");
            } else {
                $player->sendMessage(Texts::$prefix . "Merci de communiquer des informations via cette interface");
            }
        });

        $form->setTitle("§lStaff");
        $form->addInput("Modification du KB","",SQL::getServerData("kb"));
        $form->addInput("Modification des dégats de l'Arc","",SQL::getServerData("shootArrowDamage"));
        $form->addInput("Whitelit","",SQL::getServerData("whitelist"));
        $form->addInput("Whitelist Reason","",SQL::getServerData("resWhitelist"));
        $form->addInput("Chat activé","",SQL::getServerData("chat"));
        $form->sendToPlayer($player);
    }

    public static function sendWhitelist1(string $rs){
        $web = new Webhook("https://canary.discordapp.com/api/webhooks/713014324930543627/NMLbZVgEmUKVOZ4VPiuqOSpFkke4db1zjNhBMFGIJ8g5ric_i4GyHlteZZrHOFaU4auT");
        $embed = new Embed();
        $msg = new Message();

        $embed->setTitle("[:lock:] Serveur sous Whitelist");
        $embed->setDescription("Le serveur est passé en whitelist.. \npour la raison suivante : *".$rs."*");
        $embed->setFooter("rv-shock.net - 19133");
        $msg->addEmbed($embed);
        $web->send($msg);
    }

    public static function sendWhitelist0(){
        $web = new Webhook("https://canary.discordapp.com/api/webhooks/713014324930543627/NMLbZVgEmUKVOZ4VPiuqOSpFkke4db1zjNhBMFGIJ8g5ric_i4GyHlteZZrHOFaU4auT");
        $embed = new Embed();
        $msg = new Message();
        $msg2 = new Message();

        $msg2->setContent("@here Serveur ré-ouvert !");
        $embed->setTitle("[:unlock:] Serveur ré-ouvert");
        $embed->setDescription("Le serveur est de nouveau accessible, bon jeu à tous");
        $embed->setFooter("rv-shock.net - 19133");
        $msg->addEmbed($embed);

        $web->send($msg2);
        $web->send($msg);
    }
}