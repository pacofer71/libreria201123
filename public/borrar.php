<?php

use App\Db\Libros;

if(!isset($_POST['idLibro'])){
    header("Location:index.php");
    die();
}
session_start();
require_once __DIR__."/../vendor/autoload.php";

$id=$_POST['idLibro'];
$libro=Libros::read($id);
if(count($libro)==0){
    header("Location:index.php");
    die();
}
$portada=$libro[0]->portada;  // img/portadas/sdfsdfsdfd.jpg
if(basename($portada)!='default.webp'){
    unlink("./".$portada);
}
Libros::delete($id);
$_SESSION['mensaje']="Se borro el libro.";
header("Location:index.php");
