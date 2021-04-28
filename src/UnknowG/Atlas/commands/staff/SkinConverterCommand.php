<?php

namespace UnknowG\Atlas\commands\staff;

use Exception;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use UnknowG\Atlas\api\LibSkin;
use UnknowG\Atlas\api\RankAPI;
use UnknowG\Atlas\Atlas;
use UnknowG\Atlas\utils\texts\Texts;

class SkinConverterCommand extends Command{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if($player instanceof Player){
            if(RankAPI::getIDRank($player) == "fonda") {
                $pseudo = $player->getServer()->getPlayer($args[0]);
                if ($pseudo instanceof Player) {
                    $skin = $pseudo->getSkin();
                    $dataFolder = Atlas::getInstance()->getDataFolder();
                    $path = $dataFolder . DIRECTORY_SEPARATOR . "converted" . DIRECTORY_SEPARATOR . "skins" . DIRECTORY_SEPARATOR . $pseudo->getName();
                    if (!file_exists($path)){
                        mkdir($path);
                    }

                    $file = $path . DIRECTORY_SEPARATOR . $skin->getGeometryName();
                    $geometryData = $skin->getGeometryData();
                    file_put_contents($file . '.json', $geometryData);
                    self::skinDataToImageSave($skin->getSkinData(), $file . '.png');
                }
            }else{
                Texts::returnNotPermission($player);
            }
        }
    }

    public static function skinDataToImage(string $skinData) {
        $size = strlen($skinData);
        LibSkin::validateSize($size);
        $width = LibSkin::SKIN_WIDTH_MAP[$size];
        $height = LibSkin::SKIN_HEIGHT_MAP[$size];
        $skinPos = 0;
        $image = imagecreatetruecolor($width, $height);
        if ($image === false) {
            throw new Exception("Couldn't create image");
        }

        imagefill($image, 0, 0, imagecolorallocatealpha($image, 0, 0, 0, 127));
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $r = ord($skinData[$skinPos]);
                $skinPos++;
                $g = ord($skinData[$skinPos]);
                $skinPos++;
                $b = ord($skinData[$skinPos]);
                $skinPos++;
                $a = 127 - intdiv(ord($skinData[$skinPos]), 2);
                $skinPos++;
                $col = imagecolorallocatealpha($image, $r, $g, $b, $a);
                imagesetpixel($image, $x, $y, $col);
            }
        }
        imagesavealpha($image, true);
        return $image;
    }

    public static function skinDataToImageSave(string $skinData, string $savePath) {
        $image = self::skinDataToImage($skinData);
        imagepng($image, $savePath);
        imagedestroy($image);
    }
}