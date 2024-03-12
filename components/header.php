<head>
    <link rel="stylesheet" href="./css/header.css">
</head>
<header>
    <div class="headerLogos">
        <a href="index.php" class="headerLogoIcon"><img src="./images/logoBlackIcon.png" alt="Logo"></a>
        <a href="index.php" class="headerLogo"><img src="./images/logoBlack.png" alt="Logo"></a>
    </div>
    <ul class="headerLinks">
        <li><a href="index.php">Pocetna</a></li>
        <li><a href="groups.php">Grupe</a></li>
        <?php 
        include("./handlers/connection.php");
        if(isset($_SESSION['email'])){ 
            $email = $_SESSION['email'];
            $sql = "SELECT admin FROM korisnik WHERE email = '$email'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if($row["admin"]){
                echo '<li><a href="groupsAdmin.php">Izmeni grupe</a></li>';
            }
            echo
            '<li><a href="membership.php">Moja clanarina</a></li>
            <li class="btnDark"><a href="./handlers/logout.php">Odjavi se</a></li>';
        }
        else echo 
        '<li class="btnDark"><a href="login.php">Prijavi se</a></li>
        <li><a href="register.php">Registruj se</a></li>'; ?>
        
        
    </ul>
</header>