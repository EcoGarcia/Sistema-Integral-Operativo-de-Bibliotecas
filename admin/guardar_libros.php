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
    $estado = $_POST['estado'];
    $fecha = $_POST['fecha'];
    $num = $_POST['num'];

    // Portada
    $portada = $_FILES['portada']['name'];
    $portada_temp = $_FILES['portada']['tmp_name'];
    $destino = "../portadas/" . $portada;
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

    // Obtener la última ID de libro
    $get_last_id_query = "SELECT MAX(id) AS last_id FROM libros";
    $result_last_id = mysqli_query($conn, $get_last_id_query);
    $row_last_id = mysqli_fetch_assoc($result_last_id);
    $last_id = $row_last_id['last_id'];

    // Incrementar la última ID según la cantidad de libros
    $new_id = $last_id + 1;

    // Insertar los datos en la tabla libros
    $query = "INSERT INTO libros (id, numero, nombre, portada, autor, categoria, isbn, cantidad, editorial, colocación, edición, estado, fecha, num) VALUES ('$new_id', '$numero', '$nombre', '$destino', '$autor', '$categoria', '$isbn', '$cantidad', '$editorial', '$colocación', '$edición', '$estado', '$fecha', '$num')";
    $result = mysqli_query($conn, $query);

    // Verificar si la inserción fue exitosa
    if ($result) {
        $_SESSION['mensaje'] = 'Libro agregado';
        $_SESSION['mensaje_type'] = 'success';
        // Redireccionar a libros.php con la categoría como parámetro
        header("Location: libros.php?categoria=" . urlencode($categoria));
        exit;
    } else {
        $_SESSION['mensaje'] = 'Error al agregar el libro: ' . mysqli_error($conn);
        $_SESSION['mensaje_type'] = 'danger';
    }

    // Cerrar la conexión
    mysqli_close($conn);
    if (!$resultados){
        die("No se pudo");
    }

    header("Location: libros.php");
}
?>
