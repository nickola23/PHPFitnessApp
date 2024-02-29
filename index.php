<?php session_start()?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/global.css">
    <title>FitTrack</title>
</head>
<body>
<?php
  include('navbar.php');

  $emailErr = $imeErr = $lozinkaErr = $lozinka2Err = "";
  $email = $ime = $lozinka = $lozinka2 = "";
  function redirect($url) {
    header('Location: ' . $url);
    die();
  }
?>

<h1>Dobrodosli, 
  <?php if(isset($_SESSION['email'])) echo $_SESSION["email"] ?></h1>
</body>
</html>