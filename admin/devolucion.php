<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_GET['id']) && isset($_GET['book'])) {
        $id = $_GET['id'];
        $book = urldecode($_GET['book']);

        // Actualizar la tabla tblissuedbookdetails estableciendo la fecha de regreso y el estado
        $sql_update = "UPDATE tblissuedbookdetails SET regreso = :regreso, status = 'Disponible' WHERE id = :id";
        $query_update = $dbh->prepare($sql_update);
        $query_update->bindParam(':regreso', date('Y-m-d'), PDO::PARAM_STR);
        $query_update->bindParam(':id', $id, PDO::PARAM_INT);
        $query_update->execute();

        // Incrementar la cantidad disponible del libro en la tabla libros
        $sql_increment = "UPDATE libros SET cantidad = cantidad + 1 WHERE nombre = :book";
        $query_increment = $dbh->prepare($sql_increment);
        $query_increment->bindParam(':book', $book, PDO::PARAM_STR);
        $query_increment->execute();

        $_SESSION['msg'] = "Devolución confirmada exitosamente";
        header('location:manage-issued-books.php');
    } else {
        $_SESSION['error'] = "Parámetros inválidos";
        header('location:manage-issued-books.php');
    }
}
?>
