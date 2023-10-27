<?php
include('includes/config.php');

if (isset($_POST['libro'])) {
    $libro = $_POST['libro'];

    try {
        // Obtener la cantidad asociada al libro seleccionado
        $sql = "SELECT cantidad FROM libros WHERE nombre = :libro";
        $query = $dbh->prepare($sql);
        $query->bindParam(':libro', $libro, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $cantidad = $result['cantidad'];

            // Devolver la cantidad en formato JSON
            echo json_encode(['cantidad' => $cantidad]);
        } else {
            echo json_encode(['cantidad' => 'No disponible']);
        }
    } catch (PDOException $e) {
        // Manejo de errores de la base de datos
        echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
    }
}
?>
