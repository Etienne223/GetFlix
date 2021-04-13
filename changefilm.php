<?php
    include 'generalfiles/session.php';
    include 'generalfiles/dbconnection.php';
    include 'generalfiles/generalsettings.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
        <script type="text/javascript" src="getflix.js" defer></script>
        <script type="text/javascript" src="changefilm.js"></script>
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
            header('Location: backoffice.php#movies');
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
            $genre = $_POST['genre'];
            $moviename = $_POST['movie_name'];
            $link = $_POST['movie_link'];
            $moviedescription = $_POST['movie_description'];
            $movieimg = $_POST['hidden_img'];

            for ($i=0; $i < count($genre); $i++) {
                if (!empty($genre[$i]) AND !empty($moviename[$i]) AND !empty($link[$i]) AND !empty($moviedescription[$i]) AND !empty($movieimg[$i])) {
                    if (in_array($genre[$i], $movie_genres)) {
                        if (strlen($moviename[$i]) <= 150) {
                            if (preg_match("#^https://www\.youtube\.com/embed/#", $link[$i])){
                                if ($movieimg[$i] == 'movie_img') {
                                    $request = $db->prepare('UPDATE movies SET genre = :nwgenre, movie_name = :nwname, movie_link = :nwlink, movie_description = :nwdescription WHERE ID= :id');
                                    $request->execute(array(
                                            'nwgenre'=> test_input($genre[$i]),
                                            'nwname'=> test_input($moviename[$i]),
                                            'nwlink'=> test_input($link[$i]),
                                            'nwdescription'=> test_input($moviedescription[$i]),
                                            'id'=> test_input($movietochange)
                                    ));
                                    include 'generalfiles/includeimg.php';
                                    header('Location: backoffice.php#movies');   
                                }
                            } 
                        }
                    }
                }
            }
              
        }
    ?>
        
    <body>
        <!-- HEADER -->
        <?php include 'generalfiles/header.php' ?>
        <main id="backOffice">
    <!-- INPUT FILMS TO DATABASE -->
        <h2>Update Movie</h2>
            <!-- form to input movies -->
            <article>
                <form method="post">
                    <label for="genre">Genre</label>
                    <select name="genre[]" id="genre">
                        <?php // movie genres list 
                        for ($i = 0; $i < count($movie_genres); $i++) {  
                        ?>
                        <option value="<?php echo $movie_genres2[$i] ?>"><?php echo $movie_genres2[$i] ?></option>  
                        <?php } ?>
                    </select><br>

                    <label for="movie_name">Title</label>
                    <input type="text" name="movie_name[]" id="movie_name" value="<?php echo $changemoviename; ?>"><br>

                    <label for="movie_link">Link</label>
                    <input type="text" name="movie_link[]" id="movie-link-update" value="<?php echo $changemovielink; ?>"/><br>
                    <input type="hidden" name="hidden_img[]" value="movie_img" >

                    <label for="movie_link">Description</label>
                    <textarea name="movie_description[]" id="movie_description"><?php echo $changemoviedescription; ?></textarea><br>
                    <button type="submit" name="change_movie">Change</button>
                </form>
                <p id="update-message"></p>
            </article>
        </main>

    <?php 
        }
    ?>
    <?php include 'generalfiles/footer.php' ?>
    </body>
</html>