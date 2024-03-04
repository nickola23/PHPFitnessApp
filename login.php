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
    <title>FitTrack Prijava</title>
</head>
<body>
<?php

if(isset($_SESSION["email"])) {
  header('Location: index.php');
}

include('./components/header.php');
include('./database/connection.php');

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$emailErr = $lozinkaErr = "";
$email = $lozinka = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(empty($_POST["email"])) {
    $emailErr = "Morate uneti email";
  } else {
    $email = test_input($_POST["email"]);
    if (!preg_match("/[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+/", $email)){
      $emailErr = "Niste pravilno uneli email";
    }
    else{
      $emailErr = "";
    }
  }
  
  if (empty($_POST["lozinka"])) {
    $lozinkaErr = "Morate uneti lozinku";
  } else {
    $lozinka = test_input($_POST["lozinka"]);
    $lozinkaErr = "";
  }

  if($emailErr == "" && $lozinkaErr == ""){
    $sql = "SELECT * FROM korisnik WHERE email LIKE '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        if(password_verify($lozinka, $row["password"])){
          $_SESSION["email"] = $email;
          header('Location: index.php');
        }
      }
      echo "Pogresno ste uneli sifru ili email";
    } else{
      echo "Pogresno ste uneli sifru ili email";
    }
    $conn->close();
  }
}
?>
<main>
  <section class="loginSec">
    <div class="loginHeader">
      <h1>Prijava</h1>
    </div>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="loginForm" class="loginForm">  
      <label for="email">Email:</label>
      <input type="text" name="email">
      <span class="error"><?php echo $emailErr?></span>
      <label for="lozinka">Lozinka:</label>
      <input type="password" name="lozinka">
      <span class="error"><?php echo $lozinkaErr?></span><br>
      <button type="submit" class="btnDark">Prijavi se</button>
      <p>Nemate nalog? <a href="./register.php" class="loginLink">Registrujte se</a></p>
    </form>
  </section>
</main>
</body>
</html>