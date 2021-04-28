<?php

namespace UnknowG\Atlas\forms\utils;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\data\SQL;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\utils\texts\Texts;

class TopForm
{
    public static function kills(Player $p)
    {
        $form = new SimpleForm
        (
            function (Player $p, $data) {
                if ($data === null) {
                } else {
                    switch ($data) {
                        case 0:
                            break;
                            break;
                    }
                }
            }
        );

        $form->setTitle("§lTop Kills");
        $conn = SQL::getDatabase();
        foreach ($conn->query("SELECT playerName, FROM players ORDER BY") as $row) {
            $form->addButton($row["playerName"]);
        }
        $p->sendForm($form);
    }
}