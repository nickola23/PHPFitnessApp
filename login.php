<?php session_start()?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitTrack Prijava</title>
</head>
<body>
<?php
include('navbar.php');
include('konekcija.php');

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

<h1>Prijava</h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="" onsubmit='e.preventDefault();'>  
  Email: <input type="text" name="email">
  <span class="error">* <?php echo $emailErr?></span>
  <br><br>
  Lozinka: <input type="password" name="lozinka">
  <span class="error">* <?php echo $lozinkaErr?></span><br>
  <button type="submit" >Prijavi se</button>
  <br><br>
</form>
  <?php
   
  ?>
</body>
</html>