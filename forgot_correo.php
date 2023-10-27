<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('includes/config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:/xampp/htdocs/library/phpmailer/src/Exception.php';
require 'C:/xampp/htdocs/library/phpmailer/src/PHPMailer.php';
require 'C:/xampp/htdocs/library/phpmailer/src/SMTP.php';

if (isset($_POST['change'])) {
    $email = $_POST['email'];

    $sql = "SELECT EmailId, Password FROM tbladmin WHERE EmailId = :email";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Código para enviar correo con PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.office365.com'; // Reemplaza con el servidor SMTP correcto
            $mail->SMTPAuth = true;
            $mail->Username = $result['EmailId']; // Obtén el nombre de usuario desde la base de datos
            $mail->Password = $result['Password']; // Obtén la contraseña desde la base de datos
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Resto del código para configurar el correo

            $mail->send();
            echo "<script>alert('Correo electrónico válido. Se ha enviado un enlace de restablecimiento a tu correo.');</script>";
            echo "<script>window.location.href = 'forgot-password.php';</script>"; // Redirecciona a la pantalla de restablecimiento de contraseña
            exit;
        } catch (Exception $e) {
            echo "<script>alert('Hubo un error al enviar el correo. " . $mail->ErrorInfo . "');</script>";
        }
    } else {
        echo "<script>alert('El correo electrónico no es válido');</script>";
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
    <title>SIOB | Password Recovery </title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <meta name="google" content="notranslate">
</head>

<body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Recuperación de contraseña de usuario</h4>
                </div>
            </div>

            <!--LOGIN PANEL START-->
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            FORMULARIO DE INICIO DE SESIÓN
                        </div>
                        <div class="panel-body">
                            <form role="form" name="chngpwd" method="post">

                                <div class="form-group">
                                    <label>Ingrese la dirección de correo electrónico</label>
                                    <input class="form-control" type="email" name="email" required autocomplete="off" />
                                </div>

                                <button type="submit" name="change" class="btn btn-info">Verificar correo electrónico</button> | <a href="forgot_password.php">Acceso</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!---LOGIN PANEL END-->
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>

</html>