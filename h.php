<?php
include("includes/config.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SIOB</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <title>Libros</title>
    <style>
        
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
        tr:nth-child(even){background-color: #f2f2f2}
        th {
            background-color: #4CAF50;
            color: white;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 6px 10px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            text-align: center;
        }
        .book-image {
        width: 180px;
        height: 180px;
        object-fit: contain;
        position: sticky;
        top: 0;
    }

    .filter-section {
        float: left;
        width: 30%;
    }

    .search-section {
        float: right;
        width: 70%;
        text-align: right;
    }

    .search-section label {
        display: inline-block;
        margin-right: 5px;
    }

    @media (max-width: 768px) {
        .filter-section,
        .search-section {
            float: none;
            width: 100%;
        }

        .search-section {
            text-align: left;
        }
    }
    </style>
</head>
<body>
<?php include('includes/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <div id="search-results"></div>

        <div class="filter-section">
            <h4>Filtrar por categoría:</h4>
            <form method="POST" action="">
            <select name="categoria" class="form-control">
                            <option value="">Todas las categorías</option>
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
                            $query = "SELECT DISTINCT CategoryName FROM tblcategory ORDER BY CategoryName ASC";
                            $result = mysqli_query($conn, $query);

                            // Mostrar las categorías en el menú desplegable
                            while ($row = mysqli_fetch_assoc($result)) {
                                $selected = '';
                                if (isset($_POST['categoria']) && $_POST['categoria'] == $row['CategoryName']) {
                                    $selected = 'selected';
                                }
                                echo "<option value='" . $row['CategoryName'] . "' " . $selected . ">" . $row['CategoryName'] . "</option>";
                            }

                            // Cerrar la conexión
                            mysqli_close($conn);
                            ?>
                        </select>
                <input type="submit" value="Filtrar" class="btn btn-success">
            </form>
        </div>

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

        // Construir la consulta SQL
        $query = "SELECT * FROM libros";

        // Verificar si se seleccionó una categoría
        if (isset($_POST['categoria']) && !empty($_POST['categoria'])) {
            $categoria = $_POST['categoria'];
            $query .= " WHERE categoria = '$categoria'";
        }

        // Verificar si se ingresó un término de búsqueda
        if (isset($_POST['search']) && !empty($_POST['search'])) {
            $search = $_POST['search'];
            if (strpos($query, 'WHERE') === false) {
                $query .= " WHERE nombre LIKE '%$search%'";
            } else {
                $query .= " AND nombre LIKE '%$search%'";
            }
        }

        // Ordenar los resultados por nombre
        $query .= " ORDER BY nombre ASC";

        // Ejecutar la consulta
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Nombre del libro</th>";
            echo "<th>Portada</th>";
            echo "<th>Categoría</th>";
            echo "<th>Cantidad</th>";
            echo "<th>Acciones</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['nombre'] . "</td>";
                echo "<td><img src='admin/" . $row['portada'] . "' class='book-image'></td>";
                echo "<td>" . $row['categoria'] . "</td>";
                echo "<td>" . $row['cantidad'] . "</td>";
                echo "<td>";
                echo "<a href='reporteador.php'><button class='btn btn-success' onclick='solicitarPrestamo(" . $row['id'] . ")'>Solicitar préstamo</button></a>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>No se encontraron libros.</p>";
        }

        // Cerrar la conexión
        mysqli_close($conn);
        ?>
    </div>
</div>
<script>
    function solicitarPrestamo(libroId) {
        // Aquí puedes agregar la lógica para solicitar el préstamo del libro con el ID "libroId"
        // Puedes utilizar AJAX para enviar una solicitud al servidor y realizar la acción correspondiente
        // Por ejemplo:
        // - Mostrar un formulario para que el usuario ingrese sus datos de préstamo
        // - Actualizar la base de datos para registrar el préstamo
        // - Enviar una notificación al administrador, etc.
    }
</script>
</body>
</html>
