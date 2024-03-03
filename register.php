<?php session_start()?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/global.css">
    <title>FitTrack Registracija</title>
</head>
<body>
<?php

if(isset($_SESSION["email"])) {
  header('Location: index.php');
}

include('./php/header.php');

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
  <h1>Registruj se</h1>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="registerForm">  
    Email: <input type="text" name="email">
    <span class="error">* <?php echo $emailErr?></span>
    <br><br>
    Ime i prezime: <input type="text" name="ime">
    <span class="error">* <?php echo $imeErr?></span>
    <br><br>
    Lozinka: <input type="password" name="lozinka">
    <span class="error">* <?php echo $lozinkaErr?></span>
    <br><br>
    Ponovljena lozinka: <input type="password" name="lozinka2">
    <span class="error">* <?php echo $lozinka2Err?></span><br>
    <input type="submit" name="submit" value="Registruj se">
    <br><br>
  </form>

  <?php
    if(isset($_POST["submit"]) && $emailErr == "" && $imeErr == "" && $lozinkaErr == "" && $lozinka2Err == ""){
      
      include('./php/connection.php');
        
      $sql = "INSERT INTO korisnik(email, username, fullName, password) VALUES ('$email', '$usernameNew', '$ime', '$hash')";
        if($conn->query($sql) === TRUE) {
          echo "Korisnik dodat u bazu";
          header('Location: login.php');
        } else {
          echo "Greska: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
      }
  ?>
</main>
</body>
</html>