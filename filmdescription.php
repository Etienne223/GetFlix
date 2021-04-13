<?php
    include 'generalfiles/session.php';
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
        <link rel="stylesheet" href="moviescatalog.css" />
        <script type="text/javascript" src="style.js" defer></script>
        <script type="text/javascript" src="getflix.js" defer></script>
        <title>GetFlix - Movie descriptions</title>
    </head>
   
        <?php 
            include 'generalfiles/dbconnection.php';
            include 'generalfiles/generalsettings.php';

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

            if (isset($_GET['film'])){
                $thismovieidstring = test_input($_GET['film']);

            // convert GET value into integer
                $thismovieid = (int)$thismovieidstring; 
              
                // target infos on this movie with id
                    $answer_thismovie = $db->prepare('SELECT * FROM movies WHERE ID = :id');
                    $answer_thismovie->execute(array(
                        'id'=> $thismovieid
                    ));

                    $data_thismovie = $answer_thismovie->fetch();
                
                // check if id exists in the database
                    if (!$data_thismovie) {
                        header('Location: moviescatalog.php');
                    } else {
                        $themovieid = $data_thismovie['ID'];
                        $thismoviename = $data_thismovie['movie_name'];
                        $thismovielink = $data_thismovie['movie_link'];
                        $thismoviedescription = $data_thismovie['movie_description'];
                    }
        ?>

        
    <body>
    <!-- HEADER -->
        <?php include 'generalfiles/header.php' ?>
        <main class="filmDesc">
        <!-- INFOS ON THE MOVIE -->    
            <article id="moviePlay">
                <iframe width="560" height="315" src="<?php echo $thismovielink; ?>"></iframe>
                <form method="get" action="watch.php">
                    <button id="playButton" type="submit" name="watch" value="<?php echo $thismoviename; ?>">Play</button>
                </form>
                <!-- like/dislike buttons (connection to database down on this same file) -->
                <form method="post" target="frame">
                    <input type="hidden" name="movie_id" value="<?php echo $themovieid; ?>">
                    <input type="hidden" name="movie_name" value="<?php echo $thismoviename; ?>">
                    <button class="mods" type="submit" name="like"><i class="fa fa-heart"></i></button>
                    <button class="mods" type="submit" name="dislike"><i class="fa fa-thumbs-down"></i></button>
                </form>
            </article>
            <article id="description">
                <h1><?php echo $thismoviename; ?></h1>
                <p><?php echo $thismoviedescription; ?></p>
            </article>
        <!-- LEAVE A COMMENT FORM -->
            

        <!-- REVIEWS ON THE MOVIE-->    
            <article id="reviews">
                <h2>Reviews</h2>
                <?php 
                /* MANAGE HOW MANY COMMENTS THE PAGE SHOWS */
                    if (isset($_POST['all_comments'])){
                    // Show all comments of the film on click "See all comments"
                        $query_number_comments = 'SELECT * FROM comments WHERE movie_id = :movie_id ORDER BY ID DESC';
                    } else {
                    // Else show only the 5 last comments
                        $query_number_comments = 'SELECT * FROM comments WHERE movie_id = :movie_id ORDER BY ID DESC LIMIT 0,5';
                    }            

                // target comments from this movie
                    $answer_number_comments = $db->prepare($query_number_comments);
                    $answer_number_comments->execute(array(
                        'movie_id'=> $thismovieid
                    ));

                // To count how many comments there are on this film
                    $count = $answer_number_comments->rowCount();

                // If there are comments, display comments
                    if ($count > 0) {
                        while ($data_thiscomment = $answer_number_comments->fetch()){
                ?>
                <form id="commentsection" method="post" action>
                    <p class="comments">
                        <?php echo "<p id=commentInfo>" . $data_thiscomment['pseudo'] ." ". $data_thiscomment['date']."</p>"; 
                            if (!isset($_POST['modify_comment'])) { 
                            // if no modify button has been clicked
                                echo '<span>'.$data_thiscomment['comment'].'</span>';
                             }  else {
                            // if one modify button has been clicked
                                 if ($data_thiscomment['ID']== $_POST['modify_comment']){
                                // the comment to be modified : textarea + submit button
                                    echo '<textarea type="text" name="new_comment">'.$data_thiscomment['comment'].'</textarea>';
                                    echo '<button class="mods" id="submit" type="submit" name="submit_newcomment" value="'.$data_thiscomment['ID'].'"><i class="fas fa-check-square"></i></button>';
                                    echo '<button class="mods" id="cancel" type="submit"><i class="fas fa-window-close"></i></button>';
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
                            <button class="modify-action mods" type="submit" name="modify_comment" value="<?php echo $comment['ID'];?>"><i class="far fa-edit"></i></button>
                            <button class="mods" type="submit" name="delete_comment" value="<?php echo $comment['ID'];?>"><i class="fas fa-trash"></i></button>
                    </p>
                </form>
                <hr>
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
        // if Get['film'] is not set 
            } else {
                header('Location: moviescatalog.php');
            }
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
                ?>
            </article>
            <button id="btn-leavecomment">Leave a comment</button>
            <article id="leavecomment-area">
                <form method="post" action="generalfiles/addcomment.php">
                    <textarea name="comment_text" id="comment_text" cols="100" rows="3" placeholder="Your text..."></textarea></br>
                    <p id="count">0/500</p>
                    <input type="hidden" name="movieid" value="<?php echo $themovieid; ?>"/>
                    <input type="hidden" name="pagemoviename" value="<?php echo $thismoviename; ?>"/>
                    <button type="submit" name="submit_comment" id="submit-comment">Submit</button>

                </form>
            </article>
        </main>
        <!-- INCLUDE LIKE/DISLIKE ON DATABASE --> 
        <?php include ('generalfiles/likefunction.php'); ?>
        <iframe id="hidden_iframe" name="frame"></iframe> <!-- stop page from reloading when form is submitted -->
        

    <?php include 'generalfiles/footer.php' ?>
    </body>
</html>
