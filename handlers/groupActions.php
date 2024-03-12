<?php
    session_start();
    include("../handlers/connection.php");

    if(isset($_GET['id']) && isset($_GET['action']) && isset($_SESSION['email'])) {
        $groupId = $_GET['id'];
        $action = $_GET['action'];
        $email = $_SESSION['email'];
        if($action == 'join') $sql = "UPDATE korisnik SET idGrupe = '$groupId' WHERE email = '$email'";
        else if($action == 'leave') $sql = "UPDATE korisnik SET idGrupe = NULL WHERE email = '$email'";
        else if($action == 'delete'){
            $sql = "UPDATE korisnik SET idGrupe = NULL WHERE idGrupe = $groupId";
            $conn->query($sql);
            $sql = "DELETE FROM grupa WHERE id = '$groupId'";
        }
        else {echo "Greska: Nacin pristupa nije pronadjen"; exit();}
        
        if ($conn->query($sql) === TRUE) {
            if($action == 'delete'){
                header('Location: ../groupsAdmin.php');
                exit();
            }
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