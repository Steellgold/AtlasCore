<?php

namespace UnknowG\Atlas;

use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\event\Listener;
use pocketmine\item\ItemFactory;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use UnknowG\Atlas\commands\basic\AboutCommand;
use UnknowG\Atlas\commands\basic\headPrice\HeadPriceCommand;
use UnknowG\Atlas\commands\basic\ResetCommand;
use UnknowG\Atlas\commands\basic\TellCommand;
use UnknowG\Atlas\commands\basic\utils\ListCommand;
use UnknowG\Atlas\commands\capes\CapesCommand;
use UnknowG\Atlas\commands\console\ConsoleReward;
use UnknowG\Atlas\commands\console\ConsoleSave;
use UnknowG\Atlas\commands\pets\PetsCommand;
use UnknowG\Atlas\commands\premium\SayCommand;
use UnknowG\Atlas\commands\premium\ScaleCommand;
use UnknowG\Atlas\commands\staff\AnnounceCommand;
use UnknowG\Atlas\commands\basic\CoinsCommand;
use UnknowG\Atlas\commands\basic\GamesCommand;
use UnknowG\Atlas\commands\basic\LangCommand;
use UnknowG\Atlas\commands\basic\LeagueCommand;
use UnknowG\Atlas\commands\basic\LobbyCommand;
use UnknowG\Atlas\commands\basic\ParticlesCommand;
use UnknowG\Atlas\commands\basic\PingCommand;
use UnknowG\Atlas\commands\basic\RulesCommand;
use UnknowG\Atlas\commands\basic\StatsCommand;
use UnknowG\Atlas\commands\basic\utils\VoteCommand;
use UnknowG\Atlas\commands\staff\CapeConverterCommand;
use UnknowG\Atlas\commands\staff\GamemodeCommand;
use UnknowG\Atlas\commands\staff\manager\FloatingTextCommand;
use UnknowG\Atlas\commands\staff\manager\PointsCommand;
use UnknowG\Atlas\commands\staff\manager\RankCommand;
use UnknowG\Atlas\commands\staff\manager\SubRankCommand;
use UnknowG\Atlas\commands\staff\SkinConverterCommand;
use UnknowG\Atlas\commands\staff\TeleportCommand;
use UnknowG\Atlas\commands\staff\VanishCommand;
use UnknowG\Atlas\commands\basic\utils\DescriptionCommand;
use UnknowG\Atlas\commands\youtube\NickCommand;
use UnknowG\Atlas\commands\staff\BanCommand;
use UnknowG\Atlas\commands\staff\BanNotConnectedCommand;
use UnknowG\Atlas\commands\staff\KickCommand;
use UnknowG\Atlas\commands\staff\MuteCommand;
use UnknowG\Atlas\commands\staff\npc\SpawnNPCCommand;
use UnknowG\Atlas\commands\staff\UnbanCommand;
use UnknowG\Atlas\commands\staff\UnmuteCommand;
use UnknowG\Atlas\commands\youtube\SkinCommand;
use UnknowG\Atlas\data\sql\SQLData;
use UnknowG\Atlas\entity\mob\Agent;
use UnknowG\Atlas\entity\mob\Creeper;
use UnknowG\Atlas\entity\mob\Endermite;
use UnknowG\Atlas\entity\mob\Fox;
use UnknowG\Atlas\events\block\BlockBreak;
use UnknowG\Atlas\events\block\BlockPlace;
use UnknowG\Atlas\events\block\BlockUpdate;
use UnknowG\Atlas\entity\Hook;
use UnknowG\Atlas\events\entity\PlayerDamage;
use UnknowG\Atlas\events\entity\PlayerFastRespawn;
use UnknowG\Atlas\events\entity\ShootBow;
use UnknowG\Atlas\events\npc\NPCAtions;
use UnknowG\Atlas\events\npc\NPCTraining;
use UnknowG\Atlas\events\player\CPS;
use UnknowG\Atlas\events\player\MorePlayerJoin;
use UnknowG\Atlas\events\player\chat\PlayerChat;
use UnknowG\Atlas\events\player\PlayerDrop;
use UnknowG\Atlas\events\player\PlayerExhaust;
use UnknowG\Atlas\events\player\PlayerJoin;
use UnknowG\Atlas\events\player\PlayerMove;
use UnknowG\Atlas\events\player\PlayerQuit;
use UnknowG\Atlas\events\player\PlayerStaffUse;
use UnknowG\Atlas\events\player\PlayerTap;
use UnknowG\Atlas\events\player\PlayerUse;
use UnknowG\Atlas\events\Uncrafter;
use UnknowG\Atlas\hikabrain\EventListener;
use UnknowG\Atlas\hikabrain\manager\Game;
use UnknowG\Atlas\hikabrain\manager\Team;
use UnknowG\Atlas\items\Rod;
use UnknowG\Atlas\mgr\PlayerProtectManager;
use UnknowG\Atlas\pets\task\PetsTask;
use UnknowG\Atlas\task\AtlasLobbyPlayers;
use UnknowG\Atlas\task\CombatCheckTask;
use UnknowG\Atlas\task\RestarterTask;
use UnknowG\Atlas\task\TimeNightTask;
use UnknowG\Atlas\task\util\ConnectedsPlayerUpdateTask;
use UnknowG\Atlas\task\util\texts\DiscordTextTask;

class Atlas extends PluginBase implements Listener
{
    private $clicks;
    public static $instance;

    public function onEnable()
    {
        self::$instance = $this;
        self::updateMotd();
        self::unloadCommands();

        /** Player Events **/
        $this->getServer()->getPluginManager()->registerEvents(new PlayerJoin($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new MorePlayerJoin(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerQuit(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerMove(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerChat($this), $this);
        // $this->getServer()->getPluginManager()->registerEvents(new PlayerDeath($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerFastRespawn($this),$this);

        $this->getServer()->getPluginManager()->registerEvents(new PlayerTap(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerExhaust(), $this);

        $this->getServer()->getPluginManager()->registerEvents(new PlayerUse($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerStaffUse(), $this);

        $this->getServer()->getPluginManager()->registerEvents(new PlayerDrop(), $this);

        $this->getServer()->getPluginManager()->registerEvents(new ShootBow(), $this);

        $this->getServer()->getPluginManager()->registerEvents(new NPCTraining(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new NPCAtions(), $this);

        $this->getServer()->getPluginManager()->registerEvents(new BlockPlace($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new BlockUpdate($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new BlockBreak($this), $this);

        $this->getServer()->getPluginManager()->registerEvents(new PlayerDamage($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new CPS($this), $this);

        $this->getServer()->getPluginManager()->registerEvents(new Uncrafter(), $this);

        /** HIKABRAIN **/
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this,Game::getGame()), $this);
        $this->getServer()->getPluginManager()->registerEvents(new \UnknowG\Atlas\hikabrain\PlayerChat(), $this);

        Team::getTeam()->defaultWFile("hika1");
        Team::getTeam()->defaultWFile("hika2");
        Team::getTeam()->defaultWFile("hika3");
        Team::getTeam()->defaultWFile("hika4");
        Team::getTeam()->defaultWFile("hikaOriginal");

        /** Tasks */
        $this->getScheduler()->scheduleDelayedTask(new DiscordTextTask($this), 20 * 350);
        $this->getScheduler()->scheduleDelayedTask(new RestarterTask(), 20);
        $this->getScheduler()->scheduleRepeatingTask(new TimeNightTask($this), 20 * 30);
        $this->getScheduler()->scheduleRepeatingTask(new CombatCheckTask(), 20);
        $this->getScheduler()->scheduleRepeatingTask(new PetsTask($this), 1);
        $this->getScheduler()->scheduleRepeatingTask(new AtlasLobbyPlayers(), 20 * 10);
        // $this->getScheduler()->scheduleRepeatingTask(new EditCreeperNames(), 20 * 50);

        if($this->getServer()->getPort() == 19133){
            $this->getScheduler()->scheduleRepeatingTask(new ConnectedsPlayerUpdateTask(), 20 * 10);
        }

        Entity::registerEntity(Agent::class,true);
        Entity::registerEntity(Fox::class,true);
        Entity::registerEntity(Endermite::class,true);
        Entity::registerEntity(Creeper::class,true);

        ItemFactory::registerItem(new Rod(), true);
        Entity::registerEntity(Hook::class, false, ["FishingHook", "minecraft:fishinghook"]);

        /** Commands */
        $this->getServer()->getCommandMap()->registerAll("AtlasCommands", [
            new LangCommand("lang", "Choose your language", "lang"),
            new RulesCommand("rules", "The rules of this server !", "rules"),

            new GamesCommand("games", "Choose your game mode", "games"),

            new LobbyCommand("lobby", "Telelport to hub", "lobby", ["hub", "spawn"]),
            new PingCommand("ping", "Look the ping of a player, or you", "ping"),
            // new SkinsCommand("skins", "Look the ping of a player, or you", "skins"),

            new LeagueCommand("league", "Show your points league", "league"),
            new CoinsCommand("coins", "Show your coins", "coins"),
            new ParticlesCommand("particles", "List of your particles", "particles"),
            new StatsCommand("stats", "Show your stats", "stats"),
            new DescriptionCommand("description", "Edit your player description, visible on &stats in discord !", "description"),

            new VoteCommand("vote", "Vote for have a reward", "vote"),
            new HeadPriceCommand("headprice", "Set a price to a head !", "headprice", ["hp", "pricehead"]),

            new CapesCommand("capes", "Add a style in your skin", "capes"),
            new PetsCommand("pets", "Grab a pets and show your style !", "pets"),

            new ResetCommand("reset", "Reset all data in your player table !", "reset"),

            /** NPC */
            new SpawnNPCCommand("npc", "/npc (ourson/astro) spawn", "npc"),

            /** YouTube */
            new NickCommand("nick", "Choose your tag", "nick"),
            new SkinCommand("skin", "Choose a skin from players", "skin"),

            /** Premium */
            new ScaleCommand("scale", "Change your height !", "scale"),
            new SayCommand("say", "Highlight your message !", "say"),

            /** Only Console */
            new ConsoleReward("rewards", "Upgrade a Player [CONSOLE]", "rewards"),
            new ConsoleSave("save", "Save all worlds [CONSOLE]", "save"),

            /** Utils */
            new TellCommand("tell", "Send a private message to a player", "tell",["msg","w"]),
            new ListCommand("list", "Show the list of players in the server !", "list"),
            new AboutCommand("about", "Show the about !", "about"),

            new AnnounceCommand("announce", "Show a message !", "announce"),
            new VanishCommand($this,"vanish", "Hide you to other players !", "vanish"),

            new UnbanCommand("pardon", "Unban a player", "apardon"),
            new UnmuteCommand("unmute", "Unmute a player", "aunmute"),

            new BanCommand("ban", "Ban a player", "aban"),
            new TeleportCommand("tp", "Teleport you to a player", "tp"),
            new BanNotConnectedCommand("banc", "Ban a player not connected", "abanc"),

            new KickCommand("kick", "Kick a player", "akick"),
            new MuteCommand("mute", "Mute a player", "amute"),

            new GamemodeCommand("gamemode", "Change your gamemode", "gamemode", ["gm", "g"]),

            /** Manager */
            new \UnknowG\Atlas\commands\staff\manager\CoinsCommand("setcoins", "Manage the coins of an player", "setcoins"),
            new PointsCommand("setpoints", "Manage the points of an player", "setpoints"),
            new RankCommand("setrank", "Manage the rank of an player", "setrank"),
            new SubRankCommand("setsubrank", "Manage the subrank of an player", "setsubrank"),
            new FloatingTextCommand("ft", "Manage the floatings text", "ft"),

            /** Owner */
            new SkinConverterCommand("skinconverter", "Convert a player skin to a pnj file data", "skinconverter"),
            new CapeConverterCommand("capeconverter", "Convert a player cape to a pnj file data", "skinconverter"),
        ]);

        $this->getServer()->loadLevel("gapple");
        $level = $this->getServer()->getLevelByName("gapple");

        $position = [
            new Vector3(-39, 8, -191),
            new Vector3(-35, 10, -187),
            new Vector3(-34, 10, -186),
            new Vector3(-34, 9, -186),
            new Vector3(-26, 8, -184),
            new Vector3(-8, 7, -204),
            new Vector3(-9, 8, -199),
            new Vector3(-6, 8, -144),
            new Vector3(-6, 7, -144),
            new Vector3(-5, 7, -143),
            new Vector3(-11, 8, -137),
            new Vector3(-17, 8, -130),
            new Vector3(-24, 10, -127),
            new Vector3(-24, 8, -119),
            new Vector3(-75, 6, -124),
            new Vector3(-101, 6, -165),
            new Vector3(-108, 7, -171),
            new Vector3(-112, 7, -170),
            new Vector3(-85, 10, -193)
        ];

        foreach ($position as $pos) {
            $level->setBlock($pos, Block::get(14, 0));
        }

        $worlds = ["arenas","bow","nodebuff","gravity","train1","train2","train3","train4","train5","arena1","arena2","arena3","arena4","arena5","stick","ninja","sumo","combo","builduhc","hika1","hika2","hika3","hika4","hikaOriginal"];

        foreach ($worlds as $worldName) {
            $this->getServer()->loadLevel($worldName);
        }

        Game::getGame()->deleteGame("hika1");
        Game::getGame()->deleteGame("hika2");
        Game::getGame()->deleteGame("hika3");
        Game::getGame()->deleteGame("hika4");
        Game::getGame()->deleteGame("hikaOriginal");
        $this->resetUHC();
        $this->resetHIKA1();
        $this->resetHIKA4();
        $this->resetHIKAOriginal();
    }

    public function resetHIKA1(){
        $level = Server::getInstance()->getLevelByName("hika1");
        Atlas::getInstance()->getServer()->unloadLevel($level);
        rename($this->getServer()->getDataPath() . "worlds/hika1","deleteHika1");
        $array = [
            $this->getServer()->getDataPath() . "deleteHika1/region",
            $this->getServer()->getDataPath() . "deleteHika1"
        ];

        foreach ($array as $folder) {
            $files = glob($folder . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    $this->getServer()->getLogger()->alert("§e[FILE] §6Delete: $file in $folder");
                    unlink($file);
                }
            }
        }

        foreach ($array as $folder) {
            $this->getServer()->getLogger()->alert("§e[FOLDER] §6Delete: $folder");
            rmdir($folder);
        }

        $src = $this->getServer()->getDataPath() . "worldsForRestart/hika1";
        $dest = $this->getServer()->getDataPath() . "worlds/";

        shell_exec("cp -r $src $dest");
        $this->getServer()->getLogger()->alert("§e[COPY] §6Folder $src copied to $dest");
        Atlas::getInstance()->getServer()->loadLevel("hika1");
    }

    public function resetHIKA2(){
        $level = Server::getInstance()->getLevelByName("hika2");
        Atlas::getInstance()->getServer()->unloadLevel($level);
        rename($this->getServer()->getDataPath() . "worlds/hika2","deleteHika2");
        $array = [
            $this->getServer()->getDataPath() . "deleteHika2/region",
            $this->getServer()->getDataPath() . "deleteHika2"
        ];

        foreach ($array as $folder) {
            $files = glob($folder . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    $this->getServer()->getLogger()->alert("§e[FILE] §6Delete: $file in $folder");
                    unlink($file);
                }
            }
        }

        foreach ($array as $folder) {
            $this->getServer()->getLogger()->alert("§e[FOLDER] §6Delete: $folder");
            rmdir($folder);
        }

        $src = $this->getServer()->getDataPath() . "worldsForRestart/hika2";
        $dest = $this->getServer()->getDataPath() . "worlds/";

        shell_exec("cp -r $src $dest");
        $this->getServer()->getLogger()->alert("§e[COPY] §6Folder $src copied to $dest");
        Atlas::getInstance()->getServer()->loadLevel("hika2");
    }

    public function resetHIKA3(){
        $level = Server::getInstance()->getLevelByName("hika3");
        Atlas::getInstance()->getServer()->unloadLevel($level);
        rename($this->getServer()->getDataPath() . "worlds/hika3","deleteHika3");
        $array = [
            $this->getServer()->getDataPath() . "deleteHika3/region",
            $this->getServer()->getDataPath() . "deleteHika3"
        ];

        foreach ($array as $folder) {
            $files = glob($folder . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    $this->getServer()->getLogger()->alert("§e[FILE] §6Delete: $file in $folder");
                    unlink($file);
                }
            }
        }

        foreach ($array as $folder) {
            $this->getServer()->getLogger()->alert("§e[FOLDER] §6Delete: $folder");
            rmdir($folder);
        }

        $src = $this->getServer()->getDataPath() . "worldsForRestart/hika3";
        $dest = $this->getServer()->getDataPath() . "worlds/";

        shell_exec("cp -r $src $dest");
        $this->getServer()->getLogger()->alert("§e[COPY] §6Folder $src copied to $dest");
        Atlas::getInstance()->getServer()->loadLevel("hika3");
    }

    public function resetHIKA4(){
        $level = Server::getInstance()->getLevelByName("hika4");
        Atlas::getInstance()->getServer()->unloadLevel($level);
        rename($this->getServer()->getDataPath() . "worlds/hika4","deleteHika4");
        $array = [
            $this->getServer()->getDataPath() . "deleteHika4/region",
            $this->getServer()->getDataPath() . "deleteHika4"
        ];

        foreach ($array as $folder) {
            $files = glob($folder . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    $this->getServer()->getLogger()->alert("§e[FILE] §6Delete: $file in $folder");
                    unlink($file);
                }
            }
        }

        foreach ($array as $folder) {
            $this->getServer()->getLogger()->alert("§e[FOLDER] §6Delete: $folder");
            rmdir($folder);
        }

        $src = $this->getServer()->getDataPath() . "worldsForRestart/hika4";
        $dest = $this->getServer()->getDataPath() . "worlds/";

        shell_exec("cp -r $src $dest");
        $this->getServer()->getLogger()->alert("§e[COPY] §6Folder $src copied to $dest");
        Atlas::getInstance()->getServer()->loadLevel("hika4");
    }

    public function resetHIKAOriginal(){
        $level = Server::getInstance()->getLevelByName("hikaOriginal");
        Atlas::getInstance()->getServer()->unloadLevel($level);
        rename($this->getServer()->getDataPath() . "worlds/hikaOriginal","deleteHikaOri");
        $array = [
            $this->getServer()->getDataPath() . "deleteHikaOri/region",
            $this->getServer()->getDataPath() . "deleteHikaOri"
        ];

        foreach ($array as $folder) {
            $files = glob($folder . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    $this->getServer()->getLogger()->alert("§e[FILE] §6Delete: $file in $folder");
                    unlink($file);
                }
            }
        }

        foreach ($array as $folder) {
            $this->getServer()->getLogger()->alert("§e[FOLDER] §6Delete: $folder");
            rmdir($folder);
        }

        $src = $this->getServer()->getDataPath() . "worldsForRestart/hikaOriginal";
        $dest = $this->getServer()->getDataPath() . "worlds/";

        shell_exec("cp -r $src $dest");
        $this->getServer()->getLogger()->alert("§e[COPY] §6Folder $src copied to $dest");
        Atlas::getInstance()->getServer()->loadLevel("hikaOriginal");
    }

    public function resetUHC(){
        rename($this->getServer()->getDataPath() . "worlds/builduhc","deleteUHC");
        $array = [
            $this->getServer()->getDataPath() . "deleteUHC/data/advancements",
            $this->getServer()->getDataPath() . "deleteUHC/data/functions",
            $this->getServer()->getDataPath() . "deleteUHC/DIM1/##MCEDIT.TEMP##",
            $this->getServer()->getDataPath() . "deleteUHC/DIM1/##MCEDIT.TEMP2##",
            $this->getServer()->getDataPath() . "deleteUHC/DIM1/playerdata",
            $this->getServer()->getDataPath() . "deleteUHC/DIM1",
            $this->getServer()->getDataPath() . "deleteUHC/DIM-1/##MCEDIT.TEMP##",
            $this->getServer()->getDataPath() . "deleteUHC/DIM-1/##MCEDIT.TEMP2##",
            $this->getServer()->getDataPath() . "deleteUHC/DIM-1/playerdata",
            $this->getServer()->getDataPath() . "deleteUHC/DIM-1",
            $this->getServer()->getDataPath() . "deleteUHC/data",
            $this->getServer()->getDataPath() . "deleteUHC/playerdata",
            $this->getServer()->getDataPath() . "deleteUHC/region",
            $this->getServer()->getDataPath() . "deleteUHC"
        ];

        foreach ($array as $folder) {
            $files = glob($folder . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    $this->getServer()->getLogger()->alert("§e[FILE] §6Delete: $file in $folder");
                    unlink($file);
                }
            }
        }

        foreach ($array as $folder) {
            $this->getServer()->getLogger()->alert("§e[FOLDER] §6Delete: $folder");
            rmdir($folder);
        }

        $src = $this->getServer()->getDataPath() . "worldsForRestart/builduhc";
        $dest = $this->getServer()->getDataPath() . "worlds/";

        shell_exec("cp -r $src $dest");
        $this->getServer()->getLogger()->alert("§e[COPY] §6Folder $src copied to $dest");
    }

    public function onDisable()
    {
        foreach (Server::getInstance()->getLevels() as $level){
            $level->save(true);
        }


        foreach (Server::getInstance()->getOnlinePlayers() as $p) {
            SQLData::setData($p,"players","playerStatus",0);
            if(PlayerProtectManager::isIn($p)){
                PlayerProtectManager::delIn($p);
                $p->transfer("rv-shock.net", Server::getInstance()->getPort());
            }else{
                $p->transfer("rv-shock.net", Server::getInstance()->getPort());
            }
        }
    }

    public static function getInstance(): Atlas
    {
        return self::$instance;
    }

    public static function getImageFile(string $filename)
    {
        return Atlas::getInstance()->getDataFolder() . "Capes/" . $filename . ".png";
    }

    public static function getPngFile(string $filename)
    {
        return Atlas::getInstance()->getDataFolder() . "imgs/" . $filename . ".png";
    }

    public static function getPngForFormsFile(string $filename)
    {
        return Atlas::getInstance()->getDataFolder() . "textures/" . $filename . ".png";
    }
    public static function getJsonFile(string $filename)
    {
        return Atlas::getInstance()->getDataFolder() . "imgs/" . $filename . ".json";
    }

    public static function getFileData(string $filename){
        return $filename = new Config(Atlas::getInstance()->getDataFolder() . $filename . ".yml", Config::YAML);
    }

    public static function getHikabrainFileData(string $filename){
        return $filename = new Config(Atlas::getInstance()->getDataFolder() . $filename . ".yml", Config::YAML);
    }

    public static function updateMotd()
    {
        if (SQLData::getServerData("whitelist") == 1) {
            Server::getInstance()->getNetwork()->setName("§cServer is Whitelisted");
        } elseif (SQLData::getServerData("whitelist") == 2) {
            Server::getInstance()->getNetwork()->setName("§cServer is global whitelisted");
        } else {
            Server::getInstance()->getNetwork()->setName("§3NEWS MODES: §lSUMO §r&§l §3§lNINJA");
        }
    }

    public function unloadCommands()
    {
        $commands = [
            "clone",
            "stop",
            "suicide",
            "mixer",
            "help",
            "?",
            "gc",
            "difficulty",
            "enchant",
            "me",
            "trade"
        ];

        $map = Server::getInstance()->getCommandMap();
        foreach ($commands as $cmd) {
            $command = $map->getCommand($cmd);
            if ($command !== null) {
                $command->setLabel("old_" . $cmd);
                $map->unregister($command);
            }
        }
    }

    public function getCPS(Player $player): int
    {
        if (!isset($this->clicks[$player->getLowerCaseName()])) {
            return 0;
        }
        $time = $this->clicks[$player->getLowerCaseName()][0];
        $clicks = $this->clicks[$player->getLowerCaseName()][1];
        if ($time !== time()) {
            unset($this->clicks[$player->getLowerCaseName()]);
            return 0;
        }
        return $clicks;
    }

    public function addCPS(Player $player): void
    {
        if (!isset($this->clicks[$player->getLowerCaseName()])) {
            $this->clicks[$player->getLowerCaseName()] = [time(), 0];
        }
        $time = $this->clicks[$player->getLowerCaseName()][0];
        $clicks = $this->clicks[$player->getLowerCaseName()][1];
        if ($time !== time()) {
            $time = time();
            $clicks = 0;
        }
        $clicks++;
        $this->clicks[$player->getLowerCaseName()] = [$time, $clicks];
    }

    public function pngToData($file)
    {
        $image = imagecreatefrompng($file);
        $width = imagesx($image);
        $height = imagesy($image);
        $skinData = "";
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $rgba = imagecolorat($image, $x, $y);
                $a = (127 - (($rgba >> 24) & 0x7F)) * 2;
                $r = ($rgba >> 16) & 0xff;
                $g = ($rgba >> 8) & 0xff;
                $b = $rgba & 0xff;
                $skinData .= chr($r) . chr($g) . chr($b) . chr($a);
            }
        }
        return $skinData;
    }

}