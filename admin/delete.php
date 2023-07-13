<?php
include("includes/config.php");

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $bookId = $_GET['id'];

    // Obtener la información del libro antes de eliminarlo
    $sql = "SELECT * FROM libros WHERE id = :bookId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':bookId', $bookId, PDO::PARAM_INT);
    $query->execute();
    $book = $query->fetch(PDO::FETCH_ASSOC);

    if ($book) {
        // Eliminar el libro de la base de datos
        $deleteSql = "DELETE FROM libros WHERE id = :bookId";
        $deleteQuery = $dbh->prepare($deleteSql);
        $deleteQuery->bindParam(':bookId', $bookId, PDO::PARAM_INT);
        $deleteQuery->execute();

        // Eliminar la imagen de la carpeta de portadas
        $imagePath = "admin/" . $book['portada'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        echo "<script>alert('Libro eliminado exitosamente');</script>";
    } else {
        echo "<script>alert('No se encontró el libro');</script>";
    }
}

echo "<script>window.location.href='manage-books.php';</script>";
?>
