<?php 
session_start();
include 'login.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="title" content="GetFlix - Accueil">
        <meta name="description" content="Bienvenue sur la page d'accueil de GetFlix - ABONNEZ-VOUS à notre énorme catalogue de vidéo à la demande. ">
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
    <body id="loginBody">
        <main> 
            <form id="registrationForm" action="index.php" method="POST">
                <img src="assets/images/getflix_logo.png" alt="Logo GetFlix">
                    <div>
                        <label class="form__label" for="pseudo">Enter your pseudo</label>
                        <input class="form__field" type="text" name="pseudo" id="pseudo" placeholder="Name" required>
                    </div>
                    <div>                    
                        <label class="form__label" for="password">Enter your password</label>
                        <input class="form__field" type="password" name="password" id="password" placeholder="Password" required>
                    </div>
                    <div>                    
                        <label class="form__label" for="RememberMe">Remember me</label>
                        <input class="form__field" type="checkbox" name="RememberMe" id="remember"  >
                    </div>
                    <input type="submit" name="submit" value="Login">
            </form>
        </main>
    </body>
</html>