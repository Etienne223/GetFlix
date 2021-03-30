<?php
    // Connection to database getflix
    try {
        $bdd = new PDO(
            'mysql:host=localhost; dbname=getflix; charset=utf8', 'root', 'root'
        );
    } catch(Exception $e) {
            die('Erreur : '.$e->getMessage());
    };

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        sleep(1);
        return $data;
    }
?>