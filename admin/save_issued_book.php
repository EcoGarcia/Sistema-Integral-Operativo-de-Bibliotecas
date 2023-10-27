<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['studentname']) && isset($_POST['bookname']) && isset($_POST['issuedate'])) {
        $studentname = $_POST['studentname'];
        $bookname = $_POST['bookname'];
        $issuedate = $_POST['issuedate'];

        // Obtener el ID del libro basado en su nombre
        $sql = "SELECT BookId FROM libros WHERE nombre = :bookname";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bookname', $bookname, PDO::PARAM_STR);
        $query->execute();
        $book = $query->fetch(PDO::FETCH_ASSOC);
        $bookid = $book['BookId'];

        // Insertar datos en la tabla tblissuedbookdetails
        $sql = "INSERT INTO tblissuedbookdetails(studentname, bookname, bookid, issuedate) VALUES(:studentname, :bookname, :bookid, :issuedate)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':studentname', $studentname, PDO::PARAM_STR);
        $query->bindParam(':bookname', $bookname, PDO::PARAM_STR);
        $query->bindParam(':bookid', $bookid, PDO::PARAM_INT);
        $query->bindParam(':issuedate', $issuedate, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();

        if ($lastInsertId) {
            $response['status'] = 'success';
            $response['message'] = 'Book issued successfully';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Something went wrong. Please try again';
        }

        echo json_encode($response);
    }
}
?>
