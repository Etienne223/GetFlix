<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="GetFlix - Accueil">
    <meta name="description" content="Bienvenue sur la page de connexion à GetFlix - ABONNEZ-VOUS à notre énorme catalogue de vidéo à la demande. ">
    <meta name="keywords" content="Streaming, VOD, GetFlix, Films, Movies, Series, Séries">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <meta name="revisit-after" content="10 days">
    <meta name="author" content="GetFlix Team">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="shortcut icon" href="assets/images/favicon.ico"/>
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
    <title>GetFlix - Login</title>
</head>
<body>

<form action="login.php" method="POST">
    <fieldset>
        <legend>Register Form</legend>
            <label for="pseudo">Enter your pseudo</label>
            <input type="text" name="pseudo" id="pseudo" required>
            <label for="password">Enter your password</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">Login</button>
    </fieldset>
</form>

<?php
    $bdd = new PDO('mysql:host=localhost;dbname=getflix', 'root', 'root');
    // SI PSEUDO ET PASSWORD SONT ISSET : RECHERCHE DANS LE TABLEAU L'ID ET LE PASSWORD CORRESPONDANT AU PSEUDO ENTRER
    if(isset($_POST['pseudo']) && isset($_POST['password'])){
    $pseudo = $_POST['pseudo'];
    $req = $bdd->prepare('SELECT id, password, authorization FROM users WHERE pseudo = :pseudo');
    $req->execute(array('pseudo' => $pseudo));
    $resultat = $req->fetch();

    // SI MOT DE PASSE != MOT DE PASSE CORRESPONDANT AU PSEUDO DANS LA BDD => MESSAGE D'ERREUR
    $isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);
        if (!$resultat){
            echo '<p>Mauvais identifiant ou mot de passe !</p>';
        }
        // SI MOT DE PASSE + MOT DE PASSE CORRESPONDANT AU PSEUDO -> CREATION D'UNE SESSION ET REDIRECTION VERS LA PAGE DE FILM
        else{
            if ($isPasswordCorrect){
                session_start();
                $_SESSION['id'] = $resultat['id'];
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['password'] = $resultat;
                $_SESSION['authorization'] = $resultat['authorization'];
                header('Location: browse.php'); 
            }
            else {
                echo 'Mauvais identifiant ou mot de passe !';
            }
        }
    }
?>
</body>
</html>