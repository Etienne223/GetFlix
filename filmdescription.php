<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netflix</title>
</head>
<body>
    <?php include 'dbconnection.php';?>
    <?php 
        // TEMPORARY FOR TEST
        $answer_movie = $bdd->query('SELECT * FROM movies');
        $answer_comment = $bdd->query('SELECT * FROM comments');
    ?>
    <main>
        <?php while ($data_movie = $answer_movie->fetch()){?>
        <iframe width="560" height="315" src="<?php echo $data_movie['movie_link']?>"></iframe>
        <h1><?php echo $data_movie['movie_name']?><h1>
        <?php } ?>
        <!-- Leave a comment button -->
        <section>
            <button id="btn-comment">Leave a comment</button>
        </section>
        <article>
            <form method="post">
                <section>
                    <textarea name="comment_text" id="comment_text" cols="100" rows="3"></textarea>
                </section>
                <section>
                    <button type="submit" name="submit_comment" id="submit_comment">
                        Submit
                    </button>
                </section>
            </form>
        </article>

        <?php 
            if (isset($_POST['submit_comment'])) {
                if (isset($_POST['comment_text'])){
                    $comment = $_POST['comment_text'];
                    $movie = "test";
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