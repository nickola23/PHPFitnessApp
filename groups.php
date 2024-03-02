<?php session_start()?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/hero.css">
    <link rel="stylesheet" href="./css/groups.css">
    <title>FitTrack Grupe</title>
</head>
<body>
<?php
    include('./php/header.php');
    include('./php/connection.php');
?>
<main>
    <?php
        if(isset($_SESSION['email'])){
            $sql = "SELECT g.id, g.naziv, g.slika FROM grupa g JOIN korisnik k ON k.idGrupe = g.id WHERE k.email LIKE '" . $_SESSION['email'] . "'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo'
                    <section class="hero" style="background-image: linear-gradient(180deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.5) 100%), url(' . $row["slika"] . ');">
                        <div class="heroDesc">
                        <p>Moja grupa</p>
                        <h1>' . $row["naziv"] .'</h1>
                        </div>
                        <div class="heroBtns">
                        <a href="./membership.php"><div class="btnLight">Uplatite clanarinu</div></a>
                        <a href="./php/groupActions.php?id=null&action=leave"><div class="btnDark">Ispisi se</div></a>
                        </div>
                    </section>';
                }
            }
        }
        else echo"";
    ?>
    
    <section class="groupsSec">
        <h1>Istrazite grupe</h1>
        <div class="groupsCont">
            <?php
                $idGrupe = null;
                if(isset($_SESSION['email'])){
                    $email =  $_SESSION['email'];
                    $sql = "SELECT idGrupe FROM korisnik WHERE email = '$email'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    if ($row) {
                        $idGrupe = $row['idGrupe'];
                    }
                }
                

                $sql = "SELECT g.id, g.naziv, g.opis, g.slika, k.fullName FROM grupa g JOIN korisnik k ON g.trener = k.id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo
                        '<div class="groupMain">
                            <img src="' .  $row["slika"] . '" alt="Slika grupe" />
                            <div class="groupRight">
                                <div class="groupRightText">
                                    <h2>' . $row["naziv"] . '</h2>
                                    <p>Trener: ' .  $row["fullName"] . '</p>
                                    <p>' .  $row["opis"] . '</p>
                                </div>';
                                echo $idGrupe == $row["id"] ?
                                '<div class="btnLightOutline">Pridruzen</div>' :
                                '<a href="' . (isset($_SESSION['email']) ? "./php/groupActions.php?id=" . $row["id"] . "&action=join" : "./login.php") . '"><div class="btnDark">Pridruzi se</div></a>';
                        echo
                            '</div>
                        </div>';
                    }
                }
            ?>
        </div>
    </section>
</main>
</body>
</html>