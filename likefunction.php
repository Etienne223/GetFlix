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