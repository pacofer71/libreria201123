<?php

use App\Db\Autores;

session_start();
require_once __DIR__ . "/../vendor/autoload.php";
$autores = Autores::read();
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
    <h3 class="my-2 text-xl text-center">CREAR LIBRO</h3>
    <div class="w-1/2 mx-auto p-4 bg-gray-300 rounded-xl shadow-xl">
        <form action="nuevo.php" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="titulo">
                    TITULO
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="titulo" type="text" placeholder="Titulo libro..." name="titulo" />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="sinopsis">
                    RESUMEN
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="sinopsis" id="sinopsis" placehoder="Resumen del libro..."></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="autor_id">
                    AUTOR
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="autor_id" id="autor_id">
                    <option>_______Selecciona un autor_______</option>
                    <?php
                    foreach ($autores as $item) {
                        echo "<option value='{$item->id}'>{$item->apellidos}, {$item->nombre}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-4 flex justify-between">
                <div class="w-full">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="portada">
                        PORTADA
                    </label>
                    <input type='file' name="portada" id="portada" accept="image/*" oninput="img.src=window.URL.createObjectURL(this.files[0])" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">

                </div>
                <div class="ml-8">
                    <img src="./img/portadas/default.webp" class="w-60" id="img">
                </div>
            </div>
            <div class="flex flex-row-reverse">
                <button type="submit" class="my-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" name="btn"><i class="fas fa-save mr-2"></i>GUARDAR</button>
                <button type="reset" class="mx-2 my-2 bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-paintbrush mr-2"></i>LIMPIAR</button>
                <a href="index.php" class="my-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-home mr-2"></i>VOLVER</a>

            </div>
        </form>
    </div>
</body>

</html>