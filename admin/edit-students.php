<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if(isset($_GET['StudentId'])) {
        $StudentId  = $_GET['StudentId'];        
        // Obtener información del estudiante
        $sql = "SELECT * FROM tblstudents WHERE StudentId =:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':StudentId ', $StudentId , PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result) {
            $studentId = $result['StudentId'];
            $fullName = $result['FullName'];
            $emailId = $result['EmailId'];
            // Otros campos del estudiante
            
            // ... (resto de tu código HTML y formulario para la edición)
        } else {
            echo "Estudiante no encontrado.";
        }
    } else {
        echo "ID de estudiante no proporcionado.";
    }
}
?>
