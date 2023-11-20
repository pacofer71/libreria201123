<?php
namespace App\Db;
use \PDO;
use \PDOException;

class Autores extends Conexion{
    private int $id;
    private string $nombre;
    private string $apellidos;
    private string $pais;

    public function __construct()
    {
        parent::__construct();
    }

    //------------------------- CRUD c-----------------------------
    public function create(){
        $q="insert into autores(nombre, apellidos, pais) values(:n, :a, :p)";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':n'=>$this->nombre,
                ':a'=>$this->apellidos,
                ':p'=>$this->pais,
            ]);
        }catch(PDOException $ex){
            die("error en create() ".$ex->getMessage());
        }
        parent::$conexion=null;
    }
    public static function read(): array{
        parent::setConexion();
        $q="select *  from autores order by apellidos";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("error en devolver read ".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    //------------------------ FAKER---------------------------------------------
    private static function hayAutores():bool{
        parent::setConexion();
        $q="select id from autores";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("error en hayAutores() ".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->rowCount();
    }
    public static function generarAutores(int $cant){
        if(self::hayAutores()) return;

        $faker=\Faker\Factory::create('es_ES');
        for($i=0; $i<$cant; $i++){
            $nombre=$faker->firstName();
            $apellidos=$faker->lastName()." ".$faker->lastName();
            $pais=$faker->country();
            
            (new Autores)->setNombre($nombre)

            ->setApellidos($apellidos)
            ->setPais($pais)
            ->create();
        }
    }

    //------------------------Otros metods
    public static function devolverIdAutores(): array{
        parent::setConexion();
        $q="select id from autores";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("error en devolver Id autores() ".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    //-----------------------SETTERS

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Set the value of apellidos
     */
    public function setApellidos(string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Set the value of pais
     */
    public function setPais(string $pais): self
    {
        $this->pais = $pais;

        return $this;
    }
}