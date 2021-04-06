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
    <?php //include('header.php'); ?>


    <!-- MAIN CONTENT -->
    <main>

        <!-- user information -->
        <article>
            <h2>Personal Information</h2>
            <?php
            $get_userdata = $db->query(" SELECT date_insc, mail FROM users ");
            while ($userdata = $get_userdata->fetch()) {
                $date = $userdata['date_insc'];
                $email = $userdata['mail'];
            } ?>
            <p>Pseudo: <?php echo ucfirst($_SESSION['pseudo']); ?></p>
            <p>Password: <?php //echo $_SESSION['password']; ?></p> <!-- CHECK ! -->
            <p>E-mail: <?php echo $email; ?></p>
            <p>Member since: <?php echo $date; ?></p>   
        </article>


        <!-- user favorite movies -->
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


        <!-- check and manage their likes, dislikes and comments -->
        <article>
            <h2>Your Interactions</h2>
            <table>
                <tr>
                    <th>Movie</th>
                    <th>Liked?</th>
                    <th>Comment</th>
                </tr>
                <?php
                // join tables "likes" and "comments" (CHANGE WHEN MESSAGES TABLE HAS MOVIE ID)
                $joinlikescomments = $db->query(" SELECT likes.pseudo, likes.movie_name, likes.liked, comments.comment FROM likes INNER JOIN comments ON likes.pseudo=comments.pseudo ");
                while($joininfo = $joinlikescomments->fetch()) {
                    $pseudo = $joininfo['pseudo'];
                    $name = $joininfo['movie_name'];
                    $likes = $joininfo['liked'];
                    $comment = $joininfo['comment'];
                    //echo $pseudo . " " . $name . " " . $name . " " .$likes . " " . $comment . "<br>";
                    ?>    
                    <tr>
                        <td><?php echo $name; ?></td>
                        <td><?php echo $likes; ?></td>
                        <td><?php echo $comment; ?></td>
                    </tr>
                <?php
                }?>
            </table>
        </article>
        
    </main>


    <!-- FOOTER -->
   <?php //include('footer.php'); ?>

</body>
</html>