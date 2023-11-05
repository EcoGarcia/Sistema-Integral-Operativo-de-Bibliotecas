<!-- conectandose a la base de datos -->
<?php
session_start();
include('includes/config.php');

?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>SIOB | Registro de administradores</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>

<body>
    <?php include('includes/header.php'); ?>

    <div class="col-md-8">
        <table class="table table-bordered">
            <thead>
                <tr>Nombre</tr>
                <tr>Correo</tr>
                <tr>Contraseña</tr>
            </thead>
            <tbody>
                <?php 
                // Mostrar la tabla
                $query = "SELECT * FROM tbladmin";
                // llamando a la conexion
                $resultado = mysqli_query($conexion, $query);

                while ($fila=mysqli_fetch_array($resultado)){ ?>

                <tr>
                    <td><?php echo $fila['FullName'] ?></td>
                    <td><?php echo $fila['EmailId'] ?></td>
                </tr>



                <?php } ?>

            </tbody>


        </table>

    </div>

    





     <!-- CONTENT-WRAPPER SECTION END-->
     <?php include('includes/footer.php'); ?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>