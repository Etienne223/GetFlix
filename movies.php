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
      <script type="text/javascript" src="Javascript/style.js" defer></script>
      <title>GetFlix - Movies List</title>
    </head>
    <body>
      <!-- HEADER -->
      <?php include 'header.php'; ?>
      <!-- MOVIES -->
      <main class="movieCatalog">
          <article class="complete-container">
        <!-- LAST ADDED MOVIES -->
            <?php 
                // get videos from database
                $request_lastfilm= $db->query('SELECT * FROM movies ORDER BY date DESC LIMIT 0,1');
                while ($lastfilm = $request_lastfilm->fetch()) {
                    echo '<h2>Last added: '.$lastfilm['movie_name'].'</h2>';
                    echo '<iframe class="size-video" src="'.$lastfilm['movie_link'].'"></iframe>';
                }
            ?>
            <h2>New on Getflix</h2>
            <section class="carousel"> 
                <a class="left-arrow"><i class="fas fa-caret-left"></i></a>
                <div class="carouselbox">
                <?php
                $request_newfilms= $db->query('SELECT * FROM movies ORDER BY date DESC LIMIT 0,10');
                  while ($newfilms = $request_newfilms->fetch()) {
                  ?>
                  <div class="movies-box">
                    <div class="movies"> 
                      <a href="filmdescription.php?film=<?php echo $newfilms['ID']; ?>">
                        <img class="movies-img" src=<?php echo $newfilms['movie_img']; ?>>
                      </a>
                    </div>
                      <!-- hover-detail only for tables and desktop -->
                  <div class="hover-detail">
                    <div class="hover-movie"> 
                      <img class="hover-movie-img" src=<?php echo $newfilms['movie_img']; ?>>
                    </div> 
                    <div class="hover-btnsgroup">
                        <!-- play/watch button -->
                      <form action="watch.php" method="get">
                        <button class="hover-btns" type="submit" name="watch" value="<?php echo $newfilms['movie_name']; ?>"><i class="fa fa-play"></i></button>
                      </form>
                        <!-- like/dislike buttons (connection to database down on this same file) -->
                      <form method="post" target="frame">
                          <input type="hidden" name="movie_id" value="<?php echo $newfilms['ID']; ?>">
                          <input type="hidden" name="movie_name" value="<?php echo $newfilms['movie_name']; ?>">
                          <button class="hover-btns like" type="submit" name="like"><i class="fa fa-heart"></i></button>
                          <button class="hover-btns dislike" type="submit" name="dislike"><i class="fa fa-thumbs-down"></i></button>
                      </form>
                        <!-- more information button -->
                      <form action="filmdescription.php" method="get">
                          <button class="hover-btns" type="submit" name="film" value="<?php echo $newfilms['ID']; ?>"><i class="fa fa-plus"></i></button>
                      </form>
                    </div>
                    <p><?php echo $newfilms['movie_name']; ?></p>
                    <p><?php echo $newfilms['genre']; ?></p>
                  </div>
              </div>
                <?php
                }
              ?>
            </div> 
                <a class="right-arrow"><i class="fas fa-caret-right"></i></a>
            </section>
          </article>

          <!-- INCLUDE LIKE/DISLIKE ON DATABASE --> 
          <?php include ('likefunction.php'); ?>
          <iframe id="hidden_iframe" name="frame"></iframe> <!-- stop page from reloading when form is submitted -->
      </main>

      <!-- FOOTER -->
      <?php include('footer.php'); ?>
    </body>
  </html>