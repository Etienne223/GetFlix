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
        <script type="text/javascript" src="hoverinfo.js" defer></script>   
        <link rel="stylesheet" href="css/style.css" >
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
        <link rel="shortcut icon" href="assets/images/favicon_getflix.ico"/>
        <title>GetFlix - Found Search</title>
    </head>
    <body>
    <!-- file with results from header search bar -->

    <!-- HEADER -->
    <?php include('header.php'); ?>

    <main class="movieCatalog moviesOtherLists">
    <?php 
    //===================== FROM HEADER.PHP =====================//

    // check if search genre and search info have been clicked
    if (isset($_GET['searchgenre']) && isset($_GET['searchinfo'])) {
        $search_genre = test_input($_GET['searchgenre']);
        $search_info = test_input($_GET['searchinfo']);

        // if genre is empty
        if ($_GET['searchgenre'] == "Genre") {
            // and searchinfo box is filled in -> show only searchinfo matches
            if (!empty($_GET['searchinfo'])) {
                $found = $db->query(" SELECT * FROM movies
                WHERE genre LIKE '%$search_info%'
                OR movie_name LIKE '%$search_info%'
                OR movie_link LIKE '%$search_info%'
                OR movie_description LIKE '%$search_info%'
                ORDER BY ID DESC ");

            // and searchinfo box is empty as well -> redirect to moviescatalog
            } else {
                header('location: moviescatalog.php');
            }
            
        // else if genre is chosen
        } else {
            // and searchinfo box is filled in -> show info matches withing genre
            if (!empty($_GET['searchinfo'])) {
                $found = $db->query(" SELECT * FROM movies
                WHERE genre LIKE '%$search_genre%' AND
                (movie_name LIKE '%$search_info%'
                OR movie_link LIKE '%$search_info%'
                OR movie_description LIKE '%$search_info%')
                ORDER BY ID DESC ");
            
            // and searchinfo box is empty -> show only movies in that genre
            } else {
                $found = $db->query(" SELECT * FROM movies WHERE genre LIKE '%$search_genre%' ");
            }
        }
    }  

    $results = $found->rowCount();
    if ($results === 0) {?>
        <article class="movies-layout">
            <p>No results were found.</p>
        </article>
        <?php
    } else {  
        ?>
        <article class="movies-layout">
            <?php
            while($wasfound = $found->fetch()) {
                $foundid = $wasfound['ID'];
                $foundgenre = $wasfound['genre'];
                $foundmovie_name = $wasfound['movie_name'];
                $foundmovie_img = $wasfound['movie_img'];
                ?>        
                 <div class="movies-box">
                    <div> 
                        <a href="filmdescription.php?film=<?php echo $foundid; ?>">
                            <img class="movies-img" src=<?php echo $foundmovie_img; ?>>
                        </a>
                    </div>
                    <div class="hover-detail">
                        <div class="hover-movie"> 
                            <img class="hover-movie-img" src=<?php echo $foundmovie_img; ?>>
                        </div>
                        <div class="hover-btnsgroup">
                            <!-- play/watch button -->
                            <form action="watch.php" method="get">
                                <button class="hover-btns" type="submit" name="watch" value="<?php echo $foundmovie_name; ?>"><i class="fa fa-play"></i></button>
                            </form>
                            <!-- like/dislike buttons (connection to database down on this same file) -->
                            <form method="post" target="frame">
                                <input type="hidden" name="movie_id" value="<?php echo $foundid; ?>">
                                <input type="hidden" name="movie_name" value="<?php echo $foundmovie_name; ?>">
                                <button class="hover-btns like" type="submit" name="like"><i class="fa fa-heart"></i></button>
                                <button class="hover-btns dislike" type="submit" name="dislike"><i class="fa fa-thumbs-down"></i></button>
                            </form>
                            <!-- more information button -->
                            <form action="filmdescription.php" method="get">
                                <button class="hover-btns" type="submit" name="film" value="<?php echo $foundid; ?>"><i class="fa fa-plus"></i></button>
                            </form>
                        </div>
                        <p><?php echo $foundmovie_name; ?></p>
                        <p><?php echo $foundgenre; ?></p>
                    </div>
                </div>
                <?php
            }
            ?>
        </article>

        <!-- INCLUDE LIKE/DISLIKE ON DATABASE --> 
        <?php include ('likefunction.php'); ?>
        <iframe id="hidden_iframe" name="frame"></iframe> <!-- stop page from reloading when form is submitted -->
   
<?php } ?>

    </main>

    <!-- FOOTER -->
   <?php include('footer.php'); ?>

</body>
</html>
