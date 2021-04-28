<?php

namespace UnknowG\Atlas\forms\staff\sanctions;

use jojoe77777\FormAPI\CustomForm;
use pocketmine\Player;
use pocketmine\Server;
use UnknowG\Atlas\utils\texts\Texts;

class KickForm extends CustomForm {
    public static function openAll($player)
    {
        $form = new CustomForm(function (Player $player, array $data = null) {
            if (isset($data[0]) && isset($data[1])) {
                foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer) {
                    $onlinePlayer->close("","§cYou have been kicked from Atlas\n§fFor: {$data[0]}");
                }
            } else {
                $player->sendMessage(Texts::$prefix . "Merci de communiquer des informations via cette interface");
            }
        });

        $form->setTitle("§lStaff");
        $form->addInput("Raison","");
        $form->sendToPlayer($player);
    }
}