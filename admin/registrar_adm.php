<!-- encabezado -->
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SIOB</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>

<!------MENU SECTION START-->
<?php include('includes/header.php'); ?>


<div class="content-wrapper">
    <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Registro de administrador</h4>

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
                                <input class="form-control" type="email" name="email" id="emailid" onBlur="checkAvailability()" autocomplete="off" required />
                                <span id="user-availability-status" style="font-size:12px;"></span>
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





<!-- Pie de página -->

<?php include('includes/footer.php'); ?>
<!-- FOOTER SECTION END-->
<script src="assets/js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS  -->
<script src="assets/js/bootstrap.js"></script>
<!-- CUSTOM SCRIPTS  -->
<script src="assets/js/custom.js"></script>


</script>
</body>

</html>