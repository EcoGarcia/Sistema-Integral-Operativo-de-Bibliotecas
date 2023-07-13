<?php
include("includes/config.php");

if (isset($_POST['categoria_id'])) {
    $categoria_id = $_POST['categoria_id'];

    // Conectarse a la base de datos
    $conn = mysqli_connect('localhost','root', '','library');

    // Verificar la conexión
    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // Verificar la conexión
    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // Eliminar la categoría
    $query = "DELETE FROM tblcategory WHERE id = '$categoria_id'";
    $result = mysqli_query($conn, $query);

    // Verificar si la eliminación fue exitosa
    if ($result) {
        // Redireccionar a cards.php con mensaje de éxito
        header("Location: cards.php?mensaje=La categoría ha sido eliminada exitosamente.");
        exit(); // Terminar el script para evitar que se siga ejecutando después de la redirección
    } else {
        echo "Ocurrió un error al eliminar la categoría: " . mysqli_error($conn);
    }

    // Cerrar la conexión
    mysqli_close($conn);
}
?>
