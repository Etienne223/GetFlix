<?php 
  // include('session.php'); 
  include('dbconnection.php');
  include('generalsettings.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="moviescatalog.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <title>GetFlix - Movies List</title>
</head>

<body>
  <!-- HEADER -->


  <!-- MOVIES -->
  <main>
    <article id="netflix-images">
      <p>(movies image, like netflix has)</p>
    </article>


    <article class="complete-container"><?php
        // loop through genre array to display as titles
        for ($i = 0; $i < count($movie_genres); $i++) {?>
          <section class="genre">
            <h2><?php echo $movie_genres[$i]; ?></h2>
          </section>

          <section class="carousel"> 
              <a class="left-arrow"><</a>
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
                              <img class="movies-img" src=<?php echo $movie_img; ?>>
                            </div>

                            <!-- hover-detail only for tables and desktop -->
                            <div class="hover-detail">
                                <div class="hover-movie"> 
                                    <img class="hover-movie-img" src=<?php echo $movie_img; ?>>
                                </div>
                                <div class="hover-btnsgroup">
                                    <a href="#" class="hover-btns play" ><i class="fa fa-play"></i></a>
                                    <a href="#" class="hover-btns like"><i class="fa fa-heart"></i></a>
                                    <a href="#" class="hover-btns dislike"><i class="fa fa-heart-broken"></i>dislike</a>
                                    <a href="#" class="hover-btns comment"><i class="fa fa-comment"></i></a>
                                    <a href="#" class="hover-btns see-more"><i class="fa fa-plus"></i></a>
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
              <a class="right-arrow">></a>
          </section><?php
        }?>
</article>
  </main>
  <script src="moviescatalog.js"></script>
</body>
</html>