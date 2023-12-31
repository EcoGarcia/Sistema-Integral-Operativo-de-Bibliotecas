<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (isset($_POST['signup'])) {
    //code for captach verification  
    //Code for student ID
    $count_my_page = ("studentid.txt");
    $hits = file($count_my_page);
    $hits[0]++;
    $fp = fopen($count_my_page, "w");
    fputs($fp, "$hits[0]");
    fclose($fp);
    $StudentId = $hits[0];
    $fname = $_POST['fullanme'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $status = 1;
    $sql = "INSERT INTO  tbldocentes(docenteid,nombre,email,contrasena,status) VALUES(:StudentId,:fname,:email,:password,:status)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':StudentId', $StudentId, PDO::PARAM_STR);
    $query->bindParam(':fname', $fname, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        echo "<script>alert('Docente agregado con exito');window.location.href='docentes_registrados.php';</script>";
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
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>SIOB | Registro de docentes</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <head>

    <body>
        <!------MENU SECTION START-->
        <?php include('includes/header.php'); ?>

        <div class="content-wrapper">
            <div class="container">
                <div class="row pad-botm">
                    <div class="col-md-12">
                        <h4 class="header-line">Registro de nuevo docente</h4>

                    </div>

                </div>
                <div class="row">

                    <div class="col-md-9 col-md-offset-1">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                FORMULARIO DE REGISTRO
                            </div>
                            <div class="panel-body">
                                <form name="signup" method="post" onSubmit="return valid();">
                                    <div class="form-group">
                                        <label>Ingrese el nombre completo</label>
                                        <input class="form-control" type="text" name="fullanme" autocomplete="off" required />
                                    </div>

                                    <div class="form-group">
                                        <label>Ingrese correo electrónico</label>
                                        <input class="form-control" type="email" name="email" id="emailid" onBlur="checkAvailability()" pattern=".+utsalamanca.edu.mx" title="DEBE SER CON EL CORREO INSTITUCIONAL" autocomplete="off" required <span id="user-availability-status" style="font-size:12px;"></span>
                                    </div>

                                    <div class="form-group">
                                        <label>Introducir la contraseña</label>
                                        <input class="form-control" type="password" name="password" autocomplete="off" required />
                                    </div>

                                    <div class="form-group">
                                        <label>Confirmar contraseña</label>
                                        <input class="form-control" type="password" name="confirmpassword" autocomplete="off" required />
                                    </div>

                                    <button type="submit" name="signup" class="btn btn-danger" id="submit">Regístrate ahora </button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>






        <!-- CONTENT-WRAPPER SECTION END-->
        <?php include('includes/footer.php'); ?>
        <script src="assets/js/jquery-1.10.2.js"></script>
        <!-- BOOTSTRAP SCRIPTS  -->
        <script src="assets/js/bootstrap.js"></script>
        <!-- CUSTOM SCRIPTS  -->
        <script src="assets/js/custom.js"></script>
    </body>

</html>