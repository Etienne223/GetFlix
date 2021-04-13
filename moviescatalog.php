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
      <meta name="title" content="GetFlix - Movie description">
      <meta name="description" content="Discover all about the movies you like">
      <meta name="keywords" content="Streaming, VOD, GetFlix, Films, Movies, Series, Séries">
      <meta name="robots" content="index, follow">
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta name="language" content="English">
      <meta name="revisit-after" content="10 days">
      <meta name="author" content="GetFlix Team">
      <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
      <link rel="stylesheet" href="css/style.css" >
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
      <link rel="shortcut icon" href="assets/images/favicon_getflix.ico"/>
      <script type="text/javascript" src="style.js" defer></script>
      <script type="text/javascript" src="getflix.js" defer></script>
      <script type="text/javascript" src="moviescatalog.js" defer></script>   
      <script type="text/javascript" src="hoverinfo.js" defer></script>   
      <title>GetFlix - Movies List</title>
    </head>
    <body>
      <!-- HEADER -->
      <?php include('header.php'); ?>
  
      <!-- MOVIES -->
      <main class="movieCatalog">
          <article class="complete-container">
          <?php
            // loop through genre array to display as titles
            for ($i = 0; $i < count($movie_genres); $i++) {?>
            <section class="genre">
              <h2><?php echo $movie_genres[$i]; ?></h2>
            </section>
            <section class="carousel"> 
                <a class="left-arrow"><i class="fas fa-caret-left"></i></a>
                <div class="carouselbox"><?php
                    // get videos from database
                  $request_genre = $db->query(" SELECT * FROM movies WHERE genre='$movie_genres[$i]' ");
                  while ($info = $request_genre->fetch()) {
                    $id = $info['ID'];
                    $genre = $info['genre'];
                    $movie_name = $info['movie_name'];
                    $movie_img = $info['movie_img'];
                    $movie_link = $info['movie_link'];
                    if ($genre == $movie_genres[$i]) { ?>
                  <div class="movies-box">
                    <div class="movies"> 
                      <a href="filmdescription.php?film=<?php echo $id; ?>">
                        <img class="movies-img" src=<?php echo $movie_img; ?>>
                      </a>
                    </div>
                      <!-- hover-detail only for tables and desktop -->
                  <div class="hover-detail">
                    <div class="hover-movie"> 
                      <img class="hover-movie-img" src=<?php echo $movie_img; ?>>
                    </div> 
                    <div class="hover-btnsgroup">
                        <!-- play/watch button -->
                      <form action="watch.php" method="get">
                        <button class="hover-btns" type="submit" name="watch" value="<?php echo $movie_name; ?>"><i class="fa fa-play"></i></button>
                      </form>
                        <!-- like/dislike buttons (connection to database down on this same file) -->
                      <form method="post" target="frame">
                          <input type="hidden" name="movie_id" value="<?php echo $id; ?>">
                          <input type="hidden" name="movie_name" value="<?php echo $movie_name; ?>">
                          <button class="hover-btns like" type="submit" name="like"><i class="fa fa-heart"></i></button>
                          <button class="hover-btns dislike" type="submit" name="dislike"><i class="fa fa-thumbs-down"></i></button>
                      </form>
                        <!-- more information button -->
                      <form action="filmdescription.php" method="get">
                          <button class="hover-btns" type="submit" name="film" value="<?php echo $id; ?>"><i class="fa fa-plus"></i></button>
                      </form>
                    </div>
                    <p><?php echo $movie_name; ?></p>
                    <p><?php echo $genre; ?></p>
                  </div>
              </div>
                <?php
                }
                }
              ?>
            </div> 
                <a class="right-arrow"><i class="fas fa-caret-right"></i></a>
            </section><?php
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