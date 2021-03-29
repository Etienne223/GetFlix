<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netflix</title>
</head>
<body>
    <?php 
        include 'dbconnection.php';
        // TEMPORARY FOR TEST
        $answer_movies = $bdd->query(
            'SELECT movie_link FROM movies'
        );
    ?>
    <main>
        <p> hey </p>
        <?php 
            while ($movie = $answer_movies->fetch()) {
        ?>
        }
        <iframe width="420" height="315" src="https://www.youtube.com/watch?v=sGbxmsDFVnE" allowfullscreen></iframe>
            
        <?php
            }
        ?>
        <object width="560" height="315" src="https://www.youtube.com/embed/sGbxmsDFVnE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></object>
    </main>
</body>
</html>