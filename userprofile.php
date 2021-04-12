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
    <link rel="stylesheet" href="userprofile.css" >
    <link rel="stylesheet" href="css/style.css" >
    <script type="text/javascript" src="moviescatalog.js" defer></script>   
    <script type="text/javascript" src="hoverinfo.js" defer></script>   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>GetFlix - User Profile</title>
</head>
<body>

    <!-- HEADER -->
    <?php include('header.php'); ?>


    <!-- USER PROFILE INFOMATION -->
    <main class="userProfile">
        <!-- USER INFORMATION -->
        <article>
            <h2>Personal Information</h2>
            <?php
            $get_userdata = $db->prepare(" SELECT date_insc, mail FROM users WHERE id = :id");
            $get_userdata->execute(array('id'=> $_SESSION['id']));
            while ($userdata = $get_userdata->fetch()) {
                $date = $userdata['date_insc'];
                $email = $userdata['mail'];
            } ?>
            <p>Pseudo: <?php echo ucfirst($_SESSION['pseudo']); ?></p>
            <p>Password: ********</p>
            <p>E-mail: <?php echo $email; ?></p>
            <p>Member since: <?php echo $date; ?></p>   
        </article>


        <!-- USER FAVORITE MOVIES -->
        <article>
            <h2>Your Favorites</h2>
            <section class="carousel">
                <a class="left-arrow"><i class="fas fa-caret-left"></i></a>
                <div class="carouselbox">
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
                            <!-- hover-detail only for tables and desktop -->
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
                                    <button class="hover-btns" type="submit" name="like"><i class="fa fa-heart"></i></button>
                                    <button class="hover-btns" type="submit" name="dislike"><i class="fa fa-thumbs-down"></i></button>
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
                </div> 
                <a class="right-arrow"><i class="fas fa-caret-right"></i></a>
            </section>
        </article>


        <!-- CHECK AND MANAGE THEIR LIKES, DISLIKES AND COMMENTS -->
        <article>
            <h2>Your Interactions</h2>
            
            <?php // [PHP SEARCH] FILTER OPTIONS FOR FORM BELOW
            function setQuery($andwhere1, $andwhere2) {
                include ('dbconnection.php');
                $gettable = $db->prepare(" SELECT comments.movie_id, comments.movie_name, comments.comment, likes.liked
                FROM comments
                LEFT JOIN likes
                ON likes.movie_id = comments.movie_id AND likes.pseudo = comments.pseudo
                WHERE comments.pseudo like :pseudo1 $andwhere1
                UNION
                SELECT likes.movie_id, likes.movie_name, comments.comment, likes.liked
                FROM comments
                RIGHT JOIN likes
                ON likes.movie_id = comments.movie_id AND likes.pseudo = comments.pseudo
                WHERE likes.pseudo like :pseudo2 $andwhere2  ");
                $gettable->execute(array('pseudo1' => $_SESSION['pseudo'], 'pseudo2' => $_SESSION['pseudo'] ));
                return $gettable;
            }


            // possibilities of results depending on filter inputs
            if( isset($_POST['submitsearch']) ) { 
                $search_movie = test_input($_POST['searchmovie']);
                $search_ifliked = test_input($_POST['ifliked']);
                $search_comment = test_input($_POST['searchcomment']);
            
                //=========== MOVIE ===========//
                // if movie -> set, likes -> see all, comments -> not set
                 if( !empty($search_movie) AND $search_ifliked == 'seeall' AND empty($search_comment) ) { 
                    $w1 = "AND comments.movie_name LIKE '%$search_movie%'";
                    $w2 = "AND likes.movie_name LIKE '%$search_movie%'";
                    $joinlikescomments = setQuery($w1, $w2);

                // if movie -> set, likes -> liked, comments -> not set
                } elseif( !empty($search_movie) AND $search_ifliked == 'yes' AND empty($search_comment) ) {
                    $w1 = "AND comments.movie_name LIKE '%$search_movie%' AND likes.liked LIKE '%$search_ifliked%' ";
                    $w2 = "AND likes.movie_name LIKE '%$search_movie%' AND likes.liked LIKE '%$search_ifliked%' ";
                    $joinlikescomments = setQuery($w1, $w2);

                // if movie -> set, likes -> dislike, comments -> not set
                } elseif( !empty($search_movie) AND $search_ifliked == 'no' AND empty($search_comment) ) {
                    $w1 = "AND comments.movie_name LIKE '%$search_movie%' AND likes.liked LIKE '%$search_ifliked%' ";
                    $w2 = "AND likes.movie_name LIKE '%$search_movie%' AND likes.liked LIKE '%$search_ifliked%' ";
                    $joinlikescomments = setQuery($w1, $w2);
                

                //=========== COMMENTS ===========//
                // if movie -> not set, likes -> see all, comments -> set
                } elseif( empty($search_movie) AND $search_ifliked == 'seeall' AND !empty($search_comment) ) {
                    $w1 = "AND comments.comment LIKE '%$search_comment%'";
                    $w2 = "AND comments.comment LIKE '%$search_comment%'";
                    $joinlikescomments = setQuery($w1, $w2);

                // if movie -> not set, likes -> liked, comments -> set
                } elseif( empty($search_movie) AND $search_ifliked == 'yes' AND !empty($search_comment) ) {
                    $w1 = "AND comments.comment LIKE '%$search_comment%' AND likes.liked LIKE '%$search_ifliked%' ";
                    $w2 = "AND comments.comment LIKE '%$search_comment%' AND likes.liked LIKE '%$search_ifliked%' ";
                    $joinlikescomments = setQuery($w1, $w2);

                // if movie -> not set, likes -> dislike, comments -> set
                } elseif( empty($search_movie) AND $search_ifliked == 'no' AND !empty($search_comment )) {
                    $w1 = "AND comments.comment LIKE '%$search_comment%' AND likes.liked LIKE '%$search_ifliked%' ";
                    $w2 = "AND comments.comment LIKE '%$search_comment%' AND likes.liked LIKE '%$search_ifliked%' ";
                    $joinlikescomments = setQuery($w1, $w2);


                //=========== LIKES/DISLIKES ===========//
                // if movie -> not set, likes -> see all, comments -> not set
                } elseif ( empty($search_movie) AND $search_ifliked == 'seeall' AND empty($search_comment) ) {
                    $w1 = ""; // don't include where
                    $w2 = ""; // don't include where
                    $joinlikescomments = setQuery($w1, $w2);

                // if movie -> not set, likes -> liked, comments -> not set    
                } elseif ( empty($search_movie) AND $search_ifliked == 'yes' AND empty($search_comment) ) {
                    $w1 = "AND likes.liked LIKE '%$search_ifliked%'";
                    $w2 = "AND likes.liked LIKE '%$search_ifliked%'";
                    $joinlikescomments = setQuery($w1, $w2);

                // if movie -> not set, likes -> dislike, comments -> not set    
                } elseif ( empty($search_movie) AND $search_ifliked == 'no' AND empty($search_comment) ) {
                    $w1 = "AND likes.liked LIKE '%$search_ifliked%'";
                    $w2 = "AND likes.liked LIKE '%$search_ifliked%'";
                    $joinlikescomments = setQuery($w1, $w2);


                //=========== ALL ===========//
                // if movie -> set, likes -> see all, comments -> set
                } elseif( !empty($search_movie) AND $search_ifliked == 'seeall' AND !empty($search_comment) ) {
                    $w1 = "AND comments.movie_name LIKE '%$search_movie%' AND comments.comment LIKE '%$search_comment%' ";
                    $w2 = "AND likes.movie_name LIKE '%$search_movie%' AND comments.comment LIKE '%$search_comment%' ";
                    $joinlikescomments = setQuery($w1, $w2);
                    

                // if movie -> set, likes -> liked, comments -> set
                } elseif(!empty($search_movie) AND $search_ifliked == 'yes' AND !empty($search_comment) ) {
                    $w1 = "AND comments.movie_name LIKE '%$search_movie%' AND comments.comment LIKE '%$search_comment%' AND likes.liked LIKE '%$search_ifliked%'";
                    $w2 = "AND likes.movie_name LIKE '%$search_movie%' AND comments.comment LIKE '%$search_comment%' AND likes.liked LIKE '%$search_ifliked%'";
                    $joinlikescomments = setQuery($w1, $w2);

                // if movie -> set, likes -> disliked, comments -> set
                } elseif(!empty($search_movie) AND $search_ifliked == 'no' AND !empty($search_comment) ) {
                    $w1 = "AND comments.movie_name LIKE '%$search_movie%' AND comments.comment LIKE '%$search_comment%' AND likes.liked LIKE '%$search_ifliked%'";
                    $w2 = "AND likes.movie_name LIKE '%$search_movie%' AND comments.comment LIKE '%$search_comment%' AND likes.liked LIKE '%$search_ifliked%'";
                    $joinlikescomments = setQuery($w1, $w2);
                } 
                        
            } else {
                $w1 = ""; // don't include where
                $w2 = ""; // don't include where
                $joinlikescomments = setQuery($w1, $w2);
            }
            
            
            $results = $joinlikescomments->rowCount();
            if ($results === 0) {?>
                <article>
                    <p>No results were found with this filter.</p>
                </article>
                <?php
            } else {  
            ?>
            <section>
                <form method="POST">
                    <input name="searchmovie" type="text" placeholder="Search movie..."/>

                    <select name="ifliked">
                        <option value="seeall">see all likes/dislikes</option>
                        <option value="yes">liked</option>
                        <option value="no">disliked</option>
                    </select>

                    <input name="searchcomment" type="text" placeholder="Search comment..."/>  

                    <button class="mods" type="submit" name="submitsearch"><i class="fa fa-search"></i></button>
                </form>
            </section>

            <table id="table-interactions">
                <tr>
                    <th>Movie</th>
                    <th>Liked?</th>
                    <th>Comment</th>
                    <th>View</th>
                </tr>
                <?php
                while($joininfo = $joinlikescomments->fetch()) {
                    $id = $joininfo['movie_id'];
                    $name = $joininfo['movie_name'];
                    $likes = $joininfo['liked'];
                    $comment = $joininfo['comment'];  
                    ?>    
                    <tr>
                        <td><?php echo $name; ?></td>
                        <td>
                            <?php if ($likes == "yes") {
                                ?><i class="fa fa-heart"></i><?php
                            } elseif ($likes == "no") {
                                ?><i class="fa fa-thumbs-down"></i><?php
                            } else {
                                echo "";
                            }; ?>
                        </td>
                        <td><?php echo $comment; ?></td>
                        <td>
                        <form action="filmdescription.php" method="get">
                            <button class="mods" type="submit" name="film" value="<?php echo $id; ?>"><i class="fa fa-eye"></i></button>
                        </form>
                        </td>
                    </tr>
                <?php
                }?>
            </table>
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