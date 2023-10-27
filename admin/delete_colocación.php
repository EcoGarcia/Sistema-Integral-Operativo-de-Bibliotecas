<?php
include('includes/config.php');

if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $query = "DELETE FROM tblcategory WHERE colocación = '$name'";
    $result = mysqli_query($conexion, $query);
    if (!$result) {
        die("Query failed");
    }
    $_SESSION['message'] = 'Task Removed Successfully';
    header("Location: manage_colocación.php");
}
?>
