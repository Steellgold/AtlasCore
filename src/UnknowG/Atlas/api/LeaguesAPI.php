<?php

namespace UnknowG\Atlas\api;

use pocketmine\Player;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;

class LeaguesAPI extends SQL {
    public static $ligueBronze = 50;
    public static $ligueSilver = 100;
    public static $ligueGold = 150;
    public static $liguePlatine = 200;
    public static $ligueDiamant = 300;
    public static $ligueChampion = 400;
    public static $ligueMaster = 500;
    public static $ligueChallenger = 600;
    public static $ligueLegende = 700;

    public static function getPoints(Player $player)
    {
        return $pts = SQL::getData($player,"playerPointsCounts");
    }

    public static function addPoints(Player $player, int $count){
        $database = SQL::getDatabase();
        $name = $player->getName();

        $g = self::getPoints($player);
        $calc = $g + $count;

        $database->query("UPDATE `players` SET `playerPointsCounts`='$calc' WHERE playerName = '$name'");
    }

    public static function delPoints(Player $player, int $count){
        $database = SQL::getDatabase();
        $name = $player->getName();

        $g = self::getPoints($player);
        $calc = $g - $count;

        $database->query("UPDATE `players` SET `playerPointsCounts`='$calc' WHERE playerName = '$name'");
    }

    public static function getLeague(Player $player)
    {
        $pts = SQL::getData($player,"playerPointsCounts");

        if($pts >= 700){
            return "Légende";
        }elseif($pts >= 600){
            return "Challenger";
        }elseif($pts >= 500){
            return "Master";
        }elseif($pts >= 400){
            return "Champion";
        }elseif($pts >= 300){
            return "Diamant";
        }elseif($pts >= 200){
            return "Platine";
        }elseif($pts >= 150){
            return "Gold";
        }elseif($pts >= 100) {
            return "Silver";
        }elseif($pts >= 50) {
            return "Bronze";
        }else{
            return "Unranked";
        }
    }

    public static function getNextLeague(Player $player){
        $pts = SQL::getData($player,"playerPointsCounts");

        if(self::getLeague($player) == "Unranked"){
            return "Bronze";
        }elseif(self::getLeague($player) == "Bronze"){
            return "Silver";
        }elseif(self::getLeague($player) == "Silver") {
            return "Gold";
        }elseif(self::getLeague($player) == "Gold") {
            return "Platine";
        }elseif(self::getLeague($player) == "Platine") {
            return "Diamant";
        }elseif(self::getLeague($player) == "Diamant") {
            return "Champion";
        }elseif(self::getLeague($player) == "Champion") {
            return "Master";
        }elseif(self::getLeague($player) == "Master") {
            return "Challenger";
        }elseif(self::getLeague($player) == "Challenger") {
            return "Légende";
        }else{
            return "Unranked";
        }
    }

    public static function getMissingPoints(Player $player, string $points)
    {
        $league = self::getLeague($player);

        if($league == "Unranked"){
            return self::$ligueBronze - $points;
        }elseif($league == "Bronze"){
            return self::$ligueSilver - $points;
        }elseif($league == "Silver"){
            return self::$ligueGold - $points;
        }elseif($league == "Gold"){
            return self::$liguePlatine - $points;
        }elseif($league == "Platine"){
            return self::$ligueDiamant - $points;
        }elseif($league == "Diamant"){
            return self::$ligueChampion- $points;
        }elseif($league == "Champion"){
            return self::$ligueMaster - $points;
        }elseif($league == "Master"){
            return self::$ligueChallenger - $points;
        }elseif($league == "Challenger"){
            return self::$ligueLegende - $points;
        }elseif($league == "Légende"){
            return "0";
        }else{
            return 0;
        }
    }

    public static function getRewardByPoints(Player $player)
    {
        $pts = SQLData::getData($player,"playerPointsCounts");

        if($pts >= 700){
            return 200;
        }elseif($pts >= 600){
            return 150;
        }elseif($pts >= 500){
            return 80;
        }elseif($pts >= 400){
            return 50;
        }elseif($pts >= 300){
            return 40;
        }elseif($pts >= 200){
            return 35;
        }elseif($pts >= 150){
            return 30;
        }elseif($pts >= 100) {
            return 25;
        }elseif($pts >= 50) {
            return 20;
        }else{
            return 15;
        }
    }

    public static function getKillsRewardByPoints(Player $player)
    {
        $pts = SQLData::getData($player,"playerPointsCounts");

        if($pts >= 700){
            return 70;
        }elseif($pts >= 600){
            return 60;
        }elseif($pts >= 500){
            return 50;
        }elseif($pts >= 400){
            return 40;
        }elseif($pts >= 300){
            return 30;
        }elseif($pts >= 200){
            return 20;
        }elseif($pts >= 150){
            return 15;
        }elseif($pts >= 100) {
            return 15;
        }elseif($pts >= 50) {
            return 10;
        }else{
            return 5;
        }
    }

    // autres
    public static function addKill(Player $player, int $count){
        $database = SQL::getDatabase();
        $name = $player->getName();

        $g = SQLData::getData($player,"playerKillCount");
        $calc = $g + $count;

        $database->query("UPDATE `players` SET `playerKillCount`='$calc' WHERE playerName = '$name'");
    }

    public static function addDeath(Player $player, int $count){
        $database = SQL::getDatabase();
        $name = $player->getName();

        $g = SQLData::getData($player,"playerDeathCount");
        $calc = $g + $count;

        $database->query("UPDATE `players` SET `playerDeathCount`='$calc' WHERE playerName = '$name'");
    }

    public static function delOffPoints(string $name, int $count){
        $database = SQL::getDatabase();

        $g = self::getOffData($name,"playerPointsCounts");
        $calc = $g - $count;

        $database->query("UPDATE `players` SET `playerPointsCounts`='$calc' WHERE playerName = '$name'");
    }

    public static function addOffPoints(string $name, int $count){
        $database = SQL::getDatabase();

        $g = self::getOffData($name,"playerPointsCounts");
        $calc = $g + $count;

        $database->query("UPDATE `players` SET `playerPointsCounts`='$calc' WHERE playerName = '$name'");
    }

    public static function setOffPoints(string $name, int $count){
        $database = SQL::getDatabase();

        $database->query("UPDATE `players` SET `playerPointsCounts`='$count' WHERE playerName = '$name'");
    }
}