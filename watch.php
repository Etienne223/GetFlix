<?php
    include 'session.php';
    include 'dbconnection.php';
            include 'generalsettings.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
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
         <?php include 'header.php' ?>
        <main>
            <iframe width="100%" height="90%" src="<?php echo $req['movie_link']; ?>" allowfullscreen></iframe>
        </main>
    </body>
</html>