<?php
if(!isset($_GET['id'])){
    header("Location:index.php");
    die();
}

$id=$_GET['id'];

use App\Db\Autores;
use App\Db\Libros;
use App\Utils\Utilidades;

require_once __DIR__ . "/../vendor/autoload.php";
$libro=Libros::read($id);
if(count($libro)==0){
    header("Location:index.php");
    die();
}


use const App\Utils\MAY_ON;

session_start();


$autores = Autores::read();

if(isset($_POST['btn'])){
    $titulo=Utilidades::sanearCadenas($_POST['titulo'], MAY_ON);
    $sinopsis=Utilidades::sanearCadenas($_POST['sinopsis'], MAY_ON);
    $autor_id=(int)$_POST['autor_id'];

    $errores=false;
    if(!Utilidades::isCadenaValida("Titulo", $titulo, 3)){
        $errores = true;
    }else{
        if(Utilidades::existeTituloUpdate($titulo, $id)){
            $errores=true;
        }
    }

    if(!Utilidades::isCadenaValida("Sinopsis", $sinopsis, 10)){
        $errores = true;
    }
    if(!Utilidades::isAutorValido($autor_id)){
        $errores=true;
    }

    //Procesando Imagen
    $portada=$libro[0]->portada;
    if(is_uploaded_file($_FILES['portada']['tmp_name'])){
        //comprobamos que sea una imagen y no excedea los 2MB
        if(Utilidades::isImagenValida($_FILES['portada']['type'], $_FILES['portada']['size'])){
            //Imagen y tamaño válido procedemos a guardarla
            $portada="img/portadas/".uniqid()."_".$_FILES['portada']['name'];
            if(!move_uploaded_file($_FILES['portada']['tmp_name'], "./$portada")){
                $errores=true;
                $_SESSION['Portada']="** No se pudo mover la imagen al directorio de destino";
            }else{
                //se ya hemos guardado la imagen nueva borramos al antigua si no es la default.webp
                if(basename($libro[0]->portada)!='default.webp'){
                    unlink("./{$libro[0]->portada}");
                }
            }

        }else{
            $errores=true;
        }
    }

    if($errores){
        header("Location:update.php?id=$id");
        die();
    }
    (new Libros)->setTitulo($titulo)
    ->setPortada($portada)
    ->setSinopsis($sinopsis)
    ->setAutorId($autor_id)
    ->update($id);

    $_SESSION['mensaje']="Libro Actualizado";
    header("Location:index.php");


}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind css -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>posts</title>
</head>

<body style="background-color:blanchedalmond">
    <h3 class="my-2 text-xl text-center">ACTUALIZAR LIBRO</h3>
    <div class="w-1/2 mx-auto p-4 bg-gray-300 rounded-xl shadow-xl">
        <form action="update.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="titulo">
                    TITULO
                </label>
                <input value="<?php echo $libro[0]->titulo; ?>"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="titulo" type="text" placeholder="Titulo libro..." name="titulo" />
                <?php
                    Utilidades::pintarErrores('Titulo');
                ?>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="sinopsis">
                    RESUMEN
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="sinopsis" id="sinopsis" placehoder="Resumen del libro..."><?php echo $libro[0]->sinopsis; ?></textarea>
                <?php
                    Utilidades::pintarErrores('Sinopsis');
                ?>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="autor_id">
                    AUTOR
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="autor_id" id="autor_id">
                    <option>_______Selecciona un autor_______</option>
                    <?php
                    foreach ($autores as $item) {
                        $autorLibro=($item->id==$libro[0]->autor_id) ? "selected" : "";
                        echo "<option value='{$item->id}' $autorLibro>{$item->apellidos}, {$item->nombre}</option>";
                    }
                    ?>
                </select>
                <?php
                    Utilidades::pintarErrores('Autor_id');
                ?>
            </div>
            <div class="mb-4 flex justify-between">
                <div class="w-full">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="portada">
                        PORTADA
                    </label>
                    <input type='file' name="portada" id="portada" accept="image/*" oninput="img.src=window.URL.createObjectURL(this.files[0])" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <?php
                    Utilidades::pintarErrores('Portada');
                ?>
                </div>
                <div class="ml-8">
                    <img src="./<?php echo $libro[0]->portada ?>" class="w-60" id="img">
                </div>
            </div>
            <div class="flex flex-row-reverse">
                <button type="submit" class="ml-2 my-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" name="btn"><i class="fas fa-edit mr-2"></i>ACTUALIZAR</button>
                <a href="index.php" class="my-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-home mr-2"></i>VOLVER</a>

            </div>
        </form>
    </div>
</body>

</html>