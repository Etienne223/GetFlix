<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="getflix.js" defer></script>
    <script src="https://www.google.com/recaptcha/api.js" defer></script>
    <title>Netflix</title>
</head>
<body>
    <?php include 'dbconnection.php';?>

    <main>
        <?php 
        if (isset($_GET['film'])){
            $thismovieidstring = test_input($_GET['film']);
        // Convert GET value into integer
            $thismovieid = (int)$thismovieidstring;
            $answer_thismovie = $bdd->query("SELECT * FROM movies WHERE ID = $thismovieid");
            while ($data_thismovie = $answer_thismovie->fetch()){
        ?>
        <article>
            <iframe width="560" height="315" src="<?php echo $data_thismovie['movie_link']; ?>"></iframe>
            <h1><?php echo $data_thismovie['movie_name']; ?></h1>
            <p><?php echo $data_thismovie['movie_description']; ?></p>
        <article>
    <!-- Button Leave a comment -->
        <section>
            <button id="btn-comment">Leave a comment</button>
        </section>
    <!-- Button to leave a comment -->
        <article>
            <form method="post">
                <p>
                    <textarea name="comment_text" id="comment_text" cols="100" rows="3"></textarea>
                    <p id="count">0/500</p>
                </p>
                <p>
                    <input type="hidden" name="pagemoviename" value="<?php echo $data_thismovie['movie_name']; ?>">
                    <button type="submit" name="submit_comment" id="submit_comment">
                        Submit
                    </button>
                </p>
            </form>
        </article>
        <?php
            }
        }
        ?>
        
        <?php 
        // Send comment, name of the movie commented, and pseudo of user who made comment to Table comments
            if (isset($_POST['submit_comment'])) {
                if (isset($_POST['comment_text'])){
                    $comment = test_input($_POST['comment_text']);
                    $movie = test_input($_POST['pagemoviename']);
                    $pseudo = "test";
                    $query_comment = $bdd->prepare('INSERT INTO comments(pseudo, movie_name, comment) VALUES (:pseudo, :movie_name, :comment)');
                    $query_comment->execute(array(
                        'pseudo'=> $pseudo,
                        'movie_name'=> $movie,
                        'comment'=> $comment
                    ));
                }
            }
        ?>
  
    </main>
</body>
</html>