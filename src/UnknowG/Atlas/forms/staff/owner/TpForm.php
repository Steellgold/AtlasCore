<?php

namespace UnknowG\Atlas\forms\staff\owner;

use jojoe77777\FormAPI\CustomForm;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\utils\texts\Texts;

class TpForm extends CustomForm {
    public static function openAll($player)
    {
        $form = new CustomForm(function (Player $player, array $data = null) {
            if (isset($data[0])) {
                foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer) {
                    $x = $player->getX();
                    $y = $player->getY();
                    $z = $player->getZ();
                    $level = $player->getLevel();
                    $onlinePlayer->teleport(new Position($x,$y,$z,$level));
                }
            } else {
                $player->sendMessage(Texts::$prefix . "Merci de communiquer des informations via cette interface");
            }
        });

        $form->setTitle("§lStaff");
        $form->addInput("Pseudo","");
        $form->sendToPlayer($player);
    }
}