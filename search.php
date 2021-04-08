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
        <script type="text/javascript" src="moviescatalog.js" defer></script>  
        <link rel="stylesheet" href="css/style.css" >
        <link rel="stylesheet" href="moviescatalog.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
        <title>GetFlix - Found Search</title>
    </head>
    <body>
    <!-- file with results from header search bar -->

    <!-- HEADER -->
    <?php include('header.php'); ?>

    <main>
    <?php 

    // search info (genre or movie name) on whole database
        if (isset($_GET['searchinfo'])) {
            $search_info = test_input($_GET['searchinfo']);
            if (!empty($_GET['searchinfo'])){
                $found = $db->query(" SELECT * FROM movies WHERE genre LIKE '%$search_info%' OR movie_name LIKE '%$search_info%' OR movie_description LIKE '%$search_info%' ");
            } 
        }
        
    ?>
        <article>
            <?php
            while($wasfound = $found->fetch()) {
                $foundid = $wasfound['ID'];
                $foundgenre = $wasfound['genre'];
                $foundmovie_name = $wasfound['movie_name'];
                $foundmovie_img = $wasfound['movie_img'];

                ?>
                <!-- <p><?php //echo $foundgenre; ?></p>
                <p><?php //echo $foundmovie_name; ?></p>
                <img src="<?php //echo $foundmovie_img; ?>"> -->

                
                 <div class="movies-box">
                    <div> 
                        <img class="movies-img" src=<?php echo $foundmovie_img; ?>>
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
    </main>


    <!-- FOOTER -->
   <?php include('footer.php'); ?>

</body>
</html>
