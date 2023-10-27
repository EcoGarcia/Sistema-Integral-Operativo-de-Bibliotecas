<?php 
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{
    header('location:index.php');
}
else { 
    // Obtener los libros y su cantidad
    $sql = "SELECT nombre, cantidad FROM libros";
    $query = $dbh->prepare($sql);
    $query->execute();
    $books = $query->fetchAll(PDO::FETCH_ASSOC);

    // Obtener las categorías y la cantidad de libros
    $sql2 = "SELECT CategoryName, colocación FROM tblcategory";
    $query2 = $dbh->prepare($sql2);
    $query2->execute();
    $categories = $query2->fetchAll(PDO::FETCH_ASSOC);

    // Obtener los autores y la cantidad de libros
    $sql3 = "SELECT autor, COUNT(*) AS cantidad FROM libros GROUP BY autor";
    $query3 = $dbh->prepare($sql3);
    $query3->execute();
    $authors = $query3->fetchAll(PDO::FETCH_ASSOC);
}

// Dividir los resultados en grupos de 5
$booksChunks = array_chunk($books, 5);
$categoriesChunks = array_chunk($categories, 5);
$authorsChunks = array_chunk($authors, 5);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>SIOB| Tablero de administración</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<style>
    th {
    text-align: center;
    }
    td {
        text-align: center;
    }
</style>

<body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php');?>
    <!-- MENU SECTION END-->

    <!-- CONTENIDO DE LA TABLA -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="header-line">Tablero de administración</h4>
            </div>
        </div>

        <div class="row">
        <div class="col-md-4">
    <div class="panel panel-info">
        <div class="panel-heading">
            Nombres de Libros y Cantidad
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nombre del Libro</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($booksChunks as $chunk) : ?>
                            <?php foreach ($chunk as $book) : ?>
                                <tr>
                                    <td><?php echo $book['nombre']; ?></td>
                                    <td><?php echo $book['cantidad']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
            <div class="col-md-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Categorías y Colocación
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <?php foreach ($categoriesChunks as $chunk) : ?>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Categoría</th>
                                            <th>Colocación</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($chunk as $category) : ?>
                                            <tr>
                                                <td><?php echo $category['CategoryName']; ?></td>
                                                <td><?php echo $category['colocación']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
    <div class="panel panel-info">
        <div class="panel-heading">
            Autores registrados
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Autores registrados</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($authorsChunks as $chunk) : ?>
                            <?php foreach ($chunk as $author) : ?>
                                <tr>
                                    <td><?php echo $author['autor']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
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