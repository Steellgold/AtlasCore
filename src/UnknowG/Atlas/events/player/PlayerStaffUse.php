<?php

namespace UnknowG\Atlas\events\player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerInteractEvent;
use UnknowG\Atlas\commands\staff\StaffCommand;
use UnknowG\Atlas\forms\LangForm;
use UnknowG\Atlas\forms\LeagueForm;
use UnknowG\Atlas\forms\particles\ParticlesListForm;
use UnknowG\Atlas\forms\staff\sanctions\BanForm;
use UnknowG\Atlas\forms\staff\sanctions\KickForm;
use UnknowG\Atlas\forms\staff\sanctions\MuteForm;
use UnknowG\Atlas\forms\staff\sanctions\TpForm;
use UnknowG\Atlas\forms\utils\GamesForm;
use UnknowG\Atlas\forms\utils\StatisticsForm;
use UnknowG\Atlas\utils\texts\Texts;

class PlayerStaffUse implements Listener{
    public function onUse(PlayerInteractEvent $event)
    {
        if ($event->getItem()->getId() == 283) {
            if($event->getItem()->getName() == "Enable Vanish"){
                $event->getPlayer()->setGamemode(0);
                $event->getPlayer()->setFlying(true);
                $event->getPlayer()->setInvisible(true);

                $event->getPlayer()->setMaxHealth(50);
                $event->getPlayer()->setHealth(50);
            }
            if($event->getItem()->getName() == "Disable Vanish"){
                $event->getPlayer()->setGamemode(0);
                $event->getPlayer()->setFlying(false);
                $event->getPlayer()->setInvisible(false);

                $event->getPlayer()->setMaxHealth(20);
                $event->getPlayer()->setHealth(20);
            }
        }

        if ($event->getItem()->getId() == 368) {
            if($event->getItem()->getName() == "Teleport"){
                $event->setCancelled();
                TpForm::open($event->getPlayer());
            }
        }
    }
}