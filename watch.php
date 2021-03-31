<?php
    include 'session.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="getflix.js" defer></script>
        <title>Getflix</title>
    </head>
    <body>
        <?php 
            include 'dbconnection.php';
            include 'generalsettings.php';
        ?>

        <main>
        <?php 
            if (isset($_GET['watch'])){
                $watchmovie = test_input($_GET['watch']);
            
                // target movie link on this movie with name of the movie
                $answer_watch = $db->prepare('SELECT movie_link FROM movies WHERE movie_name = :movie_name');
                $answer_watch->execute(array(
                    'movie_name'=> $watchmovie
                ));

                while ($data_watch = $answer_watch->fetch()){
        ?>
            <iframe width="100%" height="90%" src="<?php echo $data_watch['movie_link']; ?>" allowfullscreen></iframe>
        <?php
                }
            }
        
            /* 
            // target infos on this movie with id
                $answer_thismovie = $db->prepare('SELECT * FROM movies WHERE ID = :id');
                $answer_thismovie->execute(array(
                    'id'=> $thismovieid
                ));

                while ($data_thismovie = $answer_thismovie->fetch()){
                    $thismoviename = $data_thismovie['movie_name'];
                    $thismovielink = $data_thismovie['movie_link'];
                    $thismoviedescription = $data_thismovie['movie_description']; */
            ?>
    
        </main>
    </body>
</html>