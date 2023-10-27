<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{   
    header('location:index.php');
}
else {
    if(isset($_POST['update_image']))
    {
        $categoria_id = $_POST['categoria_id'];

        // Imagen de portada
        $Image = $_FILES['Image']['name'];
        $image_temp = $_FILES['Image']['tmp_name'];
        $destino = "../categoria/" . $Image;
        $destino_admin = "../categoria/" . $Image;
        move_uploaded_file($image_temp, $destino);
        
        // Actualizar la ruta de la imagen en la base de datos
        $sql = "UPDATE tblcategory SET Image = :Image WHERE id = :categoria_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':Image', $destino, PDO::PARAM_STR);
        $query->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $query->execute();

        $_SESSION['msg'] = "Imagen de categoría actualizada correctamente";
        header('location: cards.php');
        exit;
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
    <title>SIOB | Editar el fondo de la categoría</title>
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

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Editar Imagen de Categoría</h2>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="categoria">Selecciona una categoría:</label>
                        <select class="form-control" name="categoria_id" id="categoria" required>
                            <?php
                                $sql = "SELECT id, CategoryName FROM tblcategory";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $categorias = $query->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($categorias as $categoria) {
                                    echo '<option value="' . $categoria['id'] . '">' . $categoria['CategoryName'] . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
    <label for="portada">Selecciona una nueva imagen:</label>
    <input type="file" name="Image" id="portada" required>
</div>

                    <br>
                    <input type="submit" name="update_image" value="Guardar">
                </form>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>

    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
