<?php
    include 'session.php';
    include 'dbconnection.php';
?> 
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="title" content="GetFlix - Movie description">
        <meta name="description" content="Discover all about the movies you like">
        <meta name="keywords" content="Streaming, VOD, GetFlix, Films, Movies, Series, Séries">
        <meta name="robots" content="index, follow">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="language" content="English">
        <meta name="revisit-after" content="10 days">
        <meta name="author" content="GetFlix Team">
        <link rel="shortcut icon" href="assets/images/favicon_getflix.ico"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
        <script type="text/javascript" src="style.js" defer></script>
        <script type="text/javascript" src="getflix.js" defer></script>
        <title>GetFlix</title>
    </head>
   
    <body>
    <!-- HEADER -->
    <?php include 'header.php'; ?>
        <main class="movieCatalog">
        <h2>Top movies</h2>
            <article id="topmovies-container">
        <?php 
            include 'generalsettings.php';

            $key = "76937c618dbc1e05f60d4cd089f3581b";
            $json = file_get_contents("https://api.themoviedb.org/3/trending/movie/day?api_key=$key");
            $result = json_decode($json, true);
            
            for ($i=0; $i< sizeof($result); $i++) {
                echo '<section class="topmovies-layout">';
                echo '<img src="https://image.tmdb.org/t/p/w300'.$result['results'][$i]['poster_path'].'">';
                echo '<h2>'.$result['results'][$i]['original_title'].'</h2>';
                echo '<p>'.$result['results'][$i]['overview'].'</p>';
                echo '<p> Note des utilisateurs : '.(($result['results'][$i]['vote_average'])*10).' %</p>';
                echo '</section>';
            }
        ?>
            </article>

        <img width="300px" src="https://www.themoviedb.org/assets/2/v4/logos/v2/blue_long_1-8ba2ac31f354005783fab473602c34c3f4fd207150182061e425d366e4f34596.svg"/>
        
        </main>
    <?php include 'footer.php' ?>
    </body>
</html>