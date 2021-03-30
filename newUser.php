<?php
if (isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['email'])){
    // RECUPARATION DES VARIABLES DU FORMULAIRE EN UTILISANT STRIP_TAGS POUR EVITER LE CODE MALVEILLANT
    $nickname = strip_tags($_POST['pseudo']); 
    $email = strip_tags($_POST['email']);
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // CRYPTE LE MOT DE PASS
    $date = date("Y-m-d");
    $authorization = 0; // AUTHORIZATION - DETERMINE SI L'USER EST ADMIN OU NON 0 = FALSE / 1 = TRUE

    $bdd = new PDO('mysql:host=localhost;dbname=getflix', 'root', 'root'); // CONNEXION A LA BDD
    $requete = $bdd-> prepare('INSERT INTO users(pseudo, password, mail, date_insc, authorization) VALUES(?, ?, ?, ?, ?)'); // INTEGRE LES VALEUR PROVENANT DU FORM DANS LA BDD
    $requete->execute(array($nickname, $hashed_password, $email, $date, $authorization)); 

    header('Location:index.php'); // REDIRIGE VERS LA PAGE DE CONNEXION UNE FOIS QUE L'UTILISATEUR S'EST ENREGISTRE
    exit;
}
?> 