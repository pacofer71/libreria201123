<?php
namespace App\Db;
use \PDOException;
use \PDO;
class Conexion{
    public static ?PDO $conexion=null;

    public function __construct()
    {
        self::setConexion();
    }

    public static function setConexion(){
        if(self::$conexion!=null) return;
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__."/../../");
        $dotenv->load();
        $usuario=$_ENV['USER'];
        $pass=$_ENV['PASS'];
        $host=$_ENV['SERVER'];
        $db=$_ENV['DB'];

        $dsn="mysql:host=$host;dbname=$db;charset=utf8mb4";
        $opciones=[PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION];
        try{
            self::$conexion=new PDO($dsn, $usuario, $pass, $opciones);
        }catch(PDOException $ex){
            die("Error en conexion: ".$ex->getMessage());
        }

    }

}