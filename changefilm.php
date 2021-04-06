<?php
    include 'session.php';
    include 'generalsettings.php';
    include 'dbconnection.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <link rel="stylesheet" href="css/style.css" type="text/css"/> -->
        <script type="text/javascript" src="getflix.js" defer></script>
        <title>GetFlix - Backoffice</title>
    </head>

    <?php
    if (isset($_GET['id'])) {
        $movieid = test_input($_GET['id']);
    // convert GET value into integer
        $movietochange = (int)$movieid;

    // target infos on this movie with id
        $answer_moviechange = $db->prepare('SELECT * FROM movies WHERE ID = :id');
        $answer_moviechange->execute(array(
            'id'=> $movietochange
        ));

        $data_moviechange = $answer_moviechange->fetch();
    
    // check if id exists in the database
        if (!$data_moviechange) {
            header('Location: backoffice.php');
        } else {
            $changemoviename = $data_moviechange['movie_name'];
            $changemovielink = $data_moviechange['movie_link'];
            $changemoviedescription = $data_moviechange['movie_description'];
            $changemoviegenre = $data_moviechange['genre'];
        }

    // Genre of the film appears on top of the Select options
        $movie_genres2 = $movie_genres;
        $key = array_search($changemoviegenre, $movie_genres2);
        $movegenre = $movie_genres2[$key];
        unset($movie_genres2[$key]);
        array_unshift($movie_genres2, $movegenre);

// update form info into database
    if (isset($_POST['change_movie'])) {
        if ( empty($_POST['genre']) || empty($_POST['movie_name']) || empty($_POST['movie_link']) || empty($_POST['movie_description']) ) {
            echo "Please fill in all the inputs";
        } else {
            if (in_array($_POST['genre'], $movie_genres)) {
                if (strlen($_POST['movie_name']) <= 150) {
                    if (preg_match("#^https://www\.youtube\.com/embed/#", $_POST['movie_link'])){
                        if ($_POST['hidden_img'] == 'movie_img') {
                    $genre = test_input($_POST['genre']);
                    $moviename = test_input($_POST['movie_name']);
                    $link = test_input($_POST['movie_link']);
                    $moviedescription = test_input($_POST['movie_description']);
                    $movieimg = test_input($_POST['hidden_img']);
                    
                    $request = $db->prepare('UPDATE movies SET genre = :nwgenre, movie_name = :nwname, movie_link = :nwlink, movie_description = :nwdescription WHERE ID= :id');
                    $request->execute(array(
                        'nwgenre'=> $genre,
                        'nwname'=> $moviename,
                        'nwlink'=> $link,
                        'nwdescription'=> $moviedescription,
                        'id'=> $movietochange
                    ));
                    include('includeimg.php'); 
                        }
                    } else {
                        echo "The url link must respect the format https://www.youtube.com/embed/example";
                    }
                } else {
                    echo "The movie name is too long, it musts be less than 150 characters";
                }
            }
            header('Location: backoffice.php');
        }
    }    
    ?>
        
    <body>
        <!-- HEADER -->
        <?php include 'header.php' ?>
        <main>
    <!-- INPUT FILMS TO DATABASE -->
        <h2>Include Movie</h2>
            <!-- form to input movies -->
            <article>
                <form method="post">
                    <label for="genre">Genre</label>
                    <select name="genre" id="genre">
                        <?php // movie genres list 
                        for ($i = 0; $i < count($movie_genres); $i++) {  
                        ?>
                        <option value="<?php echo $movie_genres2[$i] ?>"><?php echo $movie_genres2[$i] ?></option>  
                        <?php } ?>
                    </select><br>

                    <label for="movie_name">Title</label>
                    <input type="text" name="movie_name" id="movie_name" value="<?php echo $changemoviename; ?>"><br>

                    <label for="movie_link">Link</label>
                    <input type="text" name="movie_link" id="movie_link" value="<?php echo $changemovielink; ?>"/><br>
                    <input type="hidden" name="hidden_img" value="movie_img" >

                    <label for="movie_link">Description</label>
                    <textarea name="movie_description" id="movie_description"><?php echo $changemoviedescription; ?></textarea><br>
                    <input type="submit" value="Change" name="change_movie">
                </form>
            </article>
        <main>

    <?php 
        }
    ?>
    </body>
</html>