<?php
session_start();
error_reporting(0);
include('includes/config.php');
require('fpdf/fpdf.php'); // Incluir la biblioteca FPDF

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['issue'])) {
        $studentname = $_POST['studentname'];
        $nombre = $_POST['nombre'];
        $horaEmision = $_POST['horaEmision'];
        $horaRegreso = $_POST['horaRegreso'];
        
        // Obtener el último ID insertado
        $sql = "SELECT MAX(id) as maxId FROM tblissuedbookdetails";
        $query = $dbh->prepare($sql);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $lastInsertId = $result['maxId'];

        // Incrementar el ID para el nuevo registro
        $newId = $lastInsertId + 1;

        // Actualizar la tabla de cantidad restando uno
        $updateSql = "UPDATE libros SET cantidad = cantidad - 1 WHERE nombre = :nombre";
        $updateQuery = $dbh->prepare($updateSql);
        $updateQuery->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $updateQuery->execute();

        $sql = "INSERT INTO tblissuedbookdetails(id, studentname, nombre, horaEmision, horaRegreso) VALUES(:id, :studentname, :nombre, :horaEmision, :horaRegreso)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $newId, PDO::PARAM_INT);
        $query->bindParam(':studentname', $studentname, PDO::PARAM_STR);
        $query->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $query->bindParam(':horaEmision', $horaEmision, PDO::PARAM_STR);
        $query->bindParam(':horaRegreso', $horaRegreso, PDO::PARAM_STR);
        

        $query->execute();
        $rowCount = $query->rowCount();
        if ($rowCount > 0) {
            $_SESSION['msg'] = "Libro emitido exitosamente";

            // Crear el PDF con la información
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 10, 'Información de emisión del libro', 0, 1, 'C');
            $pdf->Ln(10);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(40, 10, 'Nombre del estudiante:', 0, 0);
            $pdf->Cell(0, 10, $studentname, 0, 1);
            $pdf->Cell(40, 10, 'Nombre del libro:', 0, 0);
            $pdf->Cell(0, 10, $nombre, 0, 1);
            $pdf->Cell(40, 10, 'Fecha y hora de emisión:', 0, 0);
            $pdf->Cell(0, 10, $emision, 0, 1);
            $pdf->Cell(40, 10, 'Fecha y hora de regreso:', 0, 0);
            $pdf->Cell(0, 10, $regreso, 0, 1);
            
            // Generar un ID único para el reporte PDF
            $reportId = uniqid();


            // Generar un nombre único para el archivo PDF
            $filename = __DIR__ . '/reportes/emision_libro_' . uniqid() . '.pdf';

            // Guardar el PDF en un archivo en el servidor
            $pdf->Output('F', $filename);

            $_SESSION['filename'] = $filename; // Guardar el nombre del archivo en la sesión

            echo "<script>";
            echo "window.open('view-pdf.php', '_blank');"; // Abrir el archivo PDF en una nueva ventana
            echo "window.location.href = 'manage-issued-books.php';"; // Redirigir a la página manage-issued-books.php
            echo "</script>";
            exit;
        } else {
            $_SESSION['error'] = "Algo salió mal. Por favor, inténtelo de nuevo";
            header('location:manage-issued-books.php');
        }
    }
}
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    


<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SIOB | Emitir un nuevo libro</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style type="text/css">
        .others {
            color: red;
        }
    </style>
</head>

<body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Emitir un nuevo libro</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Emitir un nuevo libro
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post">
                                <div class="form-group">
                                    <label>Nombre del estudiante<span style="color:red;">*</span></label>
                                    <select class="form-control" name="studentname" id="studentname" required>
                                        <option value="">Seleccione un nombre</option>
                                        <?php
                                        // Obtener los nombres de la tabla tblstudent
                                        $sql = "SELECT FullName FROM tblstudents";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $studentNames = $query->fetchAll(PDO::FETCH_COLUMN);

                                        foreach ($studentNames as $name) {
                                            echo "<option value=\"$name\">$name</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Nombre del libro<span style="color:red;">*</span></label>
                                    <select class="form-control" name="nombre" id="nombre" required>
                                        <option value="">Seleccione un libro</option>
                                        <?php
                                        // Obtener los nombres de la tabla libros
                                        $sql = "SELECT nombre FROM libros";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $libroNames = $query->fetchAll(PDO::FETCH_COLUMN);

                                        foreach ($libroNames as $name) {
                                            echo "<option value=\"$name\">$name</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
    <label>Fecha y hora de emisión<span style="color:red;">*</span></label>
    <input class="form-control" type="datetime-local" name="horaEmision" required>
</div>
<div class="form-group">
    <label>Fecha y hora de regreso<span style="color:red;">*</span></label>
    <input class="form-control" type="datetime-local" name="horaRegreso" required>
</div>
<div class="form-group">
                                    <label>Cantidad</label>
                                    <input class="form-control" type="text" name="cantidad" id="cantidad" readonly>
                                </div>
                                <button type="submit" name="issue" id="submit" class="btn btn-info">Emitir libro</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <script>
        // Llamada AJAX para obtener la cantidad vinculada al libro seleccionado
        $(document).ready(function() {
            $('#nombre').change(function() {
                var libro = $(this).val();
                $.ajax({
                    url: 'get-cantidad.php',
                    type: 'post',
                    data: {
                        libro: libro
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#cantidad').val(response.cantidad);
                    }
                });
            });
        });
    </script>

   <!-- CONTENT-WRAPPER SECTION END-->
   <?php include('includes/footer.php');?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
