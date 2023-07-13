<?php 
require_once("includes/config.php");

if (!empty($_POST["bookid"])) {
  $bookid = $_POST["bookid"];

  $sql = "SELECT nombre, id FROM tblbooks WHERE ISBNNumber = :bookid";
  $query = $dbh->prepare($sql);
  $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);
  $cnt = 1;

  if ($query->rowCount() > 0) {
    foreach ($results as $result) {
      ?>
      <option value="<?php echo htmlentities($result->id); ?>">
        <?php echo htmlentities($result->nombre); ?>
      </option>
      <?php
      echo "<b>Nombre del libro :</b> " . htmlentities($result->nombre);
      echo "<script>$('#submit').prop('disabled', false);</script>";
    }
  } else {
    ?>
    <option class="others">Número ISBN no válido</option>
    <?php
    echo "<script>$('#submit').prop('disabled', true);</script>";
  }
}
?>
