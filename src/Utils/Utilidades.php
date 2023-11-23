<?php
namespace App\Utils;

use App\Db\Autores;
use App\Db\Libros;

const MAY_ON=100;
const MAY_OFF=200;
class Utilidades{
    public static array $tiposImagen = [
        'image/gif',
        'image/png',
        'image/jpeg',
        'image/bmp',
        'image/webp',
        'image/x-icon',
        'image/svg+xml'
    ];
    public static function pintarErrores(string $nombre){
        if(isset($_SESSION[$nombre])){
            echo "<p class='text-red-600 mt-2 italic text-sm'>{$_SESSION[$nombre]}</p>";
            unset($_SESSION[$nombre]);
        }
    }
    public static function sanearCadenas(string $cad, $mode=MAY_OFF): string{
        return ($mode==MAY_ON) ? ucfirst(htmlspecialchars(trim($cad))) :
        htmlspecialchars(trim($cad));
    }
    public static function isCadenaValida($nombre, $valor, $long): bool{
        if(strlen($valor)<$long){
            $_SESSION[$nombre]="*** Error el campo $nombre no puede tener menos de $long carcateres";
            return false;
        }
        return true;
    }

    public static function existeTitulo(string $titulo): bool{
        if(Libros::hayLibros($titulo)){
            $_SESSION['Titulo']="*** Este título ya existe en nuestros registros";
            return true;
        }
        return false;
    }
    public static function existeTituloUpdate(string $titulo, int $id): bool{
        if(Libros::hayLibrosUpdate($titulo, $id)){
            $_SESSION['Titulo']="*** Este título ya existe en nuestros registros";
            return true;
        }
        return false;
        
    }

    public static function isAutorValido(int $id): bool{
        if(Autores::existeIdAutor($id)) return true;
        $_SESSION['Autor_id']="*** El autor NO es válido o no selecciono ninguno";
        return false; 
    }

    public static function isImagenValida(string $type, int $size){
        if(!in_array($type, self::$tiposImagen)){
            $_SESSION['Portada']="*** La portada subida NO se corresponde con un a imagen";
            return false;
        }
        if($size>2000000){
            $_SESSION['Portada']="*** La portada excede los 2MB permitidos";
            return false;
        }
        return true;
    }
}