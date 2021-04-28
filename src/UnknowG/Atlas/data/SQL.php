<?php

namespace UnknowG\Atlas\data;

use pocketmine\Player;
use UnknowG\Atlas\data\sql\MySQL;
use UnknowG\Atlas\data\sql\SQLData;

class SQL{
    public static function getDatabase()
    {
        $db = new MySQL("127.0.0.1","steell","KqJ2c1awRIOsuJ1i","atlas");
        return $db->connectionSQL();
    }

    public static function registerPlayer(Player $player)
    {
        $db = self::getDatabase();
        $name = $player->getName();

        $adress = base64_encode($player->getAddress());

        $endSeasonTime = time() + 60 * 60 * 24 * 30;

        $db->query("INSERT INTO `players`(`playerName`, `playerIpAdress`, `playerLang`, `playerDesc`, `playerStatus`, `playerKillCount`, `playerDeathCount`,  `playerXp`, `playerLevel`,`playerCoinsCount`, `playerPointsCounts`, `playerRank`, `playerSubRank`, `playerSSRank`, `playerKeyCountsPrenium`, `playerKeyCountsVote`, `playerPremiumCoinsCount`, `playerGoldCount`, `timeKeyPrenium`, `showPopus`, `autoReconnect`, `flyLobby`, `showRank`, `lgShow`, `rulesAccept`, `isNick`, `nickName`, `fakeRole`, `endTimeSeason`, `bestSeason`, `headPrice`, `headPriceSeller`, `asHeadPrice`, `petSkeleton`, `petZombie`, `petCat`, `petHorse`, `petGuardian`, `petTurtle`, `petSpider`, `petPhantom`, `petTnt`, `petWither`, `petFireball`, `petMinecart`, `petCamera`, `petPanda`, `petHooper`, `capeGalaxy`, `capeAlchemist`, `capeKing`, `capeDragon`, `capeDark`, `capeNike`, `capeFlash`, `capeNutella`, `asALP`, `nitroExpire`, `isNitro`, `doubleXpBottles`, `doubleXpTime`, `doubleXpActive`) VALUES ('$name','$adress','en','none',0,0,0,0,0,0,0,'player','player','player',0,0,0,0,0,1,1,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)");
        $db->query("INSERT INTO `playersParticles`(`playerName`,`heartParticles`,`greenParticles`,`damageParticles`,`bloodParticles`,`cobwebParticles`,`dirtParticles`,`particleUsed`) VALUES ('$name',0,0,0,0,0,0,'none')");
        $db->close();
    }

    public static function registerBan($playername,int $time, string $reason,int $t, string $moderator)
    {
        $db = self::getDatabase();

        $db->query("INSERT INTO `bannedPlayers`(`playerName`, `time`, `reason`,`t`,`isBanned`,`moderator`) VALUES ('$playername','$time','$reason','$t',1,'$moderator')");
        $db->close();
    }

    public static function registerMute($playername,int $time, string $reason, int $t, string $moderator)
    {
        $db = self::getDatabase();

        $db->query("INSERT INTO `mutedPlayers`(`playerName`, `time`, `reason`,`t`,`isMuted`,`moderator`) VALUES ('$playername','$time','$reason','$t',1,'$moderator')");
        $db->close();
    }

    public static function registerQuestPlayer(Player $player)
    {
        $db = self::getDatabase();
        $name = $player->getName();

        $db->query("INSERT INTO questPlayer(playerName,astronautStarted,astronautHaveSon,astronautFinished) VALUES ('{$player->getName()}',0,0,0)");
        $db->close();
    }

    public static function getData(Player $player, string $getData)
    {
        $db = SQL::getDatabase();
        $name = $player->getName();

        $data = mysqli_fetch_array($db->query("SELECT * FROM players WHERE playerName = '" . $name . "'"));
        return $data[$getData];
    }

    public static function getServerNitroData(Player $player, string $getData)
    {
        $db = SQL::getDatabase();
        $name = $player->getName();

        $data = mysqli_fetch_array($db->query("SELECT * FROM niroBoosting WHERE playerName = '" . $name . "'"));
        return $data[$getData];
    }

    public static function getOffData(string $name, string $getData)
    {
        $db = SQL::getDatabase();

        $data = mysqli_fetch_array($db->query("SELECT * FROM players WHERE playerName = '" . $name . "'"));
        return $data[$getData];
    }

    public static function getEFData(Player $player, string $getData)
    {
        $db = SQL::getDatabase();
        $name = $player->getName();

        $data = mysqli_fetch_array($db->query("SELECT * FROM playersCosmKills WHERE playerName = '" . $name . "'"));
        return $data[$getData];
    }

    public static function getQuestData(Player $player, string $getData)
    {
        $db = SQL::getDatabase();
        $name = $player->getName();

        $data = mysqli_fetch_array($db->query("SELECT * FROM questPlayer WHERE playerName = '" . $name . "'"));
        return $data[$getData];
    }

    public static function getServerData(string $getData)
    {
        $db = SQL::getDatabase();

        $data = mysqli_fetch_array($db->query("SELECT * FROM serverData WHERE id = 1"));
        return $data[$getData];
    }

    public static function getBanData(Player $player, string $getData)
    {
        $db = SQL::getDatabase();
        $name = $player->getName();

        $data = mysqli_fetch_array($db->query("SELECT * FROM bannedPlayers WHERE playerName = '$name'"));
        return $data[$getData];
    }

    public static function getMuteData(Player $player, string $getData)
    {
        $db = SQL::getDatabase();
        $name = $player->getName();

        $data = mysqli_fetch_array($db->query("SELECT * FROM mutedPlayers WHERE playerName = '$name'"));
        return $data[$getData];
    }
}