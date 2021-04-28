<?php

namespace UnknowG\Atlas\hikabrain;

use pocketmine\level\Level;
use pocketmine\Player;
use UnknowG\Atlas\Atlas;

class Texts
{
    private static $text;

    public static $prefix = "§7[§3Hikabrain§7]";

    public static function getText(): Texts
    {
        if (is_null(self::$text))
            self::$text = new Texts();
        return self::$text;
    }
}