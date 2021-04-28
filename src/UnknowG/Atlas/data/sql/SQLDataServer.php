<?php

namespace UnknowG\Atlas\data\sql;

use UnknowG\Atlas\data\SQL;

class SQLDataServer extends SQL{
    public static function setKB(string $result)
    {
        $database = SQL::getDatabase();

        $database->query("UPDATE `serverData` SET `kb`='$result' WHERE id=1");
    }

    public static function setArrowDamage(string $result)
    {
        $database = SQL::getDatabase();

        $database->query("UPDATE `serverData` SET `shootArrowDamage`='$result' WHERE id=1");
    }

    public static function setWhitelist(string $result)
    {
        $database = SQL::getDatabase();

        $database->query("UPDATE `serverData` SET `whitelist`='$result' WHERE id=1");
    }

    public static function setWhitelistReason(string $result)
    {
        $database = SQL::getDatabase();

        $database->query("UPDATE `serverData` SET `resWhitelist`='$result' WHERE id=1");
    }

    public static function setChat(string $result)
    {
        $database = SQL::getDatabase();

        $database->query("UPDATE `serverData` SET `chat`='$result' WHERE id=1");
    }

    public static function setConnecteds(string $result)
    {
        $database = SQL::getDatabase();

        $database->query("UPDATE `serverData` SET `connecteds`='$result' WHERE id=1");
    }
}