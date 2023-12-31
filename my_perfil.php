<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['registrar']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['update'])){
        $sid = $_SESSION['docenteid'];
        $fname = $_POST['nombre'];

        $sql = "update tbldocentes set nombre:=fname where docenteid=sid:";
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
        <!------MENU SECTION START-->
        <?php include('includes/headerds.php');?>
        <!-- MENU SECTION END-->
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
                            </div>
                            <div class="panel-body">
                                <form name="signup" method="post">
                                    <?php
                                    $sid = $_SESSION['stdid'];
                                    $sql = "SELECT docenteid,nombre,email,regDate,UpdationDate,Status from  tbldocentes  where docenteid=:sid ";
                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':sid', $sid, PDO::PARAM_STR);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $result) {               ?>

                                            <!-- <div class="form-group"> -->
                                            <!-- <label>ID de estudiante : </label> -->
                                            <!-- <?php echo htmlentities($result->StudentId); ?> -->
                                            <!-- </div> -->

                                            <!-- <div class="form-group">
                                                <label>Fecha de registro : </label>
                                                <?php echo htmlentities($result->RegDate); ?>
                                            </div> -->

                                            <!-- <?php if ($result->UpdationDate != "") { ?>
                                                <div class="form-group">
                                                    <label> Ultima fecha de actualización : </label>
                                                    <?php echo htmlentities($result->UpdationDate); ?>
                                                </div>
                                            <?php } ?> -->


                                            <div class="form-group">
                                                <label>Estado de perfil : </label>
                                                <?php if ($result->Status == 1) { ?>
                                                    <span style="color: green">Activo</span>
                                                <?php } else { ?>
                                                    <span style="color: red">Bloqueado</span>
                                                <?php } ?>
                                            </div>


                                            <div class="form-group">
                                                <label> Nombre completo</label>
                                                <input class="form-control" type="text" name="nombre" value="<?php echo htmlentities($result->nombre); ?>" autocomplete="off" required readonly />
                                            </div>


                                            <!-- <div class="form-group">
                                                <label>Numero de telefono móvil :</label>
                                                <input class="form-control" type="text" name="mobileno" maxlength="10" value="<?php echo htmlentities($result->MobileNumber); ?>" autocomplete="off" required />
                                            </div> -->

                                            <div class="form-group">
                                                <label>Ingrese correo electronico</label>
                                                <input class="form-control" type="email" name="email" id="emailid" value="<?php echo htmlentities($result->email); ?>" autocomplete="off" required readonly />
                                            </div>
                                    <?php }
                                    } ?>


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