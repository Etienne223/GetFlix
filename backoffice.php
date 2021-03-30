<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Backoffice</title>
    </head>
    <body>
    <!-- HEADER -->

    <!-- INPUT FILMS TO DATABASE -->
    <h2>Include Movie</h2>

        <!-- form to input movies -->
        <form action="" method="post">
            <label for="genre">Genre</label>
            <select name="genre" id="genre">
                <?php
                // movie genres list
                $movie_genres = array('Action', 'Animation', 'Comedy', 'Crime', 'Drama', 'Fantasy', 'Historical', 'Horror', 'Romance', 'Science Fiction', 'Thriller');

                for ($i = 0; $i < count($movie_genres); $i++) {   
                    ?>
                    <option value="<?php echo $movie_genres[$i] ?>"><?php echo $movie_genres[$i] ?></option>  
                    <?php
                } 
                ?>
            </select><br>

            <label for="movie_name">Title</label>
            <input type="text" name="movie_name" id="movie_name"><br>

            <label for="movie_link">Link</label>
            <input type="text" name="movie_link" id="movie_link"><br>

            <label for="movie_link">Description</label>
            <input type="text" name="movie_description" id="movie_description"><br>

            <input type="submit" value="Include" name="include">
        </form>

        <?php
        // insert form info into database
        include 'dbconnection.php';

        if (isset($_POST['include'])) {
            if (isset($_POST['genre'], $_POST['movie_name'], $_POST['movie_link'], $_POST['movie_description'])) {
                $request = $database->prepare('INSERT INTO movies(genre, movie_name, movie_link, movie_description) VALUES (?, ?, ?, ?)');
                $request->execute(array($_POST['genre'], $_POST['movie_name'], $_POST['movie_link'], $_POST['movie_description'] ));
                
            } else {
                echo "Please fill in all the inputs";
            }
        }
        ?>
        
    </body>
</html>