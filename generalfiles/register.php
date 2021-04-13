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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="shortcut icon" href="assets/images/favicon_getflix.ico"/>
        <link rel="stylesheet" href="../css/style.css" type="text/css"/>
        <title>GetFlix - Register</title>
    </head>
    <body id="registerBody">
    <?php include 'generalfiles/footer.php' ?>
        <main class="boxForm"> 
            <form id="registrationForm" action="generalfiles/newUser.php" method="POST">
                <a  href="../index.php"><img src="assets/images/getflix_logo.png" alt="Logo GetFlix"></a>
                    <div>
                        <input class="form__field" type="text" name="pseudo" id="pseudo" placeholder="Name" pattern="[A-Za-z0-9_]{1,25}" title ="Only letters, digits and _" required>
                        <label class="form__label" for="pseudo">Enter your pseudo *</label>
                    </div>
                    <div>
                        <input class="form__field" type="password" name="password" id="password" placeholder="Password" pattern=".{8,}" title="Eight or more characters" required>
                        <label class="form__label" for="password">Enter your password *</label>
                    </div>
                    <div>
                        <input class="form__field" type="password" name="password2" id="password2" placeholder="Password" required>
                        <label class="form__label" for="password2">Confirm your password *</label>
                    </div>
                    <div>
                        <input class="form__field" type="text" name="email" id="email" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Valid email adress xxx@xx.xx" required>
                        <label class="form__label" for="email">Enter your email *</label>
                    </div>

                    <input class="button" type="submit" name="submit" value="Register">
                    <?php
                      if (!isset($_GET["error"])) {
                        exit();
                      } else {
                        $errorCheck = $_GET['error'];
                        if ($errorCheck == "unmatched") {
                          echo "<p>Passwords don't match.</p>";
                          exit();
                        }
                        elseif ($errorCheck == "emailTaken") {
                          echo "<p>This email is already taken.</p>";
                          exit();
                        }elseif ($errorCheck == "usernameTaken") {
                          echo "<p>This username is already taken.</p>";
                          exit();
                        }
                      }
                    ?>
                <a class="account" href="../index.php"><p>Already have an account ?</p></a>
            </form>
        </main>
    </body>
    <script src="style.js"></script>
</html>

