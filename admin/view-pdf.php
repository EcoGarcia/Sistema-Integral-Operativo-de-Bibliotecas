<?php
session_start();

if (isset($_SESSION['filename']) && isset($_SESSION['id'])) {
    $filename = $_SESSION['filename'];
    $id = $_SESSION['id'];

    if (file_exists($filename)) {
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        readfile($filename);

        // Actualizar la tabla con el ID del reporte generado
        include('includes/config.php');
        $sql = "UPDATE tblissuedbookdetails SET report_id = :id WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
    } else {
        echo "El archivo PDF no existe.";
    }

    // Eliminar las variables de sesión
    unset($_SESSION['filename']);
    unset($_SESSION['id']);
} else {
    echo "No se encontró ningún archivo PDF.";
}
?>
