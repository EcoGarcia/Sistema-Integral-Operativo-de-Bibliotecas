<?php
if (isset($_POST['libro_id']) && isset($_POST['fecha_pedido']) && isset($_POST['fecha_devolucion'])) {
    $libro_id = $_POST['libro_id'];
    $fecha_pedido = $_POST['fecha_pedido'];
    $fecha_devolucion = $_POST['fecha_devolucion'];

    // Obtener el nombre del estudiante de la sesión
    session_start();
    $nombreEstudiante = $_SESSION['login']; // Cambiar 'stdname' a 'login'

    // Conectar a la base de datos (reemplaza con tus propios detalles)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "library";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Comprobar la conexión
    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // Insertar la información del préstamo en la tabla "prestamos" y obtener el ID del préstamo
    $insert_prestamo_query = "INSERT INTO prestamos (libro_id, fecha_pedido, fecha_devolucion, estudiante) VALUES ('$libro_id', '$fecha_pedido', '$fecha_devolucion', '$nombreEstudiante')";
    if (mysqli_query($conn, $insert_prestamo_query)) {
        // Obtener el ID del préstamo recién insertado
        $id_prestamo = mysqli_insert_id($conn);
        
        // La información del préstamo se guardó correctamente en la tabla "prestamos"
        echo "Solicitud de préstamo enviada con éxito. ID del préstamo: $id_prestamo";
    } else {
        // Hubo un error al guardar la información del préstamo
        echo "Error al enviar la solicitud: " . mysqli_error($conn);
    }

    // Cerrar la conexión
    mysqli_close($conn);
} else {
    echo "Faltan datos para procesar la solicitud.";
}
?>
