<?php
include('includes/config.php');

if(isset($_POST['guardar-libros'])){
    $nombre = $_POST['nombre-libro'];
    $portada = $_FILES['portada']["name"];
    $ruta = $_FILES['portada']['tmp_name'];
    $destino = "portadas/".$portada;
    copy($ruta, $destino);

    $categoria = $_POST['categoria'];
    $autor = $_POST['autor'];
    $isbn = $_POST['isbn'];

    $query = "INSERT INTO libros(nombre, portada, categoria, autor, isbn) VALUES ('$nombre', '$destino', '$categoria', '$autor', '$isbn')";
    $resultados = mysqli_query($conexion, $query);

    if (!$resultados){
        die("No se pudo");
    }

    header("Location: manage-books.php");
}
?>
