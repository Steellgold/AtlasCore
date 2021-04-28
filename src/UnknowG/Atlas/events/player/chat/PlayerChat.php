<?php

namespace UnknowG\Atlas\events\player\chat;

use DiscordWebhookAPI\Message;
use DiscordWebhookAPI\Webhook;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\level\particle\Particle;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\api\ApiXP;
use UnknowG\Atlas\api\LeaguesAPI;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\MySQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\data\sql\SQLDataServer;
use UnknowG\Atlas\utils\texts\Texts;
use UnknowG\Atlas\utils\texts\Unicodes;
use const http\Client\Curl\Features\UNIX_SOCKETS;

class PlayerChat implements Listener
{
    public $plugin;

    public function __construct(Atlas $atlas)
    {
        $this->plugin = $atlas;
    }

    public function onChat(PlayerChatEvent $e)
    {
        $p = $e->getPlayer();
        $pn = $e->getPlayer()->getName();
        $level = ApiXP::getLevel($p);

        if ($level == "hika1" || $level == "hika2" || $level == "hika3" || $level == "hika4" || $level == "hikaOriginal") {

        } else {

            ApiXP::getLevelByXp($p);

            $port = Server::getInstance()->getPort();
            $msg = $e->getMessage();
            SQL::getDatabase()->query("INSERT INTO `messages`(`message`, `server`, `player`) VALUES ('$msg','$port','$pn')");

            $msgContent = $e->getMessage();
            $msgFirst = str_replace(
                array("coin", "armor", "food"),
                array(Unicodes::$coin, Unicodes::$armor, Unicodes::$food),
                $msgContent
            );

            $league = LeaguesAPI::getLeague($p);

            $e->setCancelled();

            if (self::isPremium($p)) {
                $pr = "§lPremium§r ";
            } else {
                $pr = "";
            }

            $array = [
                "fdp",
                "fils de pute",
                "noob",
                "@everyone",
                "@here",
                "ntm",
                "nique ta mere",
                "nique ta mère",
                "fuck you",
                "cheh",
                "tg",
                "random"
            ];

            $msg = str_replace(
                $array,
                Unicodes::$craft1,
                $msgFirst
            );

            switch (RankAPI::getSubRank($p)) {
                case "muted":
                    $this->sendDiscordMessage("[MUTED] " . $e->getPlayer()->getName(), "~~" . $e->getMessage() . "~~");
                    break;
            }


            if (SQLDataServer::getServerData("chat") == 0) {
                switch (SQLData::getData($p, "playerRank")) {
                    case "fonda":
                        if (SQLData::getData($p, "isNick") == 1) {
                            $fakename = SQLData::getData($p, "nickName");
                            $this->sendDiscordMessage("[NICKED $fakename] $pn", $msg);
                            $this->sendWordMessage("§7[§00§7] §7Player §l{$fakename} §r§7Unranked §l» §r§7$msg");
                        } else {
                            $this->sendDiscordMessage("$pn", $msg);
                            if (SQLData::getData($p, "showRank") == 1) {
                                $this->sendWordMessage("§7[§3$level" . "§7] §3§lOwner§r§3 $pn §l{$pr}§r§3$league §7» §r§3$msg");
                            } else {
                                $this->sendWordMessage("§7[§3$level" . "§7] §3§lOwner§r§3 $pn §r§3§l$league §r§7» §r§3$msg");
                            }
                        }
                        break;
                    case "admin":
                        if (SQLData::getData($p, "isNick") == 1) {
                            $fakename = SQLData::getData($p, "nickName");
                            $this->sendDiscordMessage("[NICKED $fakename] $pn", $msg);
                            $this->sendWordMessage("§7[§00§r§7] §7Player §l{$fakename} §r§7Unranked §l» §r§7$msg");
                        } else {
                            $this->sendDiscordMessage("$pn", $msg);
                            if (SQLData::getData($p, "showRank") == 1) {
                                $this->sendWordMessage("§7[§b$level" . "§7] §b§lAdmin§r§b $pn §l{$pr}§r§b$league §7» §b$msg");
                            } else {
                                $this->sendWordMessage("§7[§b$level" . "§7] §b§lAdmin§r§b $pn §r§b§l$league §r§7» §b$msg");
                            }
                        }
                        break;
                    case "staff":
                        if (SQLData::getData($p, "isNick") == 1) {
                            $fakename = SQLData::getData($p, "nickName");
                            $this->sendDiscordMessage("[NICKED $fakename] $pn", $msg);
                            $this->sendWordMessage("§7[§l0§r§7] §7Player §l{$fakename} §r§7Unranked §l» §r§7$msg");
                        } else {
                            $this->sendDiscordMessage($pn, $msg);
                            if (SQLData::getData($p, "showRank") == 1) {
                                $this->sendWordMessage("§7[§c$level" . "§7] §c§lSuper-Mod§r§c $pn §l{$pr}§r§c$league §7» §c$msg");
                            } else {
                                $this->sendWordMessage("§7[§c$level" . "§7] §c§lSuper-Mod§r§c $pn §r§l§c$league §r§7» §c$msg");
                            }
                        }
                        break;
                    case "support":
                        if (SQLData::getData($p, "isNick") == 1) {
                            $fakename = SQLData::getData($p, "nickName");
                            $this->sendDiscordMessage("[NICKED $fakename] $pn", $msg);
                            $this->sendWordMessage("§7[§l0§r§7] §7Player §l{$fakename} §r§7Unranked §l» §r§7$msg");
                        } else {
                            if (SQLData::getData($p, "showRank") == 1) {
                                $this->sendWordMessage("§7[§6$level" . "§7] §6§lMod§r§6 $pn §l{$pr}§r§6$league §7» §6$msg");
                            } else {
                                $this->sendWordMessage("§7[§6$level" . "§7] §6§lMod§r§6 $pn §r§l§6$league §r§7» §6$msg");
                            }
                        }
                        break;
                    case "prenium":
                        if (RankAPI::getSubRank($p) == "muted") {
                            if (self::checkMuteExpired($p)) {
                                SQLData::killMute($p);
                                RankAPI::setSubRank($p, "player");
                            }
                        } else {
                            $this->sendDiscordMessage($pn, $msg);
                            if (SQLData::getData($p, "playerSSRank") == "nitro") {
                                $this->sendWordMessage("§7[§d$level" . "§r§7] §dNitro §7$pn §r§d$league §r§7§l» §r§d$msg");
                            } else {
                                if (SQLData::getData($p, "showRank") == 1) {
                                    $this->sendWordMessage("§7[§g$level" . "§7] §g§lPremium§r§g $pn §l$league §r§7» §g$msg");
                                } else {
                                    $this->sendWordMessage("§7[§l$level" . "§7] §7Player §l$pn §r§7$league §l» §r§7$msg");
                                }
                            }
                        }
                        break;
                    case "ytb":
                        if (SQLData::getData($p, "isNick") == 1) {
                            $fakename = SQLData::getData($p, "nickName");
                            $this->sendDiscordMessage("[NICKED $fakename] $pn", $msg);
                            $this->sendWordMessage("§7[§l0§r§7] §7Player §l{$fakename} §r§7Unranked §l» §r§7$msg");
                        } else {
                            if (RankAPI::getSubRank($p) == "muted") {
                                if (self::checkMuteExpired($p)) {
                                    SQLData::killMute($p);
                                    RankAPI::setSubRank($p, "player");
                                }
                            } else {
                                if (SQLData::getData($p, "playerSSRank") == "nitro") {
                                    $this->sendWordMessage("§7[§d$level" . "§r§7] §dNitro §7$pn §r§d$league §r§7§l» §r§d$msg");
                                    $this->sendDiscordMessage($pn, $msg);
                                } else {
                                    $this->sendDiscordMessage($pn, $msg);
                                    if (SQLData::getData($p, "showRank") == 1) {
                                        $this->sendWordMessage("§7[§c$level" . "§7] §c§lYouTuber§r§c $pn {$pr}§c$league §7» §c$msg");
                                    } else {
                                        $this->sendWordMessage("§7[§c$level" . "§7] §c§lYouTuber§r§c $pn §c§l$league §r§7» §c$msg");
                                    }
                                }
                            }
                        }
                        break;
                    case "player":
                        if (RankAPI::getSubRank($p) == "muted") {
                            if (self::checkMuteExpired($p)) {
                                SQLData::killMute($p);
                                RankAPI::setSubRank($p, "player");
                            }
                        } else {
                            if (SQLData::getData($p, "playerSSRank") == "nitro") {
                                $this->sendWordMessage("§7[§d$level" . "§r§7] §dNitro §7$pn §r§d$league §r§7§l» §r§d$msg");
                                $this->sendDiscordMessage($pn, $msg);
                            } else {
                                $this->sendDiscordMessage($pn, $msg);
                                $this->sendWordMessage("§7[§l$level" . "§r§7] §7Player §l$pn §r§7$league §l» §r§7$msg");
                            }
                        }
                        break;
                }
            }
            return false;
        }
    }

    public static function isPremium(Player $player)
    {
        if (SQLData::getData($player, "playerRank") == "prenium") {
            return "Premium";
        } elseif (SQLData::getData($player, "playerSubRank") == "prenium") {
            return "Premium";
        } else {
            return "";
        }
    }

    public static function isSupport(Player $player)
    {
        if (SQLData::getData($player, "playerRank") == "support") {
            return "support";
        } elseif (SQLData::getData($player, "playerSubRank") == "support") {
            return "support";
        } else {
            return "";
        }
    }

    public static function checkMuteExpired(Player $player)
    {
        if (SQLData::getMuteData($player, "isMuted") == 1) {
            $time = SQLData::getMuteData($player, "time");
            if (time() > $time) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function contains($string, array $contains): bool
    {
        foreach ($contains as $contain) {
            if (strpos(strtolower($string), $contain) !== false) {
                return true;
            }
        }

        return false;
    }

    public function sendDiscordMessage(string $username, string $content)
    {
        $web = new Webhook("https://canary.discordapp.com/api/webhooks/713008982322708570/ElgCiReHRjtjYlfjiY28dyq-RlGL6F6iVNo1kec2TFGEIP0WJ2qCs-6voT2YNsHqrURq");
        $msgChat = new Message();
        $msgChat->setUsername($username);
        $msgChat->setContent($content);
        $web->send($msgChat);
    }

    public static function sendWordMessage(string $mesage)
    {
        $worlds = ["atlas","arenas", "bow", "nodebuff", "gravity", "train1", "train2", "train3", "train4", "train5", "arena1", "arena2", "arena3", "arena4", "arena5", "stick", "ninja", "sumo", "combo", "builduhc"];
        foreach (Server::getInstance()->getOnlinePlayers() as $player) {
            if (in_array($player->getLevel()->getName(), $worlds)){
                $player->sendMessage($mesage);
            }
        }
    }
}