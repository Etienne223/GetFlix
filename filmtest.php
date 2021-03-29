<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GetFlix</title>
</head>
<body>
    <?php include 'dbconnection.php';?>
    <?php 
        // TEMPORARY FOR TEST
        $answer_movie = $bdd->query('SELECT * FROM movies');
    ?>
    <main>
        <?php while ($data_movie = $answer_movie->fetch()){?>
        <iframe width="560" height="315" src="<?php echo $data_movie['movie_link']?>"></iframe>
        <h1><?php echo $data_movie['movie_name']?><h1>
        <?php } ?>
    </main>
</body>
</html>