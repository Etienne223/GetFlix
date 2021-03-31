<?php
    include 'session.php';
    include 'dbconnection.php';
    include 'generalsettings.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GetFlix</title>
</head>
<body>
    <?php $answer_movie = $db->query('SELECT * FROM movies');?>
    <main>
        <?php while ($data_movie = $answer_movie->fetch()){?>
        <iframe width="560" height="315" src="<?php echo $data_movie['movie_link']?>"></iframe>
        <h1><?php echo $data_movie['movie_name']?></h1>
        <p><?php echo $data_movie['movie_description']?></p>
        <form method="get" action="filmdescription.php">
            <button type="submit" name="film" value="<?php echo $data_movie['ID'];?>" id="moreinfo">Plus d'infos</button>
        </form>
        <?php } ?>
    </main>
</body>
</html>