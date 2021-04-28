<?php

namespace UnknowG\Atlas\forms\utils;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\block\BaseRail;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\events\player\PlayerDeath;
use UnknowG\Atlas\events\player\PlayerJoin;
use UnknowG\Atlas\events\player\PlayerUse;
use UnknowG\Atlas\task\LaunchSpleefTask;
use UnknowG\Atlas\utils\RespawnUtil;
use UnknowG\Atlas\utils\Spleef;
use UnknowG\Atlas\utils\texts\Texts;
use UnknowG\Atlas\mgr\PlayerProtectManager as PPM;

class GamesForm
{
    public static function open(Player $p)
    {
        $form = new SimpleForm
        (
            function (Player $p, $data) {
                if ($data === null) {
                } else {
                    switch ($data) {
                        case 0:
                            \UnknowG\Atlas\hikabrain\forms\GamesForm::openHika($p,Atlas::getInstance());
                            break;
                        case 1:
                            PlayerUse::showPlayers($p);
                            $p->setAllowFlight(false);
                            $p->setFlying(false);

                            $p->setImmobile(false);
                            PlayerDeath::tpGappleSpawn($p);
                            $p->setGamemode(0);

                            $p->getInventory()->clearAll();
                            $p->removeAllEffects();
                            RespawnUtil::giveGappleKit($p);

                            $p->addEffect(new EffectInstance(Effect::getEffect(1), 20 * 99999, 0));
                            break;
                        case 2:
                            $p->getArmorInventory()->setContents([]);
                            $p->getInventory()->setContents([]);

                            $p->setGamemode(0);
                            RespawnUtil::giveBuildKit($p);
                            PlayerDeath::tpBuildUHC($p);
                            break;
                        case 3:
                            PlayerUse::showPlayers($p);
                            $p->setAllowFlight(false);
                            $p->setFlying(false);

                            $p->setImmobile(false);
                            PlayerDeath::tpNodeBuffSpawn($p);
                            $p->setGamemode(0);

                            $p->getInventory()->clearAll();
                            $p->removeAllEffects();
                            RespawnUtil::giveNodeKit($p);

                            $p->addEffect(new EffectInstance(Effect::getEffect(1), 20 * 99999, 1));
                            break;
                        case 4:
                            PlayerUse::showPlayers($p);
                            $p->setAllowFlight(false);
                            $p->setFlying(false);

                            $p->setImmobile(false);
                            PlayerDeath::tpBowSpawn($p);
                            $p->setGamemode(0);

                            $p->getInventory()->clearAll();
                            $p->removeAllEffects();
                            RespawnUtil::giveArcKit($p);

                            $p->addEffect(new EffectInstance(Effect::getEffect(1), 20 * 99999, 0));
                            break;
                        case 5:
                            PlayerUse::showPlayers($p);
                            $p->setAllowFlight(false);
                            $p->setFlying(false);

                            $p->setImmobile(false);
                            PlayerDeath::tpGravitySpawn($p);
                            $p->getInventory()->clearAll();
                            $p->removeAllEffects();
                            RespawnUtil::giveGappleKit($p);

                            $p->addEffect(new EffectInstance(Effect::getEffect(Effect::JUMP_BOOST), 20 * 999999, 3, false));
                            break;
                        case 6:
                            PlayerUse::showPlayers($p);
                            if (SQLData::getData($p, "flyLobby") == 1) {
                                $p->setAllowFlight(true);
                                $p->setFlying(true);
                            } else {
                                $p->setAllowFlight(false);
                                $p->setFlying(false);
                            }

                            $p->setImmobile(false);
                            $p->getInventory()->clearAll();
                            $p->removeAllEffects();
                            $p->getArmorInventory()->setContents([]);
                            $stick = new Item(297);

                            $effect = new EffectInstance(Effect::getEffect(1));
                            $effect->setDuration(20 * 99999);
                            $effect->setAmplifier(1);
                            $p->addEffect($effect);

                            $effect = new EffectInstance(Effect::getEffect(8));
                            $effect->setDuration(20 * 99999);
                            $effect->setAmplifier(5);
                            $p->addEffect($effect);

                            $stick->setCustomName("§b§lBag§fuet§cte");
                            $stick->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(12), 5));
                            $p->getInventory()->addItem($stick);
                            PlayerDeath::tpStickSpawn($p);
                            $p->setGamemode(0);
                            break;
                        case 7:
                            $p->getArmorInventory()->setContents([]);
                            $p->getInventory()->setContents([]);
                            RespawnUtil::giveNinjaKit($p);
                            PlayerDeath::tpNinjaSpawn($p);
                            break;
                        case 8:
                            $p->getArmorInventory()->setContents([]);
                            $p->getInventory()->setContents([]);

                            PlayerDeath::tpCombo($p);
                            break;
                        case 9:
                            PlayerUse::showPlayers($p);
                            if (SQLData::getData($p, "flyLobby") == 1) {
                                $p->setAllowFlight(true);
                                $p->setFlying(true);
                            } else {
                                $p->setAllowFlight(false);
                                $p->setFlying(false);
                            }

                            $p->setImmobile(false);
                            $p->getInventory()->clearAll();
                            $p->removeAllEffects();
                            $p->getArmorInventory()->setContents([]);


                            PlayerJoin::giveCompass($p);
                            PlayerDeath::tpLobbySpawn($p);
                            break;
                            break;
                    }
                }
            }
        );

        $gapple = count(Server::getInstance()->getLevelByName("gapple")->getPlayers());
        $nb = count(Server::getInstance()->getLevelByName("nodebuff")->getPlayers());
        $bow = count(Server::getInstance()->getLevelByName("bow")->getPlayers());
        $build = count(Server::getInstance()->getLevelByName("builduhc")->getPlayers());
        $grv = count(Server::getInstance()->getLevelByName("gravity")->getPlayers());
        $kbc = count(Server::getInstance()->getLevelByName("stick")->getPlayers());
        $ninja = count(Server::getInstance()->getLevelByName("ninja")->getPlayers());
        $combo = count(Server::getInstance()->getLevelByName("combo")->getPlayers());
        $lob = count(Server::getInstance()->getLevelByName("atlas")->getPlayers());

        $hika = count(Server::getInstance()->getLevelByName("hika1")->getPlayers()) + count(Server::getInstance()->getLevelByName("hika2")->getPlayers()) + count(Server::getInstance()->getLevelByName("hika3")->getPlayers()) + count(Server::getInstance()->getLevelByName("hika4")->getPlayers());

        $total = count(Server::getInstance()->getOnlinePlayers());

        $form->setTitle("§lGames");
        $form->setContent(Texts::getText(SQLData::getLang($p), "§7Choisissez le mode de jeu que vous voulez !\n§7Total des joueurs connectées : §e$total", "§7Choose your game mode do you want to play !\n§7Total connected players : §e$total") . "\n ");
        $form->addButton("Hikabrain\n§0$hika players | UNRANKED",1,"https://rv-shock.net/minecraft/forms/hikabrain.png");
        $form->addButton("Gapple\n§0$gapple players | RANKED",1,"https://rv-shock.net/minecraft/forms/gapple.png");
        $form->addButton("BuildUHC\n§0$build players | RANKED",1,"https://rv-shock.net/minecraft/textures/item/lava_bucket.png");
        $form->addButton("NodeBuff\n§0$nb players | RANKED",1,"https://rv-shock.net/minecraft/forms/nodebuff.png");
        $form->addButton("Bow\n§0$bow players | RANKED",1,"https://rv-shock.net/minecraft/textures/item/bow_pulling_1.png");
        $form->addButton("Gravity\n§0$grv players | UNRANKED",1,"https://rv-shock.net/minecraft/forms/jumpboost.png");
        $form->addButton("Knockbacking\n§0$kbc players | UNRANKED",1,"https://rv-shock.net/minecraft/textures/item/stick.png");
        $form->addButton("Ninja\n§0$ninja players | UNRANKED",1,"https://rv-shock.net/minecraft/forms/snowball.png");
        $form->addButton("Combo\n§0$combo players | UNRANKED",1,"https://rv-shock.net/minecraft/forms/hand.png");
        $form->addButton("§l§cHub§r\n§0$lob players",1,"https://rv-shock.net/minecraft/forms/hub.png");
        $p->sendForm($form);
    }
}