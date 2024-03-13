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
    <link rel="stylesheet" href="./css/groups.css">
    <link rel="stylesheet" href="./css/groupsAdmin.css">
    <title>FitTrack Admin Grupe</title>
</head>
<body>
<?php
    include('./components/header.php');
    include('./handlers/connection.php');

    if(!isset($_SESSION["email"])) {
        header('Location: index.php');
      }
?>
<main>
    <section class="memHero">
        <div class="secLeft">
        <p>Kreirajte, Izmenite, Obrisite.</p>
        <h1>Sve na jednom mestu</h1>
        <p></p>
        <div class="groupBtns">
            <a href="./groupEdit.php"><div class="btnLight">Dodajte grupe</div></a>
            <a href="./groups.php"><div class="btnLight">Pregledajte grupe</div></a>
        </div>
        
        </div>
        <div class="secRight"></div>
    </section>
    <section class="groupsSec">
        <h1>Izmenite grupe</h1>
        <div class="groupsCont">
            <?php
                $idGrupe = null;
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
                                </div>
                                <div class="groupBtns">
                                    <a href="./handlers/groupActions.php?id=' . $row["id"] . '&action=delete"><div class="btnRedOutline">Obrisi grupu</div></a>
                                </div>
                            </div>
                        </div>';
                    }
                }
                else{
                    echo '
                    <div class="groupMainError">Nema postojecih grupa</div>
                    ';
                }
            ?>
        </div>
    </section>
</main>
</body>
</html>