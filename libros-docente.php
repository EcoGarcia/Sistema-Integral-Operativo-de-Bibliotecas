<?php
    session_start();
    error_reporting(0);
    include('includes/config.php');



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
        /* Estilos para la imagen del libro */
        .book-image {
            width: 180px;
            height: 180px;
            object-fit: contain;
            position: sticky;
            top: 0;
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

        /* Estilos para las celdas de la tabla y encabezados */
        td, th {
            text-align: center;
            padding: 70px; /* Añade padding para igualar el espacio del primer código */
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

            .td {
                text-align: center;
            }

            .th {
                text-align: center;
            }

            .search-section {
                text-align: left;
            }
            td.narrow-cell {
    width: 200px; /* Ajusta este valor según tus necesidades */
}

        }
    </style>
    </head>

    <body>
        <?php include('includes/headerds.php'); ?>

        <div class="container">
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
                            echo "<th>Título</th>";
                            echo "<th>Portada</th>";
                            echo "<th>Autor</th>";
                            echo "<th>Editorial</th>";
                            echo "<th>ISBN</th>";
                            echo "<th>Cantidad</th>";
                            echo "<th>Colocación</th>";
                            echo "<th>Edición</th>";
                            echo "<th>Fecha</th>";
                            echo "<th>Estado</th>";
                            echo "<th>Opciones</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";

                            $counter = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<td>" . $counter . "</td>";
                                echo "<td>" . $row['nombre'] . "</td>";
                                $portadaURL = "portadas/" . $row['portada'];
                                echo "<td><img src='" . $portadaURL . "' class='book-image'></td>";
                                echo "<td>" . $row['autor'] . "</td>";
                                echo "<td>" . $row['editorial'] . "</td>";
                                echo "<td>" . $row['isbn'] . "</td>";
                                echo "<td class='wide-cell'>" . $row['cantidad'] . "</td>";
                                echo "<td>" . $row['colocación'] . " " . $row['num'] . "</td>";
                                echo "<td>" . $row['edición'] . "</td>";
                                echo "<td>" . $row['estado'] . "</td>";
                                echo "<td>" . $row['fecha'] . "</td>";
                                echo "<td>";

                                echo "<a href='solicitud-docente.php?id=" . $row['nombre'] . "' class='btn btn-primary'>Solicitar libro</a>";
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
            function confirmDelete() {
                return confirm('¿Está seguro de que desea eliminar este libro?');
            }
        </script>

    </body>

    </html>
