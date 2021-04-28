<?php

namespace UnknowG\Atlas\hikabrain\forms;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\events\player\PlayerJoin;
use UnknowG\Atlas\hikabrain\manager\Game;
use UnknowG\Atlas\hikabrain\manager\Team;
use UnknowG\Atlas\utils\texts\Texts;

class GamesForm extends SimpleForm{
    public static function openHika(Player $p, Atlas $plugin)
    {
        $form = new SimpleForm
        (
            function (Player $p, $data) use ($plugin) {
                if ($data === null) {
                } else {
                    switch ($data) {
                        case 0:
                            if (Game::getGame()->canPartyJoin(Server::getInstance()->getLevelByName("hika1"))) {
                                $file = Atlas::getHikabrainFileData("WFile");
                                if (!Team::getTeam()->isWaintingFile($p)) {
                                    if (!Server::getInstance()->getPlayer($file->get("hika1")["bluePlayer"]) instanceof Player) {
                                        Atlas::getInstance()->resetHIKA1();
                                        Team::getTeam()->addWaintingFile("hika1", $p->getName(), Atlas::getInstance());
                                        PlayerJoin::giveLobbyReturnHika($p);
                                    } else {
                                        Team::getTeam()->addWaintingFile("hika1", $p->getName(), Atlas::getInstance());
                                    }
                                } else {
                                    $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " You already in the waiting list of the ". Game::$wfile[$p->getName()] ." world");
                                }
                            } else {
                                $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " A game is already in progress, please wait.");
                            }
                            break;
                        case 1:
                            if (Game::getGame()->canPartyJoin(Server::getInstance()->getLevelByName("hika4"))) {
                                $file = Atlas::getHikabrainFileData("WFile");
                                if (!Team::getTeam()->isWaintingFile($p)) {
                                    if (!Server::getInstance()->getPlayer($file->get("hika4")["bluePlayer"]) instanceof Player) {
                                        Atlas::getInstance()->resetHIKA1();
                                        Team::getTeam()->addWaintingFile("hika4", $p->getName(), Atlas::getInstance());
                                        PlayerJoin::giveLobbyReturnHika($p);
                                    } else {
                                        Team::getTeam()->addWaintingFile("hika4", $p->getName(), Atlas::getInstance());
                                    }
                                } else {
                                    $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " You already in the waiting list of the ". Game::$wfile[$p->getName()] ." world");
                                }
                            } else {
                                $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " A game is already in progress, please wait.");
                            }
                            break;
                        case 2:
                            if (Game::getGame()->canPartyJoin(Server::getInstance()->getLevelByName("hika3"))) {
                                $file = Atlas::getHikabrainFileData("WFile");
                                if (!Team::getTeam()->isWaintingFile($p)) {
                                    if (!Server::getInstance()->getPlayer($file->get("hika3")["bluePlayer"]) instanceof Player) {
                                        Atlas::getInstance()->resetHIKA1();
                                        Team::getTeam()->addWaintingFile("hika3", $p->getName(), Atlas::getInstance());
                                        PlayerJoin::giveLobbyReturnHika($p);
                                    } else {
                                        Team::getTeam()->addWaintingFile("hika3", $p->getName(), Atlas::getInstance());
                                    }
                                } else {
                                    $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " You already in the waiting list of the ". Game::$wfile[$p->getName()] ." world");
                                }
                            } else {
                                $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " A game is already in progress, please wait.");
                            }
                            break;
                        case 3:
                            if (Game::getGame()->canPartyJoin(Server::getInstance()->getLevelByName("hika2"))) {
                                $file = Atlas::getHikabrainFileData("WFile");
                                if (!Team::getTeam()->isWaintingFile($p)) {
                                    if (!Server::getInstance()->getPlayer($file->get("hika2")["bluePlayer"]) instanceof Player) {
                                        Atlas::getInstance()->resetHIKA1();
                                        Team::getTeam()->addWaintingFile("hika2", $p->getName(), Atlas::getInstance());
                                        PlayerJoin::giveLobbyReturnHika($p);
                                    } else {
                                        Team::getTeam()->addWaintingFile("hika2", $p->getName(), Atlas::getInstance());
                                    }
                                } else {
                                    $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " You already in the waiting list of the ". Game::$wfile[$p->getName()] ." world");
                                }
                            } else {
                                $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " A game is already in progress, please wait.");
                            }
                            break;
                        case 4:
                            if (Game::getGame()->canPartyJoin(Server::getInstance()->getLevelByName("hikaOriginal"))) {
                                $file = Atlas::getHikabrainFileData("WFile");
                                if (!Team::getTeam()->isWaintingFile($p)) {
                                    if (!Server::getInstance()->getPlayer($file->get("hikaOriginal")["bluePlayer"]) instanceof Player) {
                                        Atlas::getInstance()->resetHIKAOriginal();
                                        Team::getTeam()->addWaintingFile("hikaOriginal", $p->getName(), Atlas::getInstance());
                                        PlayerJoin::giveLobbyReturnHika($p);
                                    } else {
                                        Team::getTeam()->addWaintingFile("hikaOriginal", $p->getName(), Atlas::getInstance());
                                    }
                                } else {
                                    $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " You already in the waiting list of the ". Game::$wfile[$p->getName()] ." world");
                                }
                            } else {
                                $p->sendMessage(\UnknowG\Atlas\hikabrain\Texts::$prefix . " A game is already in progress, please wait.");
                            }
                            break;
                            break;
                    }
                }
            }
        );

        if(Game::getGame()->canPartyJoin(Server::getInstance()->getLevelByName("hika1"))){
            $volcano = "§0Wainting for players";
        }else{
            $volcano = "§0The game is §c§lfull.. §r§0please wait";
        }

        if(Game::getGame()->canPartyJoin(Server::getInstance()->getLevelByName("hika4"))){
            $natural = "§0Wainting for players";
        }else{
            $natural = "§0The game is §c§lfull.. §r§0please wait";
        }

        $form->setTitle("§l- Hikabrain");
        $form->setContent("§7§l» §r§7" . Texts::getText(SQLData::getLang($p),"Choisissez quel map vous voulez !","Choose a map do you want to play"));
        $form->addButton(Texts::getText(SQLData::getLang($p),"Arène des volcans","Volcano Arena") . "\n$volcano");
        $form->addButton(Texts::getText(SQLData::getLang($p),"Arène naturelle","Natural Arena") . "\n$natural");
        $form->addButton(Texts::getText(SQLData::getLang($p),"Arène couturière","Seamstress Arena") . "\n$natural");
        $form->addButton(Texts::getText(SQLData::getLang($p),"Arène zone désertique","Arena Desert Zone") . "\n$natural");
        $form->addButton(Texts::getText(SQLData::getLang($p),"Hikabrain Original","Original's Hikabrain") . "\n$natural");
        $p->sendForm($form);
    }
}