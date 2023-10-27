<?php
include("includes/config.php");
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

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
    <style>
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

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Categoría:</label>
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
                    </div>
                    <div class="form-group">
                        <input type="text" name="search" class="form-control" placeholder="Buscar por nombre de libro">
                    </div>
                    <div class="form-group">
                        <input type='submit' value='Buscar' class="btn btn-primary">
                        <a href="" onclick="location.reload();" class="btn btn-default">Restablecer</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
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
                    echo "<th>No.</th>";
                    echo "<th>Titulo</th>";
                    echo "<th>Autor</th>";
                    echo "<th>Portada</th>";
                    echo "<th>Editorial</th>";
                    echo "<th>Categoría</th>";
                    echo "<th>ISBN</th>";
                    echo "<th>Cantidad</th>";
                    echo "<th>Colocación</th>";
                    echo "<th>Edición</th>";
                    echo "<th>Fecha</th>";
                    echo "<th>Acciones</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['numero'] . "</td>";
                        echo "<td>" . $row['nombre'] . "</td>";
                        echo "<td>" . $row['autor'] . "</td>";
                        echo "<td><img src='" . $row['portada'] . "' class='book-image'></td>";
                        echo "<td>" . $row['editorial'] . "</td>";
                        echo "<td>" . $row['categoria'] . "</td>";
                        echo "<td>" . $row['isbn'] . "</td>";
                        echo "<td>" . $row['cantidad'] . "</td>";
                        echo "<td>" . $row['colocación'] . " " . $row['num'] . "</td>";
                        echo "<td>" . $row['edición'] . "</td>";
                        echo "<td>" . $row['fecha'] . "</td>";
                        echo "<td>";
                        echo "<a href='edit_book.php?id=" . $row['id'] . "' class='btn btn-primary'>Editar</a> ";
                        echo "<a href='delete.php?id=" . $row['id'] . "' onclick='return confirmDelete();' class='btn btn-danger'>Eliminar</a>";
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