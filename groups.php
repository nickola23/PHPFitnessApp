<?php session_start()?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/groups.css">
    <title>FitTrack Grupe</title>
</head>
<body>
<?php
    include('./php/header.php');
    include('./php/konekcija.php');
?>
<main>
    <section class="groupsSec">
        <h1>Istrazite grupe</h1>
        <div class="groupsCont">
            <?php
                $sql = "SELECT * FROM grupa";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo
                        '<div class="groupMain">
                            <img src="' .  $row["slika"] . '" alt="Slika grupe" />
                            <div class="groupRight">
                                <div class="groupRightText">
                                    <h2>' . $row["naziv"] . '</h2>
                                    <p>Trener: ' .  $row["trener"] . '</p>
                                    <p>' .  $row["opis"] . '</p>
                                </div> 
                                <div class="btnDark">Pridruzi se</div>' .
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