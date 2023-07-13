<?php include("includes/config.php") ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SIOB | Agregar libro</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>

<?php include('includes/header.php'); ?>

<div class="content-wrapper">
    <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
            <h4 class="header-line">Agregar libros</h4>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Información del libro
                        </div>
                        <form action="guardar_libros.php" method="POST" enctype="multipart/form-data">
                            <div class="panel-body">
                                <form role="form" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Categoria<span style="color:red;">*</span></label>
                                        <select name="categoria" class="form-control">
                                            <?php
                                            // Conectarse a la base de datos (reemplaza con tus propios detalles)
                                            $servername = "localhost";
                                            $username = "root";
                                            $password = "";
                                            $dbname = "library";

                                            $conn = mysqli_connect($servername, $username, $password, $dbname);

                                            // Comprobar la conexión
                                            if (!$conn) {
                                                die("Conexión fallida: " . mysqli_connect_error());
                                            }

                                            // Obtener todas las categorías de la tabla libros
                                            $query = "SELECT DISTINCT CategoryName FROM tblcategory";
                                            $result = mysqli_query($conn, $query);

                                            // Mostrar las categorías en el menú desplegable
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='" . $row['CategoryName'] . "'>" . $row['CategoryName'] . "</option>";
                                            }

                                            // Cerrar la conexión
                                            mysqli_close($conn);
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Colocación<span style="color:red;">*</span></label>
                                        <?php
                                        // Conectarse a la base de datos (reemplaza con tus propios detalles)
                                        $servername = "localhost";
                                        $username = "root";
                                        $password = "";
                                        $dbname = "library";

                                        $conn = mysqli_connect($servername, $username, $password, $dbname);

                                        // Comprobar la conexión
                                        if (!$conn) {
                                            die("Conexión fallida: " . mysqli_connect_error());
                                        }

                                        // Obtener los nombres de la tabla colocación
                                        $query = "SELECT colocación FROM tblcategory";
                                        $result = mysqli_query($conn, $query);

                                        // Mostrar los nombres en el campo de texto
                                        echo "<select name='colocación' class='form-control'>";
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='" . $row['colocación'] . "'>" . $row['colocación'] . "</option>";
                                        }
                                        echo "</select>";

                                        // Cerrar la conexión
                                        mysqli_close($conn);
                                        ?>
                                    </div>


                            </div>
                            <input type="submit" name="guardar" value="Agregar" class="btn btn-primary">
                            
                        </form>
                    </div>
                </div>
            </div>

            
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
<?php ?>