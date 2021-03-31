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
        <title>GetFlix - Register</title>
    </head>
    <body id="registerBody">
        <div id="blur">
            <div id="circle1" class="circle"></div>
            <div id="circle2" class="circle"></div>
        </div>
        <main> 
            <form id="registrationForm" action="index.php" method="POST">
                <img src="assets/images/getflix_logo.png" alt="Logo GetFlix">
                <div>
                    <input class="form__field" type="text" name="pseudo" id="pseudo" placeholder="Name" required>
                    <label class="form__label" for="pseudo">Enter your pseudo</label>
                </div>
                <div>                    
                    <input class="form__field" type="password" name="password" id="password" placeholder="Password" required>
                    <label class="form__label" for="password">Enter your password</label>
                </div>
                <div>                    
                    <input class="form__field" type="password" name="password2" id="password2" placeholder="Password" required>
                    <label class="form__label" for="password2">Confirm your password</label>
                </div>
                <div>
                    <input class="form__field" type="text" name="email" id="email" placeholder="Email" required>
                    <label class="form__label" for="email">Enter your email</label>
                </div>
                <input type="submit" name="submit" value="Login">
                <a class="account" href="index.php"><p>Already an account ?</p></a>
            </form>
        </main>
    </body>
</html>