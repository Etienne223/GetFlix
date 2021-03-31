<?php
    include 'session.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="getflix.js" defer></script>
        <title>Getflix</title>
    </head>
    <body>
        <?php 
            include 'dbconnection.php';
            include 'generalsettings.php';
        ?>

        <main>

            <?php 
            if (isset($_GET['film'])){
                $thismovieidstring = test_input($_GET['film']);
            
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
                    echo $count;      

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
                    <p class="comments"><?php echo $data_thiscomment['comment']; ?></p>
            <?php 
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
                    <form method="post">
                        <button type="submit" name="all_comments" id="btn-seeall">See all comments</button>
                    </form>
                <?php 
                // if 'See all comments" HAS been clicked
                    } else {
                ?>
                    <form method="post">
                        <button type="submit" name="less_comments" id="btn-seeless">See less comments</button>
                    </form>
                <?php
                        }
                    }
                ?>
            </article>


            <?php 

            /* SENS COMMENTS TO DB */

            // Send comment, name of the movie commented, and pseudo of user who made comment to Table comments
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
                        header('Refresh: 0');
                    }
                }
            ?>
    
        </main>
    </body>
</html>