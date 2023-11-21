<?php
namespace App\Db;
use \PDO;
use \PDOException;
class Libros extends Conexion{
    private int $id;
    private string $titulo;
    private string $portada;
    private string $sinopsis;
    private int $autor_id;

    public function __construct()
    {
        parent::__construct();
    }
    //__________________________ CRUD
    public function create(){
        $q="insert into libros(titulo, portada, sinopsis, autor_id) values(:t, :p, :s, :ai)";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':t'=>$this->titulo,
                ':p'=>$this->portada,
                ':s'=>$this->sinopsis,
                ':ai'=>$this->autor_id,
            ]);
        }catch(PDOException $ex){
            die("Error en create(): ".$ex->getMessage());
        }
        parent::$conexion=null;
    }
    public static function read(?int $id=null): array{
        parent::setConexion();
        $q=($id==null) ? "select libros.*, nombre, apellidos, pais from libros, autores where autores.id=autor_id order by apellidos"
        : "select libros.*, nombre, apellidos, pais from libros, autores where autores.id=autor_id AND libros.id=:i";
        $stmt=parent::$conexion->prepare($q);
        try{
           ($id==null) ? $stmt->execute() : $stmt->execute([':i'=>$id]);
        }catch(PDOException $ex){
            die("Error en read: ".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->fetchAll(PDO::FETCH_OBJ); 
    }

    //__________________________ FAKER________________________________________________________  
    public static function hayLibros(?string $titulo=null):bool{
        parent::setConexion();
        $q=($titulo==null) ? "select id from libros" : "select id from libros where titulo=:t";
        $stmt=parent::$conexion->prepare($q);
        try{
            ($titulo == null) ? $stmt->execute() : $stmt->execute([':t'=>$titulo]);
        }catch(PDOException $ex){
            die("error en hayLibros() ".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->rowCount();
    }
    public static function generarLibros(int $cant){
        if(self::hayLibros()) return;
        $faker=\Faker\Factory::create('es_ES');
        $faker->addProvider(new \Mmo\Faker\PicsumProvider($faker));
        $id_autores=Autores::devolverIdAutores();
        for($i=0; $i<$cant; $i++){
            
            $titulo=ucfirst($faker->unique()->words(random_int(2,4), true));
            $sinopsis=$faker->text();
            $portada="img/portadas/".$faker->picsum("./img/portadas/", 640, 480, false); // img/portadas/234234bs.png
            $autor_id=$faker->randomElement($id_autores)->id;
            
            (new Libros)->setTitulo($titulo)
            ->setSinopsis($sinopsis)
            ->setPortada($portada)
            ->setAutorId($autor_id)
            ->create();
        }
    }

    //_________________________ OTROS METODOS _________________________________________________

    //_________________________ SETTERS _____________________________________________________
    

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of titulo
     */
    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Set the value of portada
     */
    public function setPortada(string $portada): self
    {
        $this->portada = $portada;

        return $this;
    }

    /**
     * Set the value of sinopsis
     */
    public function setSinopsis(string $sinopsis): self
    {
        $this->sinopsis = $sinopsis;

        return $this;
    }

    /**
     * Set the value of autor_id
     */
    public function setAutorId(int $autor_id): self
    {
        $this->autor_id = $autor_id;

        return $this;
    }
}