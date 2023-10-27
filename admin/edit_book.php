<?php
include("includes/config.php");

// Obtener categorías de la tabla tblcategory
$query_categorias = "SELECT CategoryName FROM tblcategory";
$resultado_categorias = mysqli_query($conexion, $query_categorias);
$categorias = array();
while ($row_categoria = mysqli_fetch_assoc($resultado_categorias)) {
    $categorias[] = $row_categoria['CategoryName'];
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM libros WHERE id = $id";
    $resultado = mysqli_query($conexion, $query);
    if (mysqli_num_rows($resultado) == 1) {
        $row = mysqli_fetch_array($resultado);
        $numero = $row['numero'];
        $nombre = $row['nombre'];
        $categ = $row['categoria'];
        $aut = $row['autor'];
        $isbn = $row['isbn'];
        $editorial = $row['editorial'];
        $cantidad = $row['cantidad'];
        $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';
        $portada = $row['portada'];
        $estado = $_POST['estado']; // Obtenemos el estado del campo de texto
    }
}

if (isset($_POST['guardar'])) {
    $numero = $_POST['numero'];
    $nombre = $_POST['nombre-libro'];
    $autor = $_POST['autor'];
    $categoria = $_POST['categoria'];
    $isbn = $_POST['isbn'];
    $editorial = $_POST['editorial'];
    $cantidad = $_POST['cantidad'];
    $colocación = $_POST['colocación'];
    $edición = isset($_POST['edición']) ? $_POST['edición'] : '';
    $fecha = $_POST['fecha'];
    $num = $_POST['num'];
    $estado = $_POST['estado']; // Obtenemos el estado del campo de texto


    // Procesar imagen de portada 
    if ($_FILES['portada']['size'] > 0) {
        $portada = $_FILES['portada']['name'];
        $portada_temp = $_FILES['portada']['tmp_name'];
        $destino = "../portadas/" . $portada;
        move_uploaded_file($portada_temp, $destino);
    } else {
        $destino = $portada;
    }

    $id = $_GET['id'];

    $query = "UPDATE libros SET numero = $numero, estado = '$estado', nombre = '$nombre', categoria = '$categoria', autor = '$autor', isbn = '$isbn', cantidad = $cantidad, portada = '$destino', colocación = '$colocación', edición = '$edición', fecha = '$fecha', num = '$num', editorial = '$editorial' WHERE id = $id";
    mysqli_query($conexion, $query);

    header("Location: libros.php?categoria=$categoria");
    exit;
}
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SIOB | Editar libro</title>
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
                    <h4 class="header-line">Editar libro</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Información del libro
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Numero del libro<span style="color:red;">*</span></label>
                                    <input class="form-control" type="number" name="numero" value="<?php echo htmlentities($numero); ?>" required />
                                </div>
                                <div class="form-group">
                                    <label>Nombre del libro<span style="color:red;">*</span></label>
                                    <input class="form-control" type="text" name="nombre-libro" value="<?php echo htmlentities($nombre); ?>" required />
                                </div>
                                <div class="form-group">
                                    <label>Cambiar portada</label>
                                    <input class="form-control" type="file" name="portada" accept="image/*" />
                                    <p class="help-block">Seleccione una imagen de portada para el libro.</p>
                                </div>

                                <div class="form-group">
                                    <label>Nombre del autor<span style="color:red;">*</span></label>
                                    <input class="form-control" type="text" name="autor" value="<?php echo htmlentities($aut); ?>" required />
                                </div>
                                <div class="form-group">
                                    <label>Editorial<span style="color:red;">*</span></label>
                                    <input class="form-control" type="text" name="editorial" value="<?php echo isset($editorial) ? htmlentities($editorial) : ''; ?>" required />
                                </div>
                                <div class="form-group">
                                    <label>Categoría<span style="color:red;">*</span></label>
                                    <select class="form-control" name="categoria" required>
                                        <?php
                                        foreach ($categorias as $categoria_item) {
                                            $selected = ($categ == $categoria_item) ? 'selected' : '';
                                            echo "<option value='$categoria_item' $selected>$categoria_item</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Colocación</label>
                                    <select name="colocación" class="form-control">
                                        <?php
                                        // Variables de conexión a la base de datos
                                        $servername = "localhost";
                                        $username = "root";
                                        $password = "";
                                        $dbname = "library";

                                        // Establecer conexión a la base de datos
                                        $conn = mysqli_connect($servername, $username, $password, $dbname);

                                        // Comprobar la conexión
                                        if (!$conn) {
                                            die("Conexión fallida: " . mysqli_connect_error());
                                        }

                                        // Obtener los nombres de la tabla "colocación"
                                        $query = "SELECT colocación FROM tblcategory";
                                        $result = mysqli_query($conn, $query);

                                        // Obtener el valor actual de la colocación para el libro
                                        $colocacion_actual = "";
                                        if (isset($_GET['id'])) {
                                            $id = $_GET['id'];
                                            $query_libro = "SELECT colocación FROM libros WHERE id = $id";
                                            $result_libro = mysqli_query($conn, $query_libro);
                                            if (mysqli_num_rows($result_libro) == 1) {
                                                $row_libro = mysqli_fetch_assoc($result_libro);
                                                $colocacion_actual = $row_libro['colocación'];
                                            }
                                        }

                                        // Mostrar los nombres en el campo de selección
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $selected = ($colocacion_actual == $row['colocación']) ? 'selected' : '';
                                            echo "<option value='" . $row['colocación'] . "' " . $selected . ">" . $row['colocación'] . "</option>";
                                        }

                                        // Cerrar la conexión
                                        mysqli_close($conn);
                                        ?>
                                    </select>
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
                                    <input class="form-control" type="text" name="isbn" value="<?php echo htmlentities($isbn); ?>" required />
                                    <p class="help-block">Un ISBN es un número de libro estándar internacional. El ISBN debe ser único</p>
                                </div>
                                <div class="form-group">
                                    <label>Cantidad<span style="color:red;">*</span></label>
                                    <input class="form-control" type="number" name="cantidad" value="<?php echo htmlentities($cantidad); ?>" required />
                                </div>

                                <div class="form-group">
                                    <label>Estado del libro<span style="color:red;">*</span></label>
                                    <input class="form-control" type="text" name="estado" value="<?php echo htmlentities($estado); ?>" required />
                                </div>
                                <button type="submit" name="guardar" class="btn btn-info">Guardar</button>
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