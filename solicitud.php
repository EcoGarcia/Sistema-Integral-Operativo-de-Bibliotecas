<?php
session_start();
error_reporting(0);
include('includes/config.php');
$sid = $_SESSION['login']; // Cambiar 'stdname' a 'login'
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Solicitud de Préstamo</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <style>
        .book-details {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            margin-top: 20px;
        }

        .book-image {
            max-width: 200px;
        }

        p {
            text-align: justify;
        }

        td {
            text-align: justify;
        }

        .book-image {
            width: 180px;
            height: 180px;
            object-fit: contain;
            position: sticky;
            top: 0;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php include('includes/header.php'); ?>

    <div class="navbar navbar-inverse set-radius-zero">
        <div class="container">
            <div class="navbar-header">
                <!-- Código para el logotipo -->
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <?php
                // Conectar a la base de datos (reemplaza con tus propios detalles)
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "library";

                $conn = mysqli_connect($servername, $username, $password, $dbname);

                // Comprobar la conexión
                if (!$conn) {
                    die("Conexión fallida: " . mysqli_connect_error());
                }

                if (isset($_GET['id']) && !empty($_GET['id'])) {
                    $nombreLibro = $_GET['id'];
                    // Escapar la variable para evitar inyección de SQL (opcional dependiendo del caso)
                    $nombreLibro = mysqli_real_escape_string($conn, $nombreLibro);

                    // Verificar si el libro existe en la base de datos
                    $query = "SELECT * FROM libros WHERE nombre = '$nombreLibro'";
                    $result = mysqli_query($conn, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);

                        echo "<h2>Solicitud de Préstamo</h2>";
                        echo "<div class='book-details'>";
                        echo "<table class='table table-bordered'>";

                        // Mostrar el nombre del correo con sesión iniciada
                        echo "<div class='form-group'>";
                        echo "<label>Correo del estudiante:</label>";
                        echo "<input class='form-control' type='text' name='studentname' value='" . htmlentities($sid) . "' autocomplete='off' required readonly />";
                        echo "</div>";

                        echo "<p><strong>Nombre del libro:</strong> " . $row['nombre'] . "</p>";
                        echo "<img src='portadas/" . $row['portada'] . "' class='book-image' alt='" . $row['nombre'] . "'>";
                        echo "<p><strong>Autor:</strong> " . $row['autor'] . "</p>";
                        echo "<p><strong>Editorial:</strong> " . $row['editorial'] . "</p>";
                        echo "<p><strong>Edición:</strong> " . $row['edición'] . "</p>";
                        echo "<p><strong>Categoria:</strong> " . $row['categoria'] . "</p>";
                        echo "<p><strong>Colocación:</strong> " . $row['colocación'] . " " . $row['num'] . "</p>";
                        echo "<p><strong>ISBN:</strong> " . $row['isbn'] . "</p>";
                        echo "<p><strong>Cantidad:</strong> " . $row['cantidad'] . "</p>";
                        echo "<p><strong>Estado:</strong> " . $row['estado'] . "</p>";
                        echo "<p><strong>Fecha:</strong> " . $row['fecha'] . "</p>";

                        // Agregar el campo de fecha de pedido y fecha de devolución al formulario
                        echo "<form action='procesar_solicitud.php' method='post'>";
                        echo "<input type='hidden' name='libro_id' value='" . $row['id'] . "'>";
                        
                        echo "<div class='form-group'>";
                        echo "<label>Fecha de Pedido:</label>";
                        echo "<input class='form-control' type='date' name='fecha_pedido' required />";
                        echo "</div>";

                        echo "<div class='form-group'>";
                        echo "<label>Fecha de Devolución:</label>";
                        echo "<input class='form-control' type='date' name='fecha_devolucion' required />";
                        echo "</div>";

                        // Agregar el botón para enviar la solicitud
                        echo "<input type='submit' name='submit' value='Enviar Solicitud' class='btn btn-primary'>";
                        echo "</form>";

                        echo "</div>";
                    } else {
                        echo "<p>No se encontró el libro especificado.</p>";
                    }
                } else {
                    echo "<p>No se ha proporcionado un libro válido para solicitar.</p>";
                }

                // Cerrar la conexión
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>



    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
    <script>
        function confirmDelete() {
            return confirm('¿Está seguro de que desea eliminar este libro?');
        }
    </script>
</body>
</html>