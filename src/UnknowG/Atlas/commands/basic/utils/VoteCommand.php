<?php

namespace UnknowG\Atlas\commands\basic\utils;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\forms\utils\GamesForm;
use UnknowG\Atlas\utils\box\Vote;
use UnknowG\Atlas\utils\texts\Texts;

class VoteCommand extends Command
{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {

        if ($player instanceof Player) {
            $arrContextOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ),
            );
            $key = "YCSazjriX6UZwvgcBXxO4gN4I97AFLqeik";
            $pseudo = $player->getName();
            $url = "https://minecraftpocket-servers.com/api/?object=votes&element=claim&key=$key&username=".$this->removeSpace($pseudo);
            $check = file_get_contents($url, false, stream_context_create($arrContextOptions));
            switch ($check) {
                case 0:
                    $player->sendMessage(Texts::$prefixBox . Texts::getText(SQLData::getLang($player), "§7Vous devez d'abord voté", "§7You must first vote."));
                    break;
                case 1:
                    $curl = curl_init();

                    $url1 = "https://minecraftpocket-servers.com/api/?action=post&object=votes&element=claim&key=$key&username=" . $this->removeSpace($pseudo);
                    curl_setopt($curl, CURLOPT_URL, $url1);
                    $response = curl_exec($curl);
                    if ($response == true) {
                        Vote::addKey($player);
                        $player->sendMessage(Texts::$prefixBox . Texts::getText(SQLData::getLang($player), "§7Merci d'avoir voté, vous avez gagné 1 clef de vote", "§7Thank you for voting you got 1 key back."));
                        Server::getInstance()->broadcastMessage(Texts::$prefixVote . "Thank to §5{$player->getName()} §7to have voted on our vote website, if you also want to have vote keys box, go to §5https://vote.atlas-mc.fr §7!");
                    } elseif
                    ($response == false) {
                        $player->sendMessage(Texts::$prefixBox . Texts::getText(SQLData::getLang($player), "§7Vous avez déja recuperer votre recompense", "§7You've already collected your award."));
                    } else {
                        $player->sendMessage(Texts::$prefixBox . Texts::getText(SQLData::getLang($player), "§7Une erreur est survenue", "§7An error has occurred."));
                    }
                    break;
                case 2:
                    $player->sendMessage(Texts::$prefixBox . Texts::getText(SQLData::getLang($player), "§7Vous avez deja recuperer votre recompense", "§7You've already collected your award."));
                    break;

                default:
                    $player->sendMessage("Error..");
                    break;

            }
        }
    }

    private function removeSpace(string $string)
    {
        $iusername = str_replace(" ", "%20", $string);
        return $iusername;
    }
}