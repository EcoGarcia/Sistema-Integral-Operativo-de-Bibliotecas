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


    <style>
        th
    </style>

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
                                        <label>Numero del libro<span style="color:red;">*</span></label>
                                        <input type="number" name="numero" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Nombre del libro<span style="color:red;">*</span></label>
                                        <input type="text" name="nombre" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Agregar portada<span style="color:red;">*</span></label>
                                        <input type="file" name="portada" accept="image/*"  class="form-control" required>
                                    </div> 
                                    <div class="form-group">
                                        <label>Nombre del autor<span style="color:red;">*</span></label>
                                        <input type="text" name="autor" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Nombre de la editorial<span style="color:red;">*</span></label>
                                        <input type="text" name="editorial" class="form-control" required>
                                    </div>
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
                                    <div class="form-group">
                                        <label>Numero de colocación<span style="color:red;">*</span></label>
                                        <input type="text" name="num" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Numero de la edición<span style="color:red;">*</span></label>
                                        <input type="text" name="edición" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Fecha<span style="color:red;">*</span></label>
                                        <input type="number" name="fecha" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Número ISBN<span style="color:red;">*</span></label>
                                        <input type="text" name="isbn" class="form-control">
                                        <p class="help-block">Un ISBN es un número de libro estándar internacional. El ISBN debe ser único</p>
                                    </div>
                                    <div class="form-group">
                                        <label>Cantidad</label>
                                        <input type="number" name="cantidad" class="form-control" required>
                                    </div>   
                                      <div class="form-group">
                                        <label>Estado del libro<span style="color:red;">*</span></label>
                                        <input type="text" name="estado" class="form-control" required>
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