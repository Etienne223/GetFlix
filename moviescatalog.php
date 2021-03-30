<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>GitFlix - Movies List</title>
</head>
<body>
<?php
//if (isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['email'])){
    ?>
    <!-- HEADER -->

    <!-- MOVIES -->
    <main id="main-content">
        <!-- movies images -->
        <article class="article">
            (movies image, like netflix has)
        </article>

        <!-- movies list -->
        <article class="article">
            <?php
            include('dbconnection.php');
            include('generalsettings.php');
            // loop through genre array to display as titles
            for ($i = 0; $i < count($movie_genres); $i++) {
                ?>
                <section class="genre-box">
                    <h2><?php echo $movie_genres[$i]; ?><h2>
                    <?php 
                    // get videos from database and display on screen according to title
                    $request_action = $database->query(" SELECT * FROM movies WHERE genre='$movie_genres[$i]' ");
                    while ($info = $request_action->fetch()) {
                        $genre_action = $info['genre'];
                        $movie_link = $info['movie_link'];
                        
                        if ($genre_action == $movie_genres[$i]) { 
                            ?>
                            <div class="horizontal-movies">
                            <iframe width="280" height="200" src=<?php echo $movie_link; ?>></iframe>
                            </div>
                            <?php
                        }
                    }              
                    ?>
                </section>
                <?php
            }
            ?>
        </article>
    </main>
<php            
//}
?>
</body>
</html>

<!--
    https://www.magictoolbox.com/magicscroll/integration/
    https://element.how/elementor-horizontal-scroll-section/
-->
