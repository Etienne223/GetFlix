<?php 
  include('session.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <title>GetFlix - Movies List</title>
</head>
<body>
    <!-- HEADER -->

    <!-- MOVIES -->
    <main>
        <!-- movies images -->
      
        <article>
            <p>(movies image, like netflix has)</p>
        </article>

        <!-- movies list -->
        <article>
            <?php
            include('dbconnection.php');
            include('generalsettings.php');
            // loop through genre array to display as titles
            for ($i = 0; $i < count($movie_genres); $i++) {?>
                <section class="genres-container">
                    <h2><?php echo $movie_genres[$i]; ?></h2>

                    <div class="images-container"> 
                        <a class="left-arrow"><</a>
                        <a class="right-arrow">></a>

                        <div class="horizontal-movies">
                            <?php 
                            // get videos from database
                            $request_genre = $db->query(" SELECT * FROM movies WHERE genre='$movie_genres[$i]' ");
                            while ($info = $request_genre->fetch()) {
                                $id = $info['ID'];
                                $genre = $info['genre'];
                                $movie_name = $info['movie_name'];
                                $movie_link = $info['movie_link'];
                                
                                // display on screen according to title
                                if ($genre == $movie_genres[$i]) { 
                                    ?>
                                    <div class="movies-box">
                                        <iframe class="movies" src=<?php echo $movie_link; ?>></iframe>
                                        <!-- hover element with information of each movie -->
                                        <div class="hover-detail">
                                            <iframe class="hover-movie" src=<?php echo $movie_link; ?>></iframe>
                                            <div class="hover-btns">
                                                <button value="play" ><i class="fa fa-play"></i></button>
                                                <button value="like"><i class="fa fa-heart"></i></button>
                                                <button value="dislike"><i class="fa fa-heart-broken"></i></button>
                                                <button value="comment"><i class="fa fa-comment"></i></button>
                                                <button value="see-more"><i class="fa fa-plus"></i></button>
                                                <!-- <a href="https://becode.org/"><i class="fa fa-plus"></i></a> -->
                                            </div>
                                            <p><?php echo $movie_name; ?></p>
                                            <p><?php echo $genre; ?></p>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }?> 

                        </div>
                    </div>
                    
                </section><?php
            }?>
        </article>
    </main>

<script src="hover.js"></script>
</body>
</html>