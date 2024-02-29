<?php session_start()?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/global.css">
    <title>FitTrack Grupe</title>
</head>
<body>
<?php
    include('./php/header.php');
    include('./php/konekcija.php');
?>
<main>
    <h1>Sve grupe</h1>

    <?php
        $sql = "SELECT * FROM grupa";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<p>Naziv:" . $row["naziv"] . ", trener:" .  $row["trener"] . "</p>";
            }
        }
    ?>
</main>
</body>
</html>