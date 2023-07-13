<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['return'])) {
        $book = $_POST['book'];
        $issuedid = $_POST['issuedid'];

        // Eliminar la consulta de la tabla tblissuedbookdetails
        $sql_delete = "DELETE FROM tblissuedbookdetails WHERE id = :issuedid";
        $query_delete = $dbh->prepare($sql_delete);
        $query_delete->bindParam(':issuedid', $issuedid, PDO::PARAM_INT);
        $query_delete->execute();

        // Eliminar el PDF generado
        $pdf_filename = "reportes/" . $issuedid . ".pdf";
        if (file_exists($pdf_filename)) {
            unlink($pdf_filename);
        }

        $_SESSION['msg'] = "Libro devuelto exitosamente.";

        // Incrementar la cantidad disponible del libro en la tabla libros
        $sql_update = "UPDATE libros SET cantidad = cantidad + 1 WHERE nombre = :book";
        $query_update = $dbh->prepare($sql_update);
        $query_update->bindParam(':book', $book, PDO::PARAM_STR);
        $query_update->execute();
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SIOB | Administrar libros emitidos</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- DATATABLE STYLE  -->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php');?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Administrar libros emitidos</h4>
                </div>
                <div class="row">
                    <?php if($_SESSION['error']!="") {?>
                        <div class="col-md-6">
                            <div class="alert alert-danger">
                                <strong>Error :</strong>
                                <?php echo htmlentities($_SESSION['error']);?>
                                <?php echo htmlentities($_SESSION['error']="");?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if($_SESSION['msg']!="") {?>
                        <div class="col-md-6">
                            <div class="alert alert-success">
                                <strong>Éxito :</strong>
                                <?php echo htmlentities($_SESSION['msg']);?>
                                <?php echo htmlentities($_SESSION['msg']="");?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if($_SESSION['delmsg']!="") {?>
                        <div class="col-md-6">
                            <div class="alert alert-success">
                                <strong>Éxito :</strong>
                                <?php echo htmlentities($_SESSION['delmsg']);?>
                                <?php echo htmlentities($_SESSION['delmsg']="");?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Libros publicados
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre del estudiante</th>
                                            <th>Nombre del libro</th>
                                            <th>Fecha de emisión</th>
                                            <th>Fecha de regreso</th>
                                            <th>Acción</th>
                                            <th>Devolución</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT id, studentname, nombre, horaEmision, horaRegreso FROM tblissuedbookdetails";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {
                                                ?>
                                                <tr class="odd gradeX">
                                                    <td class="center"><?php echo htmlentities($cnt); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->studentname); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->nombre); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->horaEmision); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->horaRegreso); ?></td>
                                                     <td class="center">
                                                        <a href="update-issue-bookdeails.php?rid=<?php echo htmlentities($result->id); ?>">
                                                            <button class="btn btn-primary"><i class="fa fa-edit"></i></button>
                                                        </a>
                                                    </td>
                                                    <td class="center">
                                                        <form method="post">
                                                            <input type="hidden" name="book" value="<?php echo htmlentities($result->nombre); ?>">
                                                            <input type="hidden" name="issuedid" value="<?php echo htmlentities($result->id); ?>">
                                                            <button type="submit" name="return" class="btn btn-success btn-xs">Aceptar devolución</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php
                                                $cnt++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--End Advanced Tables -->
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
    <!-- DATATABLE SCRIPTS  -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
