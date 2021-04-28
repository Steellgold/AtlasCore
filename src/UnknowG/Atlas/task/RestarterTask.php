<?php

namespace UnknowG\Atlas\task;

use DiscordWebhookAPI\Message;
use DiscordWebhookAPI\Webhook;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use UnknowG\Atlas\utils\texts\Texts;

class RestarterTask extends Task {

    /** @var int $seconds */
    private $seconds = 0;

    public function onRun(int $tick) : void{
        $this->seconds++;
        $time = intval(3600);
        $restartTime = $time - $this->seconds;
        switch($restartTime){
            case 100:
                Server::getInstance()->broadcastTitle(Texts::$prefix,"§7Server restart in 2 minutes");
                return;
            case 50:
                Server::getInstance()->broadcastTitle(Texts::$prefix,"§7Server restart in 1 minutes");
                return;
            case 25:
                Server::getInstance()->broadcastTitle(Texts::$prefix,"Server restart in §220 secondes");
                return;
            case 10:
                Server::getInstance()->broadcastTitle(Texts::$prefix,"§7Server restart in §a10 §7secondes");
                return;
            case 5:
                Server::getInstance()->broadcastTitle(Texts::$prefix,"§7Server restart in §65 §7secondes");
                return;
            case 4:
                Server::getInstance()->broadcastTitle(Texts::$prefix,"§7Server restart in §g4 §7secondes");
                return;
            case 3:
                Server::getInstance()->broadcastTitle(Texts::$prefix,"§7Server restart in §c3 §7secondes");
                return;
            case 2:
                Server::getInstance()->broadcastTitle(Texts::$prefix,"§7Server restart in §42 §7secondes");
                return;
            case 1:
                Server::getInstance()->broadcastTitle(Texts::$prefix,"§7Server restart in §4§l1 §7secondes");
                return;
            case 0:
                $w = new Webhook("https://canary.discordapp.com/api/webhooks/724758348809109545/FUoANTD1xcOMCsYnGU1KCy487iZJKsiirOYSMU7gJWGZ5xwjeMgwBvhtEjHgDEpKipDU");
                $msg = new Message();

                $msg->setContent("Le serv a redem a " . date("H:i:s"));
                $w->send($msg);
                Server::getInstance()->shutdown();
                return;
        }
    }
}
