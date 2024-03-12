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
    <link rel="stylesheet" href="./css/groupInfo.css">
    <title>FitTrack Informacije</title>
</head>
<body>
<main>
    <?php
    include("./handlers/connection.php");
    include("./components/header.php");

    if(isset($_GET['id'])) {
        $groupId = $_GET['id'];
        
        $sql = "SELECT g.id, g.naziv, g.opis, g.slika, k.fullName FROM grupa g JOIN korisnik k ON g.trener = k.id WHERE g.id = '$groupId'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo'
                    <section class="hero" style="background-image: linear-gradient(180deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.5) 100%), url(' . $row["slika"] . ');">
                        <div class="heroDesc">
                        <p>Grupa</p>
                        <h1>' . $row["naziv"] .'</h1>
                        </div>
                    </section>
                    <section class="memSec">
                        <h2>Saznajte o nasoj Grupi</h2>
                        <p>' . $row["opis"] . '</p>
                    </section>
                    <section class="memSec">
                        <h2>Trener</h2>
                        <p>' . $row["fullName"] . '</p>
                        <h2>Clanovi Grupe</h2>';
                        $sql = "SELECT k.fullName FROM grupa g JOIN korisnik k ON g.id = k.idGrupe WHERE g.id = '$groupId'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                echo '<p>' . $row["fullName"] . '</p>';
                            }
                        }
                        else{ echo "Grupa nema clanova"; }
                    echo '</section>
                    <section class="secondary">
                        <h2>Pocnite da trenirate odmah</h2>
                        <div class="btnDark"><a href="./membership.php">Uplatite clanarinu</a></div>
                    </section>
                    ';
            }
        }
        else{
            echo "Grupa nije pronadjena"; 
            exit();
        }
    }
    else{
        echo "ID grupe nije pronadjen";
        exit();
    }
    ?>
</main>
</body>
</html>