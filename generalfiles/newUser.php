<?php
require 'generalsettings.php';
require 'dbconnection.php';
if (isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['email'])){

    // RECUPARATION DES VARIABLES DU FORMULAIRE EN UTILISANT STRIP_TAGS POUR EVITER LE CODE MALVEILLANT
    $nickname = strip_tags($_POST['pseudo']);
    $nickname = test_input($nickname);
    $email = strip_tags($_POST['email']);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // CRYPTE LE MOT DE PASS
    $password2 = $_POST['password2'];
    $date = date("Y-m-d");
    $authorization = 0; // AUTHORIZATION - DETERMINE SI L'USER EST ADMIN OU NON 0 = FALSE / 1 = TRUE

    //CHECK 2 PASSWORDS IDENTIQUES
    if ($password !== $password2) {
      $error = "unmatched";
    }
    //CHECK SI EMAIL EXISTE DEJA
    $requete = $db->prepare("SELECT * FROM users WHERE mail = ?");
    $requete->execute([$email]);
    $resultat = $requete->rowCount();
    if ($resultat > 0) {
      $error = "emailTaken";
    }

    //CHECK SI USER EXIST DEJA
    $requete = $db->prepare("SELECT * FROM users WHERE pseudo = ?");
    $requete->execute([$nickname]);
    $result = $requete->rowCount();
    if($result > 0) {
      $error = "usernameTaken"; }

    //Intégration dans db
    if(empty($error)){
      $requete = $db-> prepare('INSERT INTO users(pseudo, password, mail, date_insc, authorization) VALUES(?, ?, ?, ?, ?)'); // INTEGRE LES VALEUR PROVENANT DU FORM DANS LA db
      $requete->execute(array($nickname, $hashed_password, $email, $date, $authorization));
      header('Location: ../index.php'); // REDIRIGE VERS LA PAGE DE CONNEXION UNE FOIS QUE L'UTILISATEUR S'EST ENREGISTRE
      exit;
    } else {
      header('Location: register.php?error='.$error);
    }
  }
?>
