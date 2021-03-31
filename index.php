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
        <link rel="shortcut icon" href="http://localhost/GetFlix/assets/images/favicon.ico"/>
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
        <title>GetFlix - Login</title>
    </head>
    <body id="loginBody">
        <div class="splash">
           <h1 class="fadeIn"><img src="assets/images/getflix_logo_grand.png" alt="getflix_logo"></h1>
        </div>
        <main class="box"> 
            <form id="registrationForm" action="newUser.php" method="POST">
                <img src="assets/images/getflix_logo.png" alt="Logo GetFlix">
                <div>
                    <label class="form__label" for="pseudo">Enter your pseudo</label>
                    <input class="form__field" type="text" name="pseudo" id="pseudo" placeholder="Name" required>
                </div>
                <div>                    
                    <label class="form__label" for="password">Enter your password</label>
                    <input class="form__field" type="password" name="password" id="password" placeholder="Password" required>
                    <a id="lost" class="account" href="lostPassword.php"><p>I forgot my password</p></a>
                </div>
                <input type="submit" name="submit" value="Login">
                <a class="account" href="register.php"><p>No account yet ?</p></a>
            </form>
        </main>
<?php include 'footer.php' ?>
    </body>
    <script src="style.js"></script>
</html>