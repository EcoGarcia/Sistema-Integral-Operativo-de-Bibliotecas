<?php
include("includes/config.php");

if (isset($_POST['guardar'])) {
    $numero = $_POST['numero'];
    $nombre = $_POST['nombre'];
    $autor = $_POST['autor'];
    $categoria = $_POST['categoria'];
    $isbn = $_POST['isbn'];
    $editorial = $_POST['editorial'];
    $cantidad = $_POST['cantidad'];
    $colocación = $_POST['colocación'];
    $edición = $_POST['edición'];
    $fecha = $_POST['fecha'];
    $num = $_POST['num'];


    // Portada
    $portada = $_FILES['portada']['name'];
    $portada_temp = $_FILES['portada']['tmp_name'];
    $destino = "portadas/" . $portada;
    move_uploaded_file($portada_temp, $destino);

    // Conectarse a la base de datos (reemplaza con tus propios detalles)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "library";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Comprobar la conexión
    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // Insertar los datos en la tabla libros 
    $query = "INSERT INTO libros (numero, nombre, portada, autor, categoria, isbn, cantidad, editorial, colocación, edición, fecha, num) VALUES ('$numero', '$nombre', '$destino', '$autor', '$categoria', '$isbn', '$cantidad', '$editorial', '$colocación', '$edición', '$fecha', '$num')";
    $result = mysqli_query($conn, $query);

    // Verificar si la inserción fue exitosa
    if ($result) {
        $_SESSION['mensaje'] = 'Libro agregado';
        $_SESSION['mensaje_type'] = 'success';
        header("Location: libros.php");
        exit;
    } else {
        $_SESSION['mensaje'] = 'Error al agregar el libro: ' . mysqli_error($conn);
        $_SESSION['mensaje_type'] = 'danger';
        header("Location: libros.php");
        exit;
    }

    // Cerrar la conexión
    mysqli_close($conn);
}
?>
