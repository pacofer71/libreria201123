<?php

use App\Db\Autores;
use App\Db\Libros;

require_once __DIR__ . "/../vendor/autoload.php";
Autores::generarAutores(10);
Libros::generarLibros(60);
$libros=Libros::read();
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
    <h3 class="my-2 text-xl text-center">LISTADO DE LIBROS</h3>
    <div class="mx-auto mb-1 flex flex-row-reverse w-3/4">
    <a href="nuevo.php" class="my-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-add mr-2"></i>Nuevo</a>
    </div>
    <!-- TABLA -->
    <div class="mx-auto w-3/4 shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        INFO
                    </th>
                    <th scope="col" class="px-6 py-3">
                        TITULO
                    </th>
                    <th scope="col" class="px-6 py-3">
                        AUTOR
                    </th>                   
                    <th scope="col" class="px-6 py-3">
                        ACCIONES
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($libros as $item){
                    echo <<<TXT
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <a href="detalle.php?idLibro={$item->id}"><i class='fas fa-info text-blue-600'></i></a>
                    </th>
                    <td class="px-6 py-4">
                        {$item->titulo}
                    </td>
                    <td class="px-6 py-4">
                        {$item->apellidos}, {$item->nombre}
                    </td>
                    <td class="px-6 py-4 text-right">
                        Botones
                    </td>
                </tr>
                TXT;
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- FIN DE TABLA -->
</body>

</html>