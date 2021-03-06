<?php
    include 'generalfiles/session.php';
    include 'generalfiles/dbconnection.php';
    include 'generalfiles/generalsettings.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <script type="text/javascript" src="Javascript/style.js
        " defer></script> 
        <title>Getflix</title>
    </head>
    <?php 
    /*********** FROM FILMDESCRIPTION.PHP AND MOVIESCATALOG.PHP **********/ 
    
        // if $_Get['watch] set 
            if (isset($_GET['watch'])){
                $watchmovie = test_input($_GET['watch']);         
                // target movie link on this movie with name of the movie
                $answer_watch = $db->prepare('SELECT movie_link FROM movies WHERE movie_name = :movie_name');
                $answer_watch->execute(array(
                    'movie_name'=> $watchmovie
                ));

                $req = $answer_watch->fetch();

            // check if film exists in the database
                if (!$req) {
                    header('Location: moviescatalog.php');
                }

        // if $_Get['watch] not set 
            } else {
                header('Location: moviescatalog.php');
            }
        ?>
    
    <body>
         <!-- HEADER -->
         <?php include 'generalfiles/header.php' ?>
        <main class="movieCatalog">
            <iframe class="size-video" src="<?php echo $req['movie_link']; ?>" allowfullscreen></iframe>
        </main>
    </body>
</html>