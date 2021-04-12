<?php 
  include ('session.php'); 
  include ('dbconnection.php');
  include ('generalsettings.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="hoverinfo.js" defer></script>    
        <link rel="stylesheet" href="css/style.css" >
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <title>GetFlix - My List</title>
    </head>
    <body>
        <!-- HEADER -->
        <?php include('header.php'); ?>
    <main class="movieCatalog moviesOtherLists">
        <!-- USER FAVORITE MOVIES (same query request from userprofile.php / same html structure from moviescatalog.php) -->
        <h2>My List</h2>
        <article class="movies-layout">
            <?php
            // compare ID (from table movies) and movie_id (from table likes) and create new joined table
            $joinmovieslikes = $db->prepare(" SELECT likes.pseudo, movies.ID, movies.genre, movies.movie_name, movies.movie_img, likes.liked FROM movies INNER JOIN likes ON movies.ID=likes.movie_id WHERE liked = :liked AND pseudo = :pseudo ");
            $joinmovieslikes->execute(array(
                'liked' => 'yes',
                'pseudo' => $_SESSION['pseudo']
            ));

            while($joininfo = $joinmovieslikes->fetch()) {
                $pseudo = $joininfo['pseudo'];
                $id = $joininfo['ID'];
                $genre = $joininfo['genre'];
                $name = $joininfo['movie_name'];
                $img = $joininfo['movie_img'];
                $likes = $joininfo['liked'];
                ?>
                <div class="movies-box">
                    <div class="movies"> 
                        <a href="filmdescription.php?film=<?php echo $id; ?>">
                            <img class="movies-img" src=<?php echo $img; ?>>
                        </a>
                    </div>
                    <div class="hover-detail">
                        <div class="hover-movie"> 
                            
                            <img class="hover-movie-img" src=<?php echo $img; ?>>
                           
                        </div>
                        <div class="hover-btnsgroup">
                            <!-- play/watch button -->
                            <form action="watch.php" method="get">
                                <button class="hover-btns" type="submit" name="watch" value="<?php echo $name; ?>"><i class="fa fa-play"></i></button>
                            </form>
                            <!-- like/dislike buttons (connection to database down on this same file) -->
                           <form method="post" target="frame">
                                <input type="hidden" name="movie_id" value="<?php echo $id; ?>">
                                <input type="hidden" name="movie_name" value="<?php echo $name; ?>">
                                <button class="hover-btns like" type="submit" name="like"><i class="fa fa-heart"></i></button>
                                <button class="hover-btns dislike" type="submit" name="dislike"><i class="fa fa-thumbs-down"></i></button>
                            </form>
                            <!-- more information button -->
                            <form action="filmdescription.php" method="get">
                                <button class="hover-btns" type="submit" name="film" value="<?php echo $id; ?>"><i class="fa fa-plus"></i></button>
                            </form>
                        </div>
                        <div class="hover-detail">
                            <div class="hover-movie"> 
                                
                                <img class="hover-movie-img" src=<?php echo $img; ?>>
                            
                            </div>
                            <div class="hover-btnsgroup">
                                <!-- play/watch button -->
                                <form action="watch.php" method="get">
                                    <button class="hover-btns" type="submit" name="watch" value="<?php echo $name; ?>"><i class="fa fa-play"></i></button>
                                </form>
                                <!-- like/dislike buttons (connection to database down on this same file) -->
                            <form method="post" target="frame">
                                    <input type="hidden" name="movie_id" value="<?php echo $id; ?>">
                                    <input type="hidden" name="movie_name" value="<?php echo $name; ?>">
                                    <button class="hover-btns like" type="submit" name="like"><i class="fa fa-heart"></i></button>
                                    <button class="hover-btns dislike" type="submit" name="dislike"><i class="fa fa-thumbs-down"></i></button>
                                </form>
                                <!-- more information button -->
                                <form action="filmdescription.php" method="get">
                                    <button class="hover-btns" type="submit" name="film" value="<?php echo $id; ?>"><i class="fa fa-plus"></i></button>
                                </form>
                            </div>
                            <p><?php echo $name; ?></p>
                            <p><?php echo $genre; ?></p>
                        </div> 
                    </div>
                <?php
                }?>
            </article>

            <!-- INCLUDE LIKE/DISLIKE ON DATABASE --> 
            <?php include ('likefunction.php'); ?>
            <iframe id="hidden_iframe" name="frame"></iframe> <!-- stop page from reloading when form is submitted -->
    
        </main>

        <!-- FOOTER -->
    <?php include('footer.php'); ?>

    </body>
</html>