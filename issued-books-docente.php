<?php
session_start();
error_reporting(0);
include('includes/config.php');

// // Comprobar si la sesión está activa
// if (isset($_SESSION['registrar']) && !empty($_SESSION['registrar'])) {
//     $welcomeMessage = "¡Bienvenido, " . $_SESSION['registrar'] . "!";
// } else {
//     $welcomeMessage = "¡Bienvenido!";
// }
// ?>


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
        /* Estilos de la tarjeta de categoría */
        .category-card {
            width: 300px;
            height: 400px;
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            float: left;
            text-align: center;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: box-shadow 0.3s ease;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            color: white;
            border-radius: 5px;
        }

        .category-card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }

        .category-card h3 {
            font-size: 18px;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }

        .category-card p {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .category-card .btn {
            display: inline-block;
        }

        .category-card img {
            display: none;
            max-width: 100%;
        }

        /* Estilos para los botones en la tarjeta de categoría */
        .category-card .btn-container {
            display: flex;
            justify-content: center;
            flex-direction: column;
            gap: 10px;
            margin-top: 20px;
            padding-bottom: 20px;
        }

        .category-card .btn-edit {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <?php include('includes/headerds.php'); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Mostrar el mensaje de bienvenida -->
                <h2><?php echo $welcomeMessage; ?></h2>
                <h2>Categorías</h2>
                <div class="category-container">
                    <?php
                    $destino = 'categorias/';

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

                    // Obtener todas las categorías de la tabla tblcategory
                    $query = "SELECT * FROM tblcategory";
                    $result = mysqli_query($conn, $query);

                    // Mostrar las categorías en tarjetas de título
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='category-card' style='background-image: url(categoria/" . $row['Image'] . ");'>";
                        echo "<h3 style='margin-top: 50%;'>" . $row['CategoryName'] . "</h3>";
                        echo "<p>" . $row['Description'] . "</p>";
                        echo "<div class='btn-container'>";
                        echo "<a href='libros-docente.php?categoria=" . urlencode($row['CategoryName']) . "' class='btn btn-primary btn-view-books' data-category='" . $row['CategoryName'] . "'>Ver libros</a>";
                        echo "<input type='hidden' name='categoria_id' value='" . $row['id'] . "' />";
                        echo "</form>";
                        echo "</div>"; // Cierra el div con la clase btn-container
                        echo "</div>";
                    }

                    // Cerrar la conexión
                    mysqli_close($conn);
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>

    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>

    <script>
        // Función para manejar el evento de clic en "Ver libros"
        document.querySelectorAll('.btn-view-books').forEach(btn => {
            btn.addEventListener('click', function() {
                const category = this.getAttribute('data-category');
                fetchBooksByCategory(category);
            });
        });

        function fetchBooksByCategory(category) {
            // Realizar una solicitud AJAX para obtener los libros relacionados con la categoría seleccionada
            fetch('get_books.php?categoria=' + category)
                .then(response => response.json())
                .then(data => {
                    // Construir la lista de libros y mostrarla en el contenedor book-list-container
                    let bookList = '';
                    data.forEach(book => {
                        bookList += `
                            <div class="book-card">
                                <h4>${book.nombre}</h4>
                                <!-- Agregar aquí los demás detalles del libro, como autor, portada, etc. -->
                            </div>
                        `;
                    });
                    document.getElementById('book-list-container').innerHTML = bookList;
                })
                .catch(error => console.error('Error al obtener los libros:', error));
        }
    </script>
</body>
</html>
