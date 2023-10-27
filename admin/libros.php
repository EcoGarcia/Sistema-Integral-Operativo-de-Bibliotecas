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
        /* Estilos para la imagen del libro */
        .book-image {
            width: 180px;
            height: 180px;
            object-fit: contain;
            position: sticky;
            top: 0;
        }

        td,
        th {
            text-align: center;
        }

        /* Estilos para las secciones de filtro y búsqueda */
        .filter-section {
            float: left;
            width: 30%;
        }

        .search-section {
            float: right;
            width: 70%;
            text-align: right;
        }

        /* Agrega estilos para hacer la tabla responsive */
        @media screen and (max-width: 768px) {
            table {
                width: 100%;
            }

            thead {
                display: none;
            }

            tr:nth-of-type(2n) {
                background-color: inherit;
            }

            tr td {
                display: block;
                text-align: center;
                width: 100%;
            }

            th,
            td {
                text-align: center;
            }

            td:before {
                /* Agrega contenido a cada celda en modo móvil */
                content: attr(data-th);
                display: block;
                text-align: center;
                font-weight: bold;
            }

            .book-image {
                /* Ajusta el tamaño de la imagen en modo móvil */
                width: 100%;
                height: auto;
            }

            .book-details {
                /* Oculta los detalles del libro en modo móvil */
                display: none;
            }
        }

        /* Estilos para el acordeón en modo móvil */
        .book-details-mobile {
            display: none;
        }

        .hidden-row.active {
            display: table-row;
        }
    </style>
</head>

<body>
    <?php include('includes/header.php'); ?>

    <div class="panel-body">
        <div class="panel-body">
            <div class="col-md-12">
                <?php
                include("includes/config.php");

                // Conexión a la base de datos (reemplaza con tus propios detalles)
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "library";

                $conn = mysqli_connect($servername, $username, $password, $dbname);
                // Comprobar la conexión
                if (!$conn) {
                    die("Conexión fallida: " . mysqli_connect_error());
                }

                if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
                    $categoria = $_GET['categoria'];
                    // Escapar la variable para evitar inyección de SQL (opcional dependiendo del caso)
                    $categoria = mysqli_real_escape_string($conn, $categoria);

                    // Obtener los libros de la categoría seleccionada
                    $query = "SELECT * FROM libros WHERE categoria = '$categoria'";
                    $result = mysqli_query($conn, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        echo "<h2>Libros relacionados con la categoría: " . $categoria . "</h2>";
                        echo "<div class='table-responsive'>";
                        echo "<table class='table table-bordered'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>No.</th>";
                        echo "<th>Título <i class='fa fa-caret-down'></i></th>";
                        echo "<th>Portada</th>";
                        echo "<th>Autor</th>";
                        echo "<th>Editorial</th>";
                        echo "<th>ISBN</th>";
                        echo "<th>Cantidad</th>";
                        echo "<th>Colocación</th>";
                        echo "<th>Edición</th>";
                        echo "<th>Estado</th>";
                        echo "<th>Fecha</th>";
                        echo "<th>Opciones</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";

                        $counter = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr class='book-row' data-toggle='collapse' data-target='#book-" . $row['id'] . "'>";
                            echo "<td>" . $counter . "</td>";
                            echo "<td>" . $row['nombre'] . "</td>";
                            echo "<td><img src='" . $row['portada'] . "' class='book-image'></td>";
                            echo "<td>" . $row['autor'] . "</td>";
                            echo "<td>" . $row['editorial'] . "</td>";
                            echo "<td>" . $row['isbn'] . "</td>";
                            echo "<td>" . $row['cantidad'] . "</td>";
                            echo "<td>" . $row['colocación'] . " " . $row['num'] . "</td>";
                            echo "<td>" . $row['edición'] . "</td>";
                            echo "<td>" . $row['estado'] . "</td>";
                            echo "<td>" . $row['fecha'] . "</td>";
                            echo "<td>";
                            echo "<a href='edit_book.php?id=" . $row['id'] . "' class='btn btn-primary'>Editar</a> ";
                            echo "<a href='delete.php?id=" . $row['id'] . "&categoria=" . urlencode($row['categoria']) . "' onclick='return confirmDelete();' class='btn btn-danger'>Eliminar</a>";
                            echo "</td>";
                            echo "</tr>";
                            echo "<tr class='hidden-row'>";
                            echo "<td colspan='12' class='hidden-row'>";
                            echo "<div id='book-" . $row['id'] . "' class='collapse book-details-mobile'>";
                            echo "<p><strong>Autor:</strong> " . $row['autor'] . "</p>";
                            echo "<p><strong>Editorial:</strong> " . $row['editorial'] . "</p>";
                            echo "<p><strong>ISBN:</strong> " . $row['isbn'] . "</p>";
                            echo "<p><strong>Cantidad:</strong> " . $row['cantidad'] . "</p>";
                            echo "<p><strong>Colocación:</strong> " . $row['colocación'] . " " . $row['num'] . "</p>";
                            echo "<p><strong>Edición:</strong> " . $row['edición'] . "</p>";
                            echo "<p><strong>Estado:</strong> " . $row['estado'] . "</p>";
                            echo "<p><strong>Fecha:</strong> " . $row['fecha'] . "</p>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                            $counter++;
                        }

                        echo "</tbody>";
                        echo "</table>";
                        echo "</div>";
                    } else {
                        echo "<p>No se encontraron libros en la categoría seleccionada.</p>";
                    }
                } else {
                    echo "<p>No se ha proporcionado una categoría válida.</p>";
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
        // Script para activar el acordeón en modo móvil
        $(document).ready(function() {
            $('.book-row').click(function() {
                $(this).next('.hidden-row').toggleClass('active');
            });
        });
    </script>
</body>

</html>