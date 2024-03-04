<?php
    session_start();
    include("../database/connection.php");

    if(isset($_GET['id']) && isset($_SESSION['email'])) {
        $groupId = $_GET['id'];
        $action = $_GET['action'];
        $email = $_SESSION['email'];
        if($action == 'join') $sql = "UPDATE korisnik SET idGrupe = '$groupId' WHERE email = '$email'";
        else if($action == 'leave') $sql = "UPDATE korisnik SET idGrupe = NULL WHERE email = '$email'";
        else {echo "Greska: Nacin pristupa nije pronadjen"; exit();}
        
        if ($conn->query($sql) === TRUE) {
            header('Location: ../groups.php');
            exit();
        }
        else{
            echo "Greska: " . $conn->error;
            exit();
        }
    }
    else{
        header('Location: ../index.php');
        exit();
    }
?>