<?php
namespace UnknowG\Atlas\data\sql;

use pocketmine\utils\MainLogger;
use pocketmine\utils\TextFormat;

class MySQL{

    private $host;
    private $users;
    private $password;
    private $name;

    public function __construct(string $host, string $users, string $password, string $name){

        $this->host = $host;
        $this->users = $users;
        $this->password = $password;
        $this->name = $name;

    }

    public function conectSQL(){
        try{
            // MainLogger::getLogger()->info(TextFormat::AQUA . "Tentative de connextion avec la base de donnees !");
            $db = new \MySQLi();
            $db->connect($this->host, $this->users, $this->password, $this->name);
            // MainLogger::getLogger()->info(TextFormat::GREEN . "Connextion etablie avec la base de donnees !");
        }catch (\PDOException $exception){
            MainLogger::getLogger()->info(TextFormat::DARK_RED . "Connection impossible a la base de données ! ");
        }catch (\Exception $e){
            MainLogger::getLogger()->info(TextFormat::DARK_RED . "Connection impossible a la base de données ! ");
        }
        return $db;
    }

    public function connectionSQL(){
        $sql = new self($this->host, $this->users,$this->password,$this->name);
        return $sql->conectSQL();
    }
}