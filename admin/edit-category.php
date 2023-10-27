<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['update'])) {
        $catid = intval($_GET['catid']);
        $category = $_POST['category'];
        $colocacion = $_POST['colocacion'];
        $description = $_POST['description'];
        $status = intval($_POST['status']);

        // Validar la imagen (si se envía una nueva imagen)
        if ($_FILES['image']['name'] != '') {
            $Image = $_FILES['image']['name'];
            $image_temp = $_FILES['image']['tmp_name'];
            $destino = "../categoria/" . $Image;
            move_uploaded_file($image_temp, $destino);
            // Eliminar la imagen anterior si existe (en este caso, no se elimina la imagen anterior del servidor)
            // Si lo deseas, puedes agregar aquí el código para eliminar la imagen anterior del servidor.
        } else {
            // Si no se envía una nueva imagen, mantener la imagen anterior
            $destino = $_POST['old_image'];
        }

        $sql = "UPDATE tblcategory SET CategoryName=:category, Image=:image, colocación=:colocacion, Description=:description, Status=:status WHERE id=:catid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':category', $category, PDO::PARAM_STR);
        $query->bindParam(':image', $destino, PDO::PARAM_STR);
        $query->bindParam(':colocacion', $colocacion, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
        $query->bindParam(':catid', $catid, PDO::PARAM_INT);
        $query->execute();

        $_SESSION['updatemsg'] = "Categoría actualizada con éxito";
        header('location: manage-categories.php');
    }
}
?>

<!-- Resto del código HTML y formulario sigue igual -->


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SIOB | Editar categoría</title>
    <!-- BOOTSTRAP CORE STYLE -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
    <style>

    </style>
<body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Editar categoría</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Información de la categoría
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post" enctype="multipart/form-data">
                                <?php
                                $catid = intval($_GET['catid']);
                                $sql = "SELECT * FROM tblcategory WHERE id=:catid";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':catid', $catid, PDO::PARAM_INT);
                                $query->execute();
                                $result = $query->fetch(PDO::FETCH_OBJ);
                                ?>
                                    <div class="form-group text-center">
                                    <label>Nombre de la categoría<span style="color:red;">                  </span></label>
                                    <input class="form-control" type="text" name="category" value="<?php echo htmlentities($result->CategoryName); ?>" required />
                                </div>
                                <div class="form-group text-center">
                                    <label>Colocación</label>
                                    <input class="form-control" type="text" name="colocacion" value="<?php echo htmlentities($result->colocación); ?>" />
                                </div>


                                <div class="form-group">
                                    <label>Fondo</label>
                                    <input class="form-control" type="file" name="image" accept="image/*" />
                                    <input type="hidden" name="old_image" value="<?php echo htmlentities($result->Image); ?>" />
                                </div>

 
                                    <!-- <div class="form-group">
                                        <label>Descripción</label>
                                        <textarea class="form-control" name="description"><?php echo htmlentities($result->Description); ?></textarea>
                                    </div> -->

                                <div class="form-group">
                                    <label>Estado</label>
                                    <select class="form-control" name="status">
                                        <option value="1" <?php if ($result->Status == 1) echo 'selected'; ?>>Activo</option>
                                        <option value="0" <?php if ($result->Status == 0) echo 'selected'; ?>>Inactivo</option>
                                    </select>
                                </div>

                                <button type="submit" name="update" class="btn btn-info">Actualizar </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME -->
    <!-- CORE JQUERY -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>

</html>
