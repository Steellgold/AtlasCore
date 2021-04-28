<?php

namespace UnknowG\Atlas\events\npc;

use http\QueryString;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDeathEvent;
use pocketmine\event\entity\EntityMotionEvent;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\plugin\EventExecutor;
use UnknowG\Atlas\api\QuestAPI;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\events\player\PlayerDeath;
use UnknowG\Atlas\forms\boost\BlocksBoostForm;
use UnknowG\Atlas\forms\npc\quest\astronautQuest\AstronautQuest;
use UnknowG\Atlas\forms\utils\CompressorForm;
use UnknowG\Atlas\utils\box\Prenium;
use UnknowG\Atlas\utils\box\Vote;
use UnknowG\Atlas\utils\texts\Texts;

class NPCTraining implements Listener
{

}