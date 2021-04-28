<?php

namespace UnknowG\Atlas\events\player;

use DiscordWebhookAPI\Message;
use DiscordWebhookAPI\Webhook;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\inventory\CraftingGrid;
use pocketmine\item\Item;
use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\ActorEventPacket;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\CoinsAPI;
use UnknowG\Atlas\api\LeaguesAPI;
use UnknowG\Atlas\api\ParticlesAPI;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\data\sql\SQLDataServer;
use UnknowG\Atlas\forms\LangForm;
use UnknowG\Atlas\forms\utils\ResetStatsForm;
use UnknowG\Atlas\scorehud\Scoreboards;
use UnknowG\Atlas\task\NameTagUpdateTask;
use UnknowG\Atlas\task\util\RulesCheckTask;
use UnknowG\Atlas\task\UnmuteTask;
use UnknowG\Atlas\task\util\ScoreTagUpdateTask;
use UnknowG\Atlas\utils\PlayerUtils;
use UnknowG\Atlas\utils\texts\Texts;
use UnknowG\Atlas\utils\texts\Unicodes;

class PlayerJoin implements Listener
{
    public $plugin;

    public function __construct(Atlas $atlas)
    {
        $this->plugin = $atlas;
    }

    public function giveNitro(PlayerJoinEvent $e)
    {
        $p = $e->getPlayer();
        if (SQLData::getData($p, "isNitro") == 5) {
            $time = time() + 60 * 60 * 24 * 7;
            SQLData::setData($p,"players","nitroExpire", $time);
            SQLData::setData($p,"players","isNitro", 1);
            SQLData::setData($p,"players","playerSSRank","nitro");
            Texts::sendMessage($p, Texts::$prefixBoost, "Merci de soutenir le serveur, voici le grade §dNitro §7directement en jeu !", "Thank you for supporting the server, here is the §dNitro §7grade directly in game!");
        }elseif(SQLData::getData($p,"isNitro") == 1){
            if(time() >= SQLData::getData($p,"nitroExpire")){
                SQLData::setData($p,"players","nitroExpire", 0);
                SQLData::setData($p,"players","isNitro", 0);
                SQLData::setData($p,"players","playerSSRank","player");
                Texts::sendMessage($p, Texts::$prefixBoost, "Votre grade §dNitro Booster §7a expiré, pour continuer à nous aider dans notre évolution rebooster le serveur Discord et réutilisez la commande §d&boost §7sur en ayant le grade: §dBooster", "Your rank §dNitro Booster §7has expired, to continue to help us in our evolution reboost the Discord server and reuse the §d&boost §7sur Discord command with the following grade: §dBooster");
            }
        }else{

        }

    }

    public function onJoin(PlayerJoinEvent $e)
    {
        $e->setJoinMessage("");
        $p = $e->getPlayer();

        foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer) {
            if (SQLData::getData($onlinePlayer, "playerIpAdress") == $p->getAddress()) {
                $adress = $p->getAddress();
                $p->close("", "§cYou have been kicked from §fAtlas Pvp §cfor: \n§7Reason: Aleardy player as connected with IP: {$adress}");
            }
        }

        foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer) {
            if (SQLData::getData($onlinePlayer, "showPopus") == 1) {
                $onlinePlayer->sendTip("§2+ §a{$p->getName()} §2+");
            }
        }

        if (!$p->hasPlayedBefore()) {
            $webhook = new Webhook("https://canary.discordapp.com/api/webhooks/720427257969246318/nM14hvpJo0eBXXQSr4ndcwtXLYMsRJIc_cNNueKa-30E0Q4YimjImjVYOyGx-rc8YVpc");
            $msg = new Message();
            $msg->setUsername("Nouveau joueurs");
            $msg->setContent("Nouveau joueur: {$p->getName()}.dat");
            $webhook->send($msg);

            /** Register */
            SQL::registerPlayer($p);
            SQL::registerQuestPlayer($p);

            SQLData::setData($p, "players", "rulesAccept", 0);
            SQLData::setData($p, "players", "rulesResult", "not read");

            LangForm::open($p);
            $p->setGamemode(2);

            /** Lobby */
            PlayerDeath::tpLobbySpawn($p);
            self::giveCompass($p);

            /** Join */
            $p->addTitle(Texts::$prefix, Texts::$discord, 1.5, 1.5);

            $this->plugin->getScheduler()->scheduleRepeatingTask(new NameTagUpdateTask($p), 20 * 120);
            $this->plugin->getScheduler()->scheduleRepeatingTask(new ScoreTagUpdateTask($p, $this->plugin), 10);
            $this->plugin->getScheduler()->scheduleRepeatingTask(new RulesCheckTask($p), 20 * 600);

            if(SQLDataServer::getServerData("msgPrStatut") == 1){
                Texts::sendMessage($p,Texts::$prefix,SQLDataServer::getServerData("msgPrFr"),SQLDataServer::getServerData("msgPrEn"));
            }

            SQLData::setData($p,"players","playerStatus",1);
        } else {
            SQLData::setData($p,"players","playerStatus",1);
            SQLData::setData($p,"players","headPrice",0);
            SQLData::setData($p,"players","headPriceSeller","none");
            SQLData::setData($p,"players","asHeadPrice","false");
            SQLData::setData($p, "players", "isNick", 0);

            if (!SQLData::getData($p, "rulesAccept") == 1) {
                SQLData::setData($p, "players", "rulesAccept", 0);
                SQLData::setData($p, "players", "rulesResult", "not read");
            }

            PlayerUtils::onJoinUtils($p);
            PlayerUtils::saveAdress($p);
            PlayerUtils::checkPremiumKey($p);

            /** Premium Blocs */
            if (RankAPI::isPremium($p)) {
                if (SQLData::getLang($p) == "fr") {
                    $p->addTitle(Texts::$prefixPrenium, "Merci de votre confiance !", 1.0, 1.0);
                } else {
                    $p->addTitle(Texts::$prefixPrenium, "Thank you for your confiance!", 1.0, 1.0);
                }
            } else {
                $p->addTitle(Texts::$prefix, Texts::$discord, 1.0, 1.0);
            }

            /** Mute */
            $this->plugin->getScheduler()->scheduleRepeatingTask(new UnmuteTask($p), 20 * 60);

            /** Nametag */
            $this->plugin->getScheduler()->scheduleRepeatingTask(new NameTagUpdateTask($p), 20 * 120);
            $this->plugin->getScheduler()->scheduleRepeatingTask(new ScoreTagUpdateTask($p, $this->plugin), 10);
            $this->plugin->getScheduler()->scheduleRepeatingTask(new RulesCheckTask($p), 20 * 600);

            if(SQLDataServer::getServerData("msgPrStatut") == 1){
                Texts::sendMessage($p,Texts::$prefixBeta,SQLDataServer::getServerData("msgPrFr"),SQLDataServer::getServerData("msgPrEn"));
            }
        }
    }

    public function whitelist(PlayerPreLoginEvent $e)
    {
        $p = $e->getPlayer();

        if (SQLData::getServerData("whitelist") == 1) {
            if (!RankAPI::isWhitelisted($p)) {
                $res = SQL::getServerData("resWhitelist");
                $p->close("", "§cServer is Whitelisted for §f$res\n§7Buy a §ePremium §7rank for acces, when the server is whitelisted");
            }
        } elseif (SQLData::getServerData("whitelist") == 2) {
            if (!RankAPI::isWhitelistedDev($p)) {
                $res = SQL::getServerData("resWhitelist");
                $p->close("", "§cServer is global whitelisted for §f$res\n§7§gPremium §7& §cStaff §7can't connect when the server is an §cDev Update");
            }
        }
    }

    /** Systeme ban */
    public function checkBan(PlayerJoinEvent $e)
    {
        $p = $e->getPlayer();

        $conn = SQL::getDatabase();
        foreach ($conn->query("SELECT adress FROM ipBanneds") as $row) {
            if ($row["adress"] == $p->getAddress()) {
                $p->close("", "§cYour §fadress ip §cis banned");
            }
        }


        if (SQLData::getBanData($p, "isBanned") == 1) {
            $time = SQLData::getBanData($p, "time");
            if (time() > $time) {
                SQLData::killBan($p);
            } else {
                $rsn = SQLData::getBanData($p, "reason");
                $time = SQLData::getBanData($p, "time");

                $init = $time - time();
                $hours = floor(($init / 3600));
                $minutes = floor(($init / 60) % 60);
                $seconds = $init % 60;
                $day = floor($init / 86400);

                $p->close("", "§cYou have banned from Atlas PvP\n§f> For: $rsn\n§f> $day days $hours hours $minutes minutes $seconds seconds left\nIf you join with double accounts: Ban IP (at life)");
            }
        }
    }

    /** Gives des items lobby */
    public static function giveCompass(Player $player)
    {
        Scoreboards::createSB($player);
        $player->removeAllEffects();

        $player->getInventory()->setItem(0, Item::get(145, 0, 1)->setCustomName("Settings"));
        $player->getInventory()->setItem(2, Item::get(450, 0, 4)->setCustomName("Duels\n§c§lMaintenance"));
        $player->getInventory()->setItem(3, Item::get(368, 0, 5)->setCustomName("Training"));
        $player->getInventory()->setItem(4, Item::get(399, 0, 8)->setCustomName("Games"));
        $player->getInventory()->setItem(5, Item::get(384, 0, 1)->setCustomName("Atlas Level Pass"));
        $player->getInventory()->setItem(6, Item::get(383, 12,1)->setCustomName("Nitro Boost")->setCustomName("Nitro Cosmetics"));
        $player->getInventory()->setItem(8, Item::get(342,0, 3)->setCustomName("Cosmetics"));

        if (RankAPI::getIDRank($player) == "admin") {
            $player->getInventory()->setItem(10, Item::get(345, 0, 1)->setCustomName("§3§lSTAFF"));
        }
    }
    public static function giveLobbyReturn(Player $player)
    {
        $player->getInventory()->setItem(0, Item::get(342,0, 3)->setCustomName("Cosmetics"));
        $player->getInventory()->setItem(8, Item::get(355, 7, 1)->setCustomName("Return to Lobby"));
    }

    public static function giveLobbyReturnHika(Player $player)
    {
        $player->getInventory()->setContents([]);
        $player->getInventory()->setItem(4, Item::get(355, 10, 1)->setCustomName("Leave the Wainting File"));
    }

    public function seasonEnd(PlayerJoinEvent $event)
    {
        $p = $event->getPlayer();

        if (SQLData::getData($p, "endTimeSeason") == 555) {
            self::totemEffect($p);
            $p->addTitle("§3Season §lRushing §r§3started !", "Finish the ALP and be the first to finish\n it for an even more unique reward than the others.");

            $uni = Unicodes::$coin;
            $gold = LeaguesAPI::getRewardByPoints($p);

            $endSeasonTime = time() + 60 * 60 * 24 * 100;
            SQLData::setData($p, "players", "endTimeSeason", $endSeasonTime);
            SQLData::setData($p, "players", "bestSeason", LeaguesAPI::getPoints($p));
            CoinsAPI::addCoins($p, $gold);
            Texts::sendMessage($p, Texts::$prefix, "Vous avez récuperer §3{$gold}{$uni} §7par rapport à votre ancienne ligue !", "You got §3{$gold}{$uni} §7back from your old league!");
            LeaguesAPI::delPoints($p, LeaguesAPI::getPoints($p));
        }
    }

    public function doubleXpEnd(PlayerJoinEvent $event)
    {
        $p = $event->getPlayer();

        if (SQLData::getData($p, "doubleXpActive") == 1) {
            if (time() > SQLData::getData($p, "doubleXpTime")) {
                Texts::sendMessage($p, Texts::$prefixPass, "Votre double effet XP s'évapore, réutilisez-le en une seule fois pour l'obtenir à nouveau.", "Your double XP effect is evaporate, reuse in one to get it again.");
                SQLData::setData($p, "players", "doubleXpTime", 0);
                SQLData::setData($p, "players", "doubleXpActive", 0);
            }
        }
    }

    public static function totemEffect(Player $player){
        $player->getInventory()->setItemInHand(Item::get(450,0,1));
        $player->broadcastEntityEvent(ActorEventPacket::CONSUME_TOTEM);
        $pk = new LevelEventPacket();
        $pk->evid = LevelEventPacket::EVENT_SOUND_TOTEM;
        $pk->position = $player->add(0, $player->eyeHeight, 0);
        $pk->data = 0;
        $player->dataPacket($pk);
        $player->getInventory()->setItemInHand(Item::get(0,0,1));
    }
}