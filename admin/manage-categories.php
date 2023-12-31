<?php
// Configuración de la base de datos
$host = 'localhost';
$dbname = 'id21151153_library';
$username = 'id21151153_library';
$password = 'Alibrary1.';

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}

session_start();
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_GET['del'])) {
        $id = $_GET['del'];
        $sql = "DELETE FROM tblcategory WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['delmsg'] = "Categoría borrada con éxito";
        header('location:manage-categories.php');
    }
}
?>
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>SIOB | Administrar categorías</title>
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
    <style>
        td{
            text-align: c;
        }
        th{
            text-align: center;
        }
    </style>
    <body>
        <!------MENU SECTION START-->
    <?php include('includes/header.php');?>
    <!-- MENU SECTION END-->
        <div class="content-wrapper">
            <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Gestionar categorías</h4>
        </div>
        <div class="row">
        <?php if($_SESSION['error']!="")
        {?>
    <div class="col-md-6">
    <div class="alert alert-danger" >
    <strong>Error :</strong> 
    <?php echo htmlentities($_SESSION['error']);?>
    <?php echo htmlentities($_SESSION['error']="");?>
    </div>
    </div>
    <?php } ?>
    <?php if($_SESSION['msg']!="")
    {?>
    <div class="col-md-6">
    <div class="alert alert-success" >
    <strong>Éxito :</strong> 
    <?php echo htmlentities($_SESSION['msg']);?>
    <?php echo htmlentities($_SESSION['msg']="");?>
    </div>
    </div>
    <?php } ?>
    <?php if($_SESSION['updatemsg']!="")
    {?>
    <div class="col-md-6">
    <div class="alert alert-success" >
    <strong>Éxito :</strong> 
    <?php echo htmlentities($_SESSION['updatemsg']);?>
    <?php echo htmlentities($_SESSION['updatemsg']="");?>
    </div>
    </div>
    <?php } ?>


    <?php if($_SESSION['delmsg']!="")
        {?>
    <div class="col-md-6">
    <div class="alert alert-success" >
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
                            Listado de categorías
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre de la categoria</th>
                                                <th>Colocación</th>
                                                <th>Fondo</th>
                                                <th>Estado</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $sql = "SELECT * FROM tblcategory";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $cnt = 1;
    if ($query->rowCount() > 0) {
        foreach ($results as $result) { ?>
            <tr class="odd gradeX">
                <td class="center"><?php echo htmlentities($cnt);?></td>
                <td class="center"><?php echo htmlentities($result->CategoryName);?></td>


                <td class="center"><?php echo htmlentities($result->colocación);?></td>
                <td class="center">
        <?php
        // Comprobar si la columna "Image" contiene una ruta válida
        if (!empty($result->Image) && file_exists($result->Image)) {
            // Mostrar la imagen
            echo '<img src="' . $result->Image . '" alt="Imagen de la categoría" style="max-height: 100px; max-width: 100px; width: auto; height: auto; position: relative;" />';
        } else {
            // Mostrar un mensaje si la imagen no está disponible
            echo 'Imagen no disponible';
        }
        ?>
    </td>
                <td class="center">
                    <?php if ($result->Status == 1) {?>
                        <a href="#" class="btn btn-success btn-xs">Activo</a>
                    <?php } else { ?>
                        <a href="#" class="btn btn-danger btn-xs">Inactivo</a>
                    <?php } ?>
                </td>
         
                <td class="center">
                    <a href="edit-category.php?catid=<?php echo htmlentities($result->id);?>">
                        <button class="btn btn-primary"><i class="fa fa-edit "></i> Editar</button>
                    </a>
                    <a href="manage-categories.php?del=<?php echo htmlentities($result->id);?>" onclick="return confirm('¿Estás seguro de eliminar la categoria?');">
                        <button class="btn btn-danger"><i class="fa fa-pencil"></i> Borrar</button>
                    </a>
                </td>
            </tr>
            <?php $cnt++;
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
<?php ?>