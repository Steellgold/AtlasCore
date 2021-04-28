<?php

namespace UnknowG\Atlas\events\player;

use DiscordWebhookAPI\Embed;
use DiscordWebhookAPI\Message;
use DiscordWebhookAPI\Webhook;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;

class CPS implements Listener
{
    private $plugin;

    public function __construct(Atlas $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onDataPacketReceive(DataPacketReceiveEvent $event)
    {
        $player = $event->getPlayer();
        $packet = $event->getPacket();
        if ($packet instanceof InventoryTransactionPacket) {
            $transactionType = $packet->transactionType;
            if ($transactionType === InventoryTransactionPacket::TYPE_USE_ITEM || $transactionType === InventoryTransactionPacket::TYPE_USE_ITEM_ON_ENTITY) {
                $this->plugin->addCPS($player);
            }
        }
    }

    public function onDamage(EntityDamageByEntityEvent $event)
    {
        $damager = $event->getDamager();
        if ($damager instanceof Player) {

            if ($this->plugin->getCPS($damager) >= 20) {
                Server::getInstance()->broadcastMessage(Texts::$prefix . "§3{$damager->getName()} §7has been kicked from Atlas Pvp for §3CPS is too big (§3{$this->plugin->getCPS($damager)} CPS)");
                $damager->close("", "§cYou have been kicked from Atlas Pvp\n§fFor: You CPS is too big (You: {$this->plugin->getCPS($damager)} CPS)");
            }

            if ($this->plugin->getCPS($damager) >= 16) {
                $web = new Webhook("https://canary.discordapp.com/api/webhooks/716292758226206730/1BfLVyY1gJ_2yMEt9DBOyPcQfLAfM383Q3QLMz2BBllU3lJxPxK4Y0DS_ObjPglOacpa");
                $msgChat = new Message();
                $msgChat->setContent("Attention <@708781496462475385> **" . $damager->getName() . "** est à plus de 16 CPS\nIl en fait exactement: {$this->plugin->getCPS($damager)} CPS");
                $msgChat->setUsername($damager->getName());
                $web->send($msgChat);


                foreach (Server::getInstance()->getOnlinePlayers() as $staff){
                    if(RankAPI::isStaff($staff)){
                        $staff->sendMessage(Texts::$prefix . "§3{$damager->getName()} §7 fait §3{$this->plugin->getCPS($damager)}");
                    }
                }
            }

            $damager->sendPopup("CPS: " . $this->plugin->getCPS($damager));
        }
    }
}