<?php 
include 'session.php';
include 'dbconnection.php';
include 'generalsettings.php';

/* SENT COMMENTS TO DB */
// Send comment, name of the movie commented, and pseudo of user who made comment to the table comments in db
            if (isset($_POST['submit_comment'])) {
                if (isset($_POST['comment_text'])){
                    $comment = test_input($_POST['comment_text']);
                    $id = test_input($_POST['movieid']);
                    $movie = test_input($_POST['pagemoviename']);
                    $pseudo = $_SESSION['pseudo'];
                    if (strlen($comment) > 0 AND strlen($comment) <= 500){
                        $query_comment = $db->prepare('INSERT INTO comments(pseudo, movie_id, movie_name, comment) VALUES (:pseudo, :movie_id, :movie_name, :comment)');
                        $query_comment->execute(array(
                            'pseudo'=> $pseudo,
                            'movie_id'=> $id,
                            'movie_name'=> $movie,
                            'comment'=> $comment
                        ));
                    }
                }
                header('Location: ../filmdescription.php?film='.$id.'');
            } else {
                header('Location: ../moviescatalog.php');
            }
?>