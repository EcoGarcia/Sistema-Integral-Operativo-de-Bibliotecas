<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{   
    header('location:index.php');
}
else { 

    if(isset($_POST['update'])) {
        $category=$_POST['category'];
        $status=$_POST['estado'];
        $colocacion=$_POST['colocación']; 
        $catid=intval($_GET['catid']);
        $sql="UPDATE tblcategory SET CategoryName=:category, Colocación=:colocacion, Status=:status WHERE id=:catid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':category',$category,PDO::PARAM_STR);
        $query->bindParam(':colocacion',$colocacion,PDO::PARAM_STR);
        $query->bindParam(':status',$status,PDO::PARAM_STR);
        $query->bindParam(':catid',$catid,PDO::PARAM_STR);
        $query->execute();
        $_SESSION['updatemsg']="Brand updated successfully";
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
    <title>SIOB | Editar categorías</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
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
                    <h4 class="header-line">Editar categorías</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Información de la categoría
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post">
                                <?php 
                                $catid=intval($_GET['catid']);
                                $sql="SELECT * FROM tblcategory WHERE id=:catid";
                                $query=$dbh->prepare($sql);
                                $query->bindParam(':catid',$catid, PDO::PARAM_STR);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                if($query->rowCount() > 0) {
                                    foreach($results as $result) {               
                                ?> 
                                <div class="form-group">
                                    <label>Nombre de la categoría</label>
                                    <input class="form-control" type="text" name="category" value="<?php echo htmlentities($result->CategoryName);?>" required />
                                </div>
                                <div class="form-group">
                                    <label>Colocación</label>
                                    <?php
                                    $colocacionValue = htmlentities($result->Colocación);
                                    ?>
                                    <input class="form-control" type="text" name="colocación" value="<?php echo $colocacionValue; ?>" required />
                                </div>
                                <div class="form-group">
                                    <label>Estado</label>
                                    <?php if($result->Status==1) {?>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="estado" id="estado" value="1" checked="checked">Activo
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="estado" id="estado" value="0">Inactivo
                                        </label>
                                    </div>
                                    <?php } else { ?>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="estado" id="estado" value="0" checked="checked">Inactivo
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="estado" id="estado" value="1">Activo
                                        </label>
                                    </div>
                                    <?php } ?>
                                </div>
                                <?php }} ?>
                                <button type="submit" name="update" class="btn btn-info">Actualizar</button>
                            </form>
                        </div>
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
