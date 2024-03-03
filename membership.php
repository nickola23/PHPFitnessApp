<?php session_start()?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/secondary.css">
    <link rel="stylesheet" href="./css/membership.css">
    <title>FitTrack Clanarina</title>
</head>
<body>
<?php

include('./php/header.php');
include('./php/connection.php');

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$iznosErr = $lozinkaErr = "";
$iznos = $lozinka = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(empty($_POST["iznos"])) {
    $iznosErr = "Morate uneti iznos";
  } else {
    $iznos = test_input($_POST["iznos"]);
    if (!preg_match("/[0-9]/", $iznos)){
      $iznosErr = "Niste pravilno uneli iznos";
    }
    else{
      $iznosErr = "";
    }
  }
  
  if (empty($_POST["lozinka"])) {
    $lozinkaErr = "Morate uneti lozinku";
  } else {
    $lozinka = test_input($_POST["lozinka"]);
    $email = $_SESSION['email'];
    $sql = "SELECT password FROM korisnik WHERE email = '$email'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if(password_verify($lozinka, $row["password"])){
      $lozinkaErr = "";
    }
    else $lozinkaErr = "Pogresna lozinka";
  }

  if($iznosErr == "" && $lozinkaErr == ""){
    $email = $_SESSION['email'];
    $sql = "SELECT id FROM korisnik WHERE email = '$email'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $id = $row['id'];
    $sql = "INSERT INTO clanarina(idClana, iznos) VALUES ('$id', '$iznos')";
    
    if ($conn->query($sql) === TRUE) {
      // echo "Uspesno uplacena clanarina";
    } else{
      echo "Greska:" . $conn->error;
    }
    $conn->close();
  }
}
?>
<main>
  <section class="memHero">
    <div class="secLeft">
      <p>Moja Clanarina</p>
      <h1>Ime i prezime</h1>
      <p>@username</p>
    </div>
    <div class="secRight"></div>
  </section>
  <section class="secondary">
    <h2>Clanarina vazi jos <span class="date">25 dana</span></h2>
    <h2>- 23.5.2024.</h2>
  </section>
  <section class="memSec">
    <h2>Online uplata</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="membershipForm" class="memForm">  
      <label for="iznos">Iznos za uplatu:</label>
      <input type="text" name="iznos">
      <span class="error"><?php echo $iznosErr?></span>
      <label for="iznos">Lozinka:</label>
      <input type="password" name="lozinka">
      <span class="error"><?php echo $lozinkaErr?></span><br>
      <button type="submit" class="btnDark">Prijavi se</button>
    </form>
  </section>
  <section class="memSec">
    <h2>Prethodne clanarine</h2>
    <div class="nopayments">Nema dosadasnjih uplata</div>

  </section>
</main>
</body>
</html>