<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['issue'])) {
        $studentname = $_POST['studentname'];
        $bookname = $_POST['bookname'];

        // Obtener el libro basado en el nombre
        $sql = "SELECT * FROM libros WHERE nombre = :bookname";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bookname', $bookname, PDO::PARAM_STR);
        $query->execute();
        $book = $query->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontró el libro
        if ($book) {
            $bookid = $book['id'];

            $issuedate = date("Y-m-d"); // Obtiene la fecha actual en el formato "YYYY-MM-DD"

            $sql = "INSERT INTO tblissuedbookdetails(StudentName, BookId, issuedate) VALUES(:studentname, :bookid, :issuedate)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':studentname', $studentname, PDO::PARAM_STR);
            $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
            $query->bindParam(':issuedate', $issuedate, PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();
            if ($lastInsertId) {
                $_SESSION['msg'] = "Book issued successfully";
                echo "<script>alert('La información se guardó correctamente.');</script>";
                echo "<script>window.location.href='manage-issued-books.php';</script>";
                exit();
            } else {
                $_SESSION['error'] = "Something went wrong. Please try again";
                header('location:manage-issued-books.php');
                exit();
            }
        } else {
            $_SESSION['error'] = "El libro no fue encontrado";
            header('location:manage-issued-books.php');
            exit();
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
    <title>SIOB | Emitir un nuevo libro</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        // Function to search for student names
        function searchStudents() {
            var searchKeyword = $("#studentname").val();
            if (searchKeyword !== "") {
                $.ajax({
                    url: "get_student.php",
                    type: "POST",
                    data: {
                        keyword: searchKeyword
                    },
                    success: function(data) {
                        $("#search_results").html(data);
                    }
                });
            } else {
                $("#search_results").empty();
            }
        }

        // Function to set selected student name
        function setStudentName(name) {
            $("#studentname").val(name);
            $("#search_results").empty();
        }
    </script>
    <style type="text/css">
        .others {
            color: red;
        }
    </style>
</head>

<body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Emitir un nuevo libro</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Emitir un nuevo libro
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post">
                                <div class="form-group">
                                    <label>Nombre del estudiante<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="studentname" id="studentname" placeholder="Ingrese el nombre del estudiante" required>
                                </div>
                                <div class="form-group">
                                    <label>Nombre del libro<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="bookname" id="bookname" placeholder="Ingrese el nombre del libro" required>
                                </div>
                                <button type="submit" name="issue" id="submit" class="btn btn-info">Libro de emisión</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
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
<?php } ?>
