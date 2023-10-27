    <?php
    session_start();
    error_reporting(0);
    include('includes/config.php');
    if (strlen($_SESSION['alogin']) == 0) {
        header('location:index.php');
    } else {
        if (isset($_POST['create'])) {
            $category = $_POST['category'];
            $status = $_POST['status'];
            $colocacion = $_POST['colocación'];

            // Imagen de portada
            $Image = $_FILES['Image']['name'];
            $image_temp = $_FILES['Image']['tmp_name'];
            $destino = "../categoria/" . $Image;
            $destino_admin = "../categoria/" . $Image;
            move_uploaded_file($image_temp, $destino);

            $sql = "INSERT INTO tblcategory(CategoryName, colocación, Status, Image) VALUES(:CategoryName, :colocacion, :status, :Image)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':CategoryName', $category, PDO::PARAM_STR);
            $query->bindParam(':colocacion', $colocacion, PDO::PARAM_STR);
            $query->bindParam(':status', $status, PDO::PARAM_STR);
            $query->bindParam(':Image', $destino, PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();
            if ($lastInsertId) {
                $_SESSION['msg'] = "Brand Listed successfully";
                header('location:manage-categories.php');
            } else {
                $_SESSION['error'] = "Something went wrong. Please try again";
                header('location:manage-categories.php');
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
        <title>SIOB | Agregar categorías</title>

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
        <?php include('includes/header.php'); ?>
        <!-- MENU SECTION END-->
        <div class="content-wrapper">
            <div class="container">
                <div class="row pad-botm">
                    <div class="col-md-12">
                        <h4 class="header-line">Agregar categorías</h4>
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
                                    <div class="form-group text-center">
                                        <label>Nombre de la categoría</label>
                                        <input class="form-control" type="text" name="category" autocomplete="off" required />
                                    </div>
                                    <div class="form-group text-center">
                                        <label>Nombre de la colocación</label>
                                        <input class="form-control" type="text" name="colocación" autocomplete="off" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Imagen de portada</label>
                                        <input type="file" name="Image" accept="image/*"  required>
                                    </div>
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="status" id="status" value="1" checked="checked">Activo
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="status" id="status" value="0">Inactivo
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" name="create" class="btn btn-info">Crear</button>
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
        <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
        <!-- CORE JQUERY  -->
        <script src="assets/js/jquery-1.10.2.js"></script>
        <!-- BOOTSTRAP SCRIPTS  -->
        <script src="assets/js/bootstrap.js"></script>
        <!-- CUSTOM SCRIPTS  -->
        <script src="assets/js/custom.js"></script>
    </body>

    </html>
