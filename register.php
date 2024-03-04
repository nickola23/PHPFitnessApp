<?php session_start()?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/login.css">
    <title>FitTrack Registracija</title>
</head>
<body>
<?php

if(isset($_SESSION["email"])) {
  header('Location: index.php');
}

include('./components/header.php');

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$emailErr = $imeErr = $lozinkaErr = $lozinka2Err = "";
$email = $ime = $usernameNew = $lozinka = $lozinka2 = $hash = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["email"])) {
    $emailErr = "Morate uneti email";
  } else {
    $email = test_input($_POST["email"]);
    if (!preg_match("/[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+/", $email)){
      $emailErr = "Niste pravilno uneli email";
    }
    else{
      $emailErr = "";
      $usernameNew = explode("@", $email)[0];
    }
  }

  if (empty($_POST["ime"])) {
    $imeErr = "Morate uneti ime";
  } else {
    $ime = test_input($_POST["ime"]);
    if (!preg_match("/^[a-zA-Z ]/", $ime)){
      $imeErr = "Niste pravilno uneli ime";
    }
    else{
      $imeErr = "";
    }
  }
  
  if (empty($_POST["lozinka"])) {
    $lozinkaErr = "Morate uneti lozinku";
  } else {
    $lozinka = test_input($_POST["lozinka"]);
    $lozinka2 = test_input($_POST["lozinka2"]);
    if($lozinka != $lozinka2){
      $lozinka2Err = "Lozinke moraju biti iste";
    }
    else{
      $lozinka2Err = "";
    }
  }
  $hash = password_hash($lozinka, PASSWORD_DEFAULT);
}
?>
<main>
  <section class="loginSec">
    <div class="loginHeader">
      <h1>Registracija</h1>
    </div>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="registerForm"  class="loginForm">  
      <label for="email">Email:</label><input type="text" name="email">
      <span class="error"><?php echo $emailErr?></span>
      <label for="ime">Ime i prezime:</label><input type="text" name="ime">
      <span class="error"><?php echo $imeErr?></span>
      <label for="lozinka">Lozinka:</label><input type="password" name="lozinka">
      <span class="error"><?php echo $lozinkaErr?></span>
      <label for="lozinka2">Ponovljena lozinka:</label><input type="password" name="lozinka2">
      <span class="error"><?php echo $lozinka2Err?></span>
      <p>* Pritiskom na dugme prihvatate uslove koriscenja <br></p>
      <button type="submit" class="btnDark">Registruj se</button>
      <p>Imate nalog? <a href="./login.php" class="loginLink">Prijavite se</a></p>
    </form>
  <section class="loginSec">

  <?php
    if(isset($_POST["submit"]) && $emailErr == "" && $imeErr == "" && $lozinkaErr == "" && $lozinka2Err == ""){
      
      include('./database/connection.php');
        
      $sql = "INSERT INTO korisnik(email, username, fullName, password) VALUES ('$email', '$usernameNew', '$ime', '$hash')";
        if($conn->query($sql) === TRUE) {
          echo "Korisnik dodat u bazu";
          header('Location: login.php');
        } else {
          echo "Greska: " . $sql . $conn->error;
        }
        $conn->close();
      }
  ?>
</main>
</body>
</html>