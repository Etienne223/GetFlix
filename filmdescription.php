<?php
   include 'session.php';
?> 
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="title" content="GetFlix - Movie description">
        <meta name="description" content="Discover all about the movies you like">
        <meta name="keywords" content="Streaming, VOD, GetFlix, Films, Movies, Series, Séries">
        <meta name="robots" content="index, follow">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="language" content="English">
        <meta name="revisit-after" content="10 days">
        <meta name="author" content="GetFlix Team">
        <link rel="shortcut icon" href="assets/images/favicon_getflix.ico"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
        <script type="text/javascript" src="style.js" defer></script>
        <script type="text/javascript" src="getflix.js" defer></script>
        <title>GetFlix - Movie descriptions</title>
    </head>
   
        <?php 
            include 'dbconnection.php';
            include 'generalsettings.php';

        /* SENT COMMENTS TO DB */

        // Send comment, name of the movie commented, and pseudo of user who made comment to the table comments in db
            if (isset($_POST['submit_comment'])) {
                if (isset($_POST['comment_text'])){
                    $comment = test_input($_POST['comment_text']);
                    $movie = test_input($_POST['pagemoviename']);
                    $pseudo = $_SESSION['pseudo'];
                    if (strlen($comment) > 0 AND strlen($comment) <= 500){
                        $query_comment = $db->prepare('INSERT INTO comments(pseudo, movie_name, comment) VALUES (:pseudo, :movie_name, :comment)');
                        $query_comment->execute(array(
                            'pseudo'=> $pseudo,
                            'movie_name'=> $movie,
                            'comment'=> $comment
                        ));
                    }
                }
            }

        // Update comment of user if he changes it
            if (isset($_POST['submit_newcomment'])) {  
                if (isset($_POST['new_comment'])){
                    $idthiscomment = test_input($_POST['submit_newcomment']);
                    $newcomment = test_input($_POST['new_comment']);
                    if(strlen($newcomment) > 0 AND strlen($newcomment) <= 500){
                        $update_comment = $db->prepare('UPDATE comments SET comment = :newcomment WHERE ID = :id');
                        $update_comment->execute(array(
                            'newcomment'=> $newcomment,
                            'id'=> $idthiscomment
                        ));
                    } else if (strlen($newcomment) == 0) {
                        $update_empty = $db->prepare('DELETE FROM comments WHERE ID= :id');
                        $update_empty->execute(array(
                            'id'=> $idthiscomment
                        ));
                    }
                }
            } 

            // Delete comment of user if he clicks on Delete
            if (isset($_POST['delete_comment'])){
                $delete = test_input($_POST['delete_comment']);
                $delete_comment = $db->prepare('DELETE FROM comments WHERE ID= :id');
                $delete_comment->execute(array(
                    'id'=> $delete
                ));
            }
        ?>
        <?php include 'header.php' ?>
    <body>
        <main class="filmDesc">
            <?php 
            if (isset($_GET['film'])){
                $thismovieidstring = test_input($_GET['film']);
                $pattern = '[0-9]+';

            // convert GET value into integer
                $thismovieid = (int)$thismovieidstring; 
                // target infos on this movie with id
                    $answer_thismovie = $db->prepare('SELECT * FROM movies WHERE ID = :id');
                    $answer_thismovie->execute(array(
                        'id'=> $thismovieid
                    ));

                while ($data_thismovie = $answer_thismovie->fetch()){
                    $thismoviename = $data_thismovie['movie_name'];
                    $thismovielink = $data_thismovie['movie_link'];
                    $thismoviedescription = $data_thismovie['movie_description'];
            ?>

        <!-- INFOS ON THE MOVIE -->    
            <article>
                <iframe width="560" height="315" src="<?php echo $thismovielink; ?>" allowfullscreen></iframe>
                <form method="get" action="watch.php">
                    <button type="submit" name="watch" value="<?php echo $thismoviename; ?>">Play</button>
                </form>
                <h1><?php echo $thismoviename; ?></h1>
                <p><?php echo $thismoviedescription; ?></p>
                <button id="btn-leavecomment">Leave a comment</button>
            <article>

        <!-- LEAVE A COMMENT FORM -->
            <article id="leavecomment-area">
                <form method="post">
                        <textarea name="comment_text" id="comment_text" cols="100" rows="3"></textarea></br>
                        <p id="count">0/500</p>
                        <input type="hidden" name="pagemoviename" value="<?php echo $thismoviename; ?>"/>
                        <button type="submit" name="submit_comment" id="submit-comment">Submit</button>
                </form>
            </article>

        <!-- REVIEWS ON THE MOVIE-->    
            <article>
                <h2>Reviews</h2>
                <?php 
                /* MANAGE HOW MANY COMMENTS THE PAGE SHOWS */
                
                    if (isset($_POST['all_comments'])){
                    // Show all comments of the film on click "See all comments"
                        $query_number_comments = 'SELECT * FROM comments WHERE movie_name = :movie_name ORDER BY ID DESC';
                    } else {
                    // Else show only the 5 last comments
                        $query_number_comments = 'SELECT * FROM comments WHERE movie_name = :movie_name ORDER BY ID DESC LIMIT 0,5';
                    }            

                // target comments from this movie
                    $answer_number_comments = $db->prepare($query_number_comments);
                    $answer_number_comments->execute(array(
                        'movie_name'=> $thismoviename
                    ));

                // To count how many comments there are on this film
                    $count = $answer_number_comments->rowCount();

                // If there are comments, display comments
                    if ($count > 0) {
                        while ($data_thiscomment = $answer_number_comments->fetch()){
                ?>
                <form method="post" action>
                    <p class="comments">
                        <?php echo $data_thiscomment['pseudo']; ?>: <?php
                            if (!isset($_POST['modify_comment'])) { 
                            // if no modify button has been clicked
                                echo '<span>'.$data_thiscomment['comment'].'</span>';
                             }  else {
                            // if one modify button has been clicked
                                 if ($data_thiscomment['ID']== $_POST['modify_comment']){
                                // the comment to be modified : textarea + submit button
                                    echo '<textarea type="text" name="new_comment">'.$data_thiscomment['comment'].'</textarea>';
                                    echo '<button id="submit" type="submit" name="submit_newcomment" value="'.$data_thiscomment['ID'].'">Submit</button>';
                                    echo '<button id="cancel" type="submit">Cancel</button>';
                                    /**********/
                                 } else {
                                // other comments stay the same
                                    echo '<span>'.$data_thiscomment['comment'].'</span>';
                                 }   
                            }
                        // user can modify only his own comments
                            if ($_SESSION['pseudo'] == $data_thiscomment['pseudo']) {
                                $answer_comment = $db->prepare('SELECT * FROM comments WHERE ID= :id');
                                $answer_comment->execute(array(
                                    'id'=> $data_thiscomment['ID']
                                ));
                                
                                while ($comment = $answer_comment->fetch()){
                                // button modify visible only if not clicked
                                    if (!isset($_POST['modify_comment'])) {
                        ?>
                            <button class="modify-action" type="submit" name="modify_comment" value="<?php echo $comment['ID'];?>">Modify</button>
                            <button type="submit" name="delete_comment" value="<?php echo $comment['ID'];?>">Delete</button>
                    </p>
                </form>
                <?php 
                                    }
                                }
                            }
                        }
                // If no comments on the film
                    } else {
                ?>
                    <p id="no-reviews">This film has no reviews. Be the first one to leave a comment !</p>
                <?php
                        }
                    }

                /* MANAGE WHICH BUTTON TO SHOW */

                // if 'See all comments" has NOT been clicked
                    if (!isset($_POST['all_comments'])){
                ?>
                <p>
                    <form method="post">
                        <button type="submit" name="all_comments" id="btn-seeall">See all comments</button>
                    </form>
                    
                </p>
                <?php 
                // if 'See all comments" HAS been clicked
                    } else {
                ?>
                <p>
                    <form method="post">
                        <button type="submit" name="less_comments" id="btn-seeless">See less comments</button>
                    </form>
                    </p>
                <?php
                        }
                    }
                ?>
            </article>
        </main>
    <?php include 'footer.php' ?>
    </body>
</html>