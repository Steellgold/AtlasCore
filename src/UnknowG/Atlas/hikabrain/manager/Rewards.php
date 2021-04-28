<?php

namespace UnknowG\Atlas\hikabrain\manager;

class Rewards
{
    private static $rewards;

    public static function getReward(): Rewards
    {
        if (is_null(self::$rewards))
            self::$rewards = new Rewards();
        return self::$rewards;
    }

    public function getXp(int $kills, int $death){
        $cal = $death - $kills;

        if($cal * 3 <= 0){
            return 20;
        }else{
            return $cal * 3;
        }
    }
}