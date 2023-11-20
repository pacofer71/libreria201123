<?php

use App\Db\Libros;

require_once __DIR__ . "/../vendor/autoload.php";

if (!isset($_GET['idLibro'])) {
    header("Location:index.php");
    die();
}
$libro = Libros::read($_GET['idLibro']);
//var_dump($libro);
//die();
if (count($libro) == 0) {
    header("Location:index.php");
    die();
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
    <h3 class="my-2 text-xl text-center">DETALLE DE LIBRO</h3>
    <!-- CARD DETALLE -->
    <div class="mx-auto max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <img class="rounded-t-lg" src="<?php echo "./".$libro[0]->portada;  ?>" alt="<?php echo $libro[0]->titulo ?>" />
        <div class="p-5">
            
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?php echo $libro[0]->titulo ?></h5>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"><?php echo $libro[0]->sinopsis ?>.</p>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                <span class="font-bold">Autor: </span><?php echo $libro[0]->apellidos.", ".$libro[0]->nombre ?>.
            </p>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                <span class="font-bold">PAÍS: </span><?php echo $libro[0]->pais; ?>
            </p>
            <a href="index.php" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <i class="fas fa-home mr-2"></i> INICIO
            </a>
        </div>
    </div>

    <!--FIN -->
</body>

</html>