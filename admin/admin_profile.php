<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['registrar']) == 0) {
} else {
    if (isset($_POST['update'])){
        $sid = $_SESSION['AdminId'];
        $fname = $_POST['FullName'];

        $sql = "update tbladmin set FullName:=fname where AdminId=sid:";
        $query = $dbh->prepare($sql);
        $query->bindParam(':sid', $sid, PDO::PARAM_STR);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);

        $query->execute();

        echo '<script>alert("Your profile has been updated")</script>';

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
    <title>SIOB | Mi perfil de docente</title>
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
    <?php include('includes/headerds.php'); ?>

    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Mi perfil</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 col-md-offset-1">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            Mi perfil
                            <!-- Mostrar el nombre del administrador -->
                            <div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form method="post">
                                <div class="form-group">
                                    <label>Nombre:</label>
                                    <input class="form-control" type="text" name="FullName" value="<?php echo htmlentities($result->FullName); ?>" autocomplete="off" required readonly />
                                </div>
                                <label>Correo Electronico:</label>
                                    <input class="form-control" type="text" name="FullName" value="<?php echo htmlentities($result->EmailId); ?>" autocomplete="off" required readonly />
                                </div>

                                <button type="submit" name="update" class="btn btn-primary" id="submit">Actualizar ahora</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>

</html>
