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
    <script type="text/javascript" src="moviescatalog.js" defer></script>    
    <link rel="stylesheet" href="moviescatalog.css" />
    <!-- <link rel="stylesheet" href="css/style.css" > -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">  
    <title>GetFlix - Movies List</title>
</head>

<body>
  <!-- HEADER -->
  <?php //include('header.php'); ?>

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
              <a class="right-arrow">></a>
          </section><?php
        }?>
    </article>

    <?php
    /******** INCLUDE LIKE/DISLIKE ON DATABASE ********/
    function liked($answer) {
      include ('session.php'); 
      include ('dbconnection.php');
      
      $pseudo = $_SESSION['pseudo'];
      $movie_id = $_POST['movie_id'];
      $movie_name = $_POST['movie_name'];
      $liked = $answer;

      // check on database if this movie has already inputs
      $checklike = $db->query(" SELECT liked FROM likes WHERE movie_id=$movie_id ");

      if($checklike->rowCount() == 0) { //(not found, insert everything)
          $includelike = $db->prepare(" INSERT INTO likes(pseudo, movie_id, movie_name, liked) VALUES (:pseudo, :movie_id, :movie_name, :liked) ");
          $includelike->execute(array(
              'pseudo' => $pseudo,
              'movie_id'=> $movie_id,
              'movie_name'=> $movie_name,
              'liked'=> $liked
          ));

      } else { //(found, then just update liked field to new one)
          $updatelike = $db->query(" UPDATE likes SET liked='$liked' WHERE movie_id=$movie_id ");
      }
    }

    // LIKE
    if(isset($_POST['like'])) {
      liked("liked");

    // DISLIKED    
    } elseif(isset($_POST['dislike'])) {
      liked("disliked");
    }

  ?>

  
  <iframe id="hidden_iframe" name="frame"></iframe> <!-- stop page from reloading when form is submitted -->
  </main>


   <!-- FOOTER -->
   <?php //include('footer.php'); ?>

</body>
</html>