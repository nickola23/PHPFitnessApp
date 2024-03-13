<?php session_start()?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/login.css">
    <title>FitTrack Izmenite Grupe</title>
</head>
<body>
<?php

if(!isset($_SESSION["email"]) && !isset($_GET['id'])) {
  header('Location: index.php');
}

$id = "";
if(isset($_GET['id'])) {
  $id = $_GET['id'];
}
else{
  $id = $_POST["id"];
}

include('./components/header.php');

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$opisGrupeValue = $nazivGrupeValue = $idTreneraValue = "";
$nazivErr = $idTreneraErr = $opisErr = $slikaErr = "";
$naziv = $idTrenera = $opis = $slika = "";

$sql = "SELECT * FROM grupa g WHERE id = '$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nazivGrupeValue = $row["naziv"];
    $idTreneraValue = $row["trener"];
    $opisGrupeValue = $row["opis"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["naziv"])) {
    $nazivErr = "Morate uneti naziv grupe";
  } else {
    $naziv = test_input($_POST["naziv"]);
    $nazivErr = "";
  }

  if (empty($_POST["idTrenera"])) {
    $idTreneraErr = "Morate uneti ID postojeceg trenera";
  } else {
    $idTrenera = test_input($_POST["idTrenera"]);
    $idTreneraErr = "";
  }

  if (empty($_POST["opis"])) {
    $opisErr = "Morate uneti opis ";
  } else {
    $opis = test_input($_POST["opis"]);
    $opisErr = "";
  }
  
  if (isset($_FILES["slika"]) && $_FILES["slika"]["error"] == UPLOAD_ERR_OK) {
    $slikaInfo = pathinfo($_FILES["slika"]["name"]);
    $slika = "./images/" . $slikaInfo['filename'] . '.' . $slikaInfo['extension'];
    $slikaErr = "";
  } else {
    $slika = "";
  }
}
?>
<main>
  <section class="loginSec">
    <div class="loginHeader">
      <h1>Izmenite Grupu</h1>
    </div>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="registerForm"  class="loginForm" enctype="multipart/form-data"> 
      <input type="hidden" name="id" value="<?php echo $id;?>"> 
      <label for="naziv">Naziv grupe</label><input type="text" name="naziv" value="<?php echo $nazivGrupeValue; ?>">
      <span class="error"><?php echo $nazivErr?></span>
      <label for="idTrenera">ID trenera:</label><input type="text" name="idTrenera" value="<?php echo $idTreneraValue; ?>">
      <span class="error"><?php echo $idTreneraErr?></span>
      <label for="opis">Opis grupe</label><input type="text" name="opis" value="<?php echo $opisGrupeValue; ?>">
      <span class="error"><?php echo $opisErr?></span>
      <label for="slika" class="imageLabel">Slika grupe</label><input id="slika" type="file" name="slika">
      <span class="error"><?php echo $slikaErr?></span>
      <div class="groupBtns">
        <button type="submit" class="btnDark">Izmeni Grupu</button>
        <a href="./groupsAdmin.php" class="loginLink"><div class="btnLight">Odustani</div></a>
      </div>
    </form>
  <section class="loginSec">
  <?php
    if($_SERVER["REQUEST_METHOD"] == "POST" && $nazivErr == "" && $idTreneraErr == "" && $opisErr == "" && $slikaErr == ""){
      include('./handlers/connection.php');

      if($slika != ""){
        $sql = "UPDATE grupa SET naziv = '$naziv', trener = '$idTrenera', opis = '$opis', slika = '$slika' WHERE id = '$id'";
        move_uploaded_file($_FILES["slika"]["tmp_name"], $slika);
      }
      else $sql = "UPDATE grupa SET naziv = '$naziv', trener = '$idTrenera', opis = '$opis' WHERE id = '$id'"; 

        if($conn->query($sql) === TRUE) {
          header('Location: groupsAdmin.php');
        } else {
            echo "Doslo je do greske prilikom cuvanja slike ili";
            echo "Greska pri cuvanju u bazu: " . $conn->error;
        }
        $conn->close();
      }
  ?>
</main>
</body>
<script>
document.getElementById("slika").addEventListener("change", function() {
    if (this.files && this.files[0]) {
        this.previousElementSibling.style.border = "1px solid green";
    }
});
</script>
</html>