<?php
    // connect to database
    try {
        $db = new PDO('mysql:host=localhost;dbname=getflix', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
?>