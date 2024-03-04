<head>
    <link rel="stylesheet" href="./css/header.css">
</head>
<header>
    <a href="index.php" class="headerLogo"><img src="./images/logoBlack.png" alt="Logo"></a>
    <ul class="headerLinks">
        <li><a href="index.php">Pocetna</a></li>
        <li><a href="groups.php">Grupe</a></li>
        <?php 
        if(isset($_SESSION['email'])) echo
        '<li><a href="membership.php">Moja clanarina</a></li>
        <li class="btnDark"><a href="logout.php">Odjavi se</a></li>';
        else echo 
        '<li class="btnDark"><a href="login.php">Prijavi se</a></li>
        <li><a href="register.php">Registruj se</a></li>'; ?>
        
        
    </ul>
</header>