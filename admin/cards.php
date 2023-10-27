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
    .category-card {
        width: 300px; /* Ajusta el ancho según tus preferencias */
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
        color: white; /* Letras blancas */
        border-radius: 5px; /* Agrega esquinas redondeadas */
    }

    .category-card:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    .category-card h3 {
        font-size: 18px;
        margin-bottom: 10px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6); /* Sombra en el texto */
    }

    .category-card p {
        font-size: 14px;
        margin-bottom: 20px;
    }

    .category-card .btn {
        display: inline-block;
    }
    .category-card .btn {
            margin-top: 10px; /* Agrega separación en la parte superior del botón */
        }


    .category-card img {
        display: none;
    }
    .category-card .btn {
        margin-top: 10px; /* Agrega separación en la parte superior del botón */
        margin-right: 5px; /* Agrega separación entre los botones */
    }
    </style>
</head>


<body>

    <?php include('includes/header.php'); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Categorías</h2>
                <div class="category-container">
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

                    // Obtener todas las categorías de la tabla tblcategory
                    $query = "SELECT * FROM tblcategory";
                    $result = mysqli_query($conn, $query);

                    // Mostrar las categorías en tarjetas de título
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='category-card' style='background-image: url(" . $row['Image'] . ");'>";
                        echo "<h3 style='margin-top: 50%;'>" . $row['CategoryName'] . "</h3>";
                        echo "<a href='libros.php?categoria=" . $row['CategoryName'] . "' class='btn btn-primary'>Ver libros</a>";
                        echo "<form action='eliminar_categoria.php' method='post' onsubmit='return confirm(\"¿Estás seguro de eliminar esta categoría?\")'>";
                        echo "<button type='submit' class='btn btn-danger'>Eliminar</button>";

                        echo "<input type='hidden' name='categoria_id' value='" . $row['id'] . "' />";
                        echo "</form>";
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

</body>

</html>
