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
    <!-- <link rel="stylesheet" href="css/style.css" > -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">  
    <title>GetFlix - User Profile</title>
</head>
<body>

    <!-- HEADER -->
    <?php include('header.php'); ?>


    <!-- USER PROFILE INFOMATION -->
    <main>

        <!-- USER INFORMATION -->
        <article>
            <h2>Personal Information</h2>
            <?php
            $get_userdata = $db->query(" SELECT date_insc, mail FROM users ");
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
            <?php
            // compare ID (from table movies) and movie_id (from table likes) and create new joined table
            $joinmovieslikes = $db->query(" SELECT likes.pseudo, movies.ID, movies.movie_name, movies.movie_img, likes.liked FROM movies INNER JOIN likes ON movies.ID=likes.movie_id WHERE liked='liked' ");
            while($joininfo = $joinmovieslikes->fetch()) {
                $pseudo = $joininfo['pseudo'];
                $id = $joininfo['ID'];
                $name = $joininfo['movie_name'];
                $img = $joininfo['movie_img'];
                $likes = $joininfo['liked'];
                //echo $pseudo . " " . $id . " " . $name . " " .$img . " " . $likes . "<br>";
                ?>
                <p><?php echo $name; ?></p>
                <img src=<?php echo $img; ?>> 
            <?php
            }?>
        </article>


        <!-- CHECK AND MANAGE THEIR LIKES, DISLIKES AND COMMENTS -->
        <article>
            <h2>Your Interactions</h2>
            <table>
                <tr>
                    <th>Movie</th>
                    <th>Liked?</th>
                    <th>Comment</th>
                    <th>View</th>
                </tr>
                <!-- [INPUT] filter options for each column -->
                <tr>
                    <td> <!-- search by movie name -->
                        <form method="get">
                            <input name="searchmovie" type="text" placeholder="Search movie..."/>
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </td>
                    <td> <!-- search by like/dislike -->
                        <form method="get">
                            <select name="ifliked">
                                <option value="seeall" selected="selected">see all</option>
                                <option value="empty">---</option>
                                <option value="liked">liked</option>
                                <option value="disliked">disliked</option>
                            </select>
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </td>
                    <td> <!-- search by movie comment -->
                        <form method="get">
                            <input name="searchcomment" type="text" placeholder="Search comment..."/>
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </td>
                </tr>

                <?php
                // [PHP SEARCH] FILTER OPTIONS FOR EACH COLUMN
                    // search by movie name 
                    if(isset($_GET['searchmovie'])) {
                        $search_movie = test_input($_GET['searchmovie']);
                        if(!empty($search_movie)) {   
                            $joinlikescomments = $db->query(" SELECT comments.movie_id, comments.movie_name, comments.comment, likes.liked
                            FROM comments
                            LEFT JOIN likes
                            ON likes.movie_id = comments.movie_id AND comments.movie_name LIKE '%$search_movie%'
                            UNION
                            SELECT likes.movie_id, likes.movie_name, comments.comment, likes.liked
                            FROM comments
                            RIGHT JOIN likes
                            ON likes.movie_id = comments.movie_id AND likes.movie_name LIKE '%$search_movie%' "); 

                        } else {
                            $joinlikescomments = $db->query(" SELECT comments.movie_id, comments.movie_name, comments.comment, likes.liked
                            FROM comments
                            LEFT JOIN likes
                            ON likes.movie_id = comments.movie_id
                            UNION
                            SELECT likes.movie_id, likes.movie_name, comments.comment, likes.liked
                            FROM comments
                            RIGHT JOIN likes
                            ON likes.movie_id = comments.movie_id ");
                        }
                    } else {
                        $joinlikescomments = $db->query(" SELECT comments.movie_id, comments.movie_name, comments.comment, likes.liked
                        FROM comments
                        LEFT JOIN likes
                        ON likes.movie_id = comments.movie_id
                        UNION
                        SELECT likes.movie_id, likes.movie_name, comments.comment, likes.liked
                        FROM comments
                        RIGHT JOIN likes
                        ON likes.movie_id = comments.movie_id ");
                    }



                 /*    // search by like/dislike
                    if(isset($_POST['ifliked'])) { //(if chosen input, show table with filter by input)
                        $searchifliked = $_POST['ifliked'];

                        $joinlikescomments = $db->query(" SELECT comments.movie_id, comments.movie_name, comments.comment, likes.liked
                        FROM comments
                        LEFT JOIN likes
                        ON likes.movie_id = comments.movie_id AND likes.liked LIKE '%$searchifliked%'
                        UNION
                        SELECT likes.movie_id, likes.movie_name, comments.comment, likes.liked
                        FROM comments
                        RIGHT JOIN likes
                        ON likes.movie_id = comments.movie_id AND likes.liked LIKE '%$searchifliked%'
                        ");
                            
                    } else { //(else, show complete table)
                        $joinlikescomments = $db->query(" SELECT comments.movie_id, comments.movie_name, comments.comment, likes.liked
                        FROM comments
                        LEFT JOIN likes
                        ON likes.movie_id = comments.movie_id
                        UNION
                        SELECT likes.movie_id, likes.movie_name, comments.comment, likes.liked
                        FROM comments
                        RIGHT JOIN likes
                        ON likes.movie_id = comments.movie_id ");
                    } */

                
                    // search by movie comment




                /* ------------------------------------------------ (FULL TABLE) ------------------------------------------------*/
                $joinlikescomments = $db->query(" SELECT comments.movie_id, comments.movie_name, comments.comment, likes.liked
                FROM comments
                LEFT JOIN likes
                ON likes.movie_id = comments.movie_id
                UNION
                SELECT likes.movie_id, likes.movie_name, comments.comment, likes.liked
                FROM comments
                RIGHT JOIN likes
                ON likes.movie_id = comments.movie_id ");
                /*------------------------------------------------------------------------------------------------------------------*/
                while($joininfo = $joinlikescomments->fetch()) {
                    $id = $joininfo['movie_id'];
                    $name = $joininfo['movie_name'];
                    $likes = $joininfo['liked'];
                    $comment = $joininfo['comment'];  
                    ?>    
                    <tr>
                        <td><?php echo $name; ?></td>
                        <td>
                            <?php if ($likes == "liked") {
                                ?><i class="fa fa-heart"></i><?php
                            } elseif ($likes == "disliked") {
                                ?><i class="fa fa-thumbs-down"></i><?php
                            } else {
                                echo "";
                            }; ?>
                        </td>
                        <td><?php echo $comment; ?></td>
                        <td>
                        <form action="filmdescription.php" method="get">
                            <button type="submit" name="film" value="<?php echo $id; ?>"><i class="fa fa-eye"></i></button>
                        </form>
                        </td>
                    </tr>
                <?php
                }?>
            </table>
        </article>

    </main>


    <!-- FOOTER -->
   <?php include('footer.php'); ?>

</body>
</html>