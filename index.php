<?php session_start()?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/hero.css">
    <link rel="stylesheet" href="./css/secondary.css">
    <title>FitTrack</title>
</head>
<body>
<?php
  include('./components/header.php');
  include('./handlers/connection.php')

?>
<main>
  <section class="hero" style="background-image: url(./images/hero.jpg);">
    <div class="heroDesc">
      <h1>Dobrodosli kuci</h1>
      <p>Pronadjite sebe u novom svetu, gde vasi snovi postaju stvarnost</p>
    </div>
    <div class="heroBtns">
      <a href="<?php if(isset($_SESSION['email'])) echo "#"; else echo "./login.php";?>">
        <div class="btnLight">
          <?php if(isset($_SESSION['email'])){
            $email = $_SESSION['email'];
            $sql = "SELECT fullName FROM korisnik WHERE email = '$email'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            echo  "Zdravo " . explode(" ", $row["fullName"])[0];
          }  else echo "Prijavi se";?>
        </div>
      </a>
      <a href="./groups.php"><div class="btnDark">Pronadjite grupe</div></a>
    </div>
  </section>
  <section class="secondary">
    <h2>Najbolji treninzi u gradu</h2>
    <div class="btnDark"><a href="./groups.php">Saznaj vise</a></div>
  </section>
</main>
</body>
</html>