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
include('./components/header.php');
include('./database/connection.php');

if(!isset($_SESSION["email"])) {
  header('Location: index.php');
}

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
      header('Location: membership.php');
      exit();
    } else{
      echo "Greska:" . $conn->error;
    }
    $conn->close();
  }
}
$email = $_SESSION['email'];
$sql = "SELECT k.id, k.username, k.fullName, c.datumUplate, c.iznos  FROM korisnik k LEFT JOIN clanarina c ON k.id = c.idClana WHERE k.email ='$email' ORDER BY c.datumUplate DESC";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$danas = new DateTime();

if($row["datumUplate"] != null){
  $datumUplate = new DateTime($row["datumUplate"]);
  $datumVazenja = clone $datumUplate;
  $datumVazenja->modify('+1 month');  
}
else{
  $datumUplate = null;
  $datumVazenja = null;
}

?>
<main>
  <section class="memHero">
    <div class="secLeft">
      <p>Moja Clanarina</p>
      <h1><?php echo $row["fullName"]?></h1>
      <p>@<?php echo $row["username"]?></p>
    </div>
    <div class="secRight"></div>
  </section>
  <section class="secondary">
    <h2>
      <?php
        if($datumVazenja != null){
          if($danas > $datumVazenja){
            echo 'Clanarina vam je istekla pre <span class="date error">' . $danas->diff($datumVazenja)->days . ' dana</span>';
          }
          else{
            echo 'Clanarina vazi jos <span class="date">' . $danas->diff($datumVazenja)->days . ' dana</span>';
          }
        } 
        else echo "Niste uplatili clanarinu";
      ?>
    </h2>
    <h2>- 
    <?php
      if($datumVazenja != null) echo $datumVazenja->format("d.m.Y");
      else echo " -- --";
    ?></h2>
  </section>
  <section class="memSec">
    <h2>Online uplata</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="membershipForm" class="memForm">  
      <label for="iznos">Iznos za uplatu:</label>
      <input type="text" name="iznos">
      <span class="error"><?php echo $iznosErr?></span>
      <label for="lozinka">Lozinka:</label>
      <input type="password" name="lozinka">
      <span class="error"><?php echo $lozinkaErr?></span><br>
      <button type="submit" class="btnDark">Uplatite</button>
    </form>
  </section>
  <section class="memSec">
    <h2>Prethodne clanarine</h2>
    <?php
    $sql = "SELECT c.datumUplate, c.iznos  FROM korisnik k JOIN clanarina c ON k.id = c.idClana WHERE k.email ='$email' ORDER BY c.datumUplate DESC";
    $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          echo '
          <div class="payment">
            <p>' . $row["iznos"] . '</p>
            <p>' . $datumUplate->format("d.m.Y") . '.</p>
          </div>';
        }
      }
      else{
        echo '<div class="nopayments">Nema dosadasnjih uplata</div>';
      }
    ?>
  </section>
</main>
</body>
</html>