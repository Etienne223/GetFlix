<?php 
    session_start();

    if (!isset($_SESSION['id']) AND !isset($_SESSION['pseudo']) AND !isset($_SESSION['password']) AND !isset($_SESSION['authorization'])) {
        header('Location: index.php');
    } 
?>