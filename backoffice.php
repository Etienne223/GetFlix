<?php
    include 'session.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="getflix.js" defer></script>
    <title>GetFlix - Backoffice</title>
</head>
<body>
<?php
//if (isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['email'])){
    ?>
    <!-- HEADER -->
    <!-- INPUT FILMS TO DATABASE -->
    <h2>Include Movie</h2>

        <!-- form to input movies -->
        <form action="" method="post">
            <label for="genre">Genre</label>
            <select name="genre" id="genre">
                <?php
                // movie genres list

                include('generalsettings.php');

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
            <input type="submit" value="Include" name="include_movie">
        </form>

        <?php
        // insert form info into database
        include('dbconnection.php');

        if (isset($_POST['include_movie'])) {
            if ( empty($_POST['genre']) || empty($_POST['movie_name']) || empty($_POST['movie_link']) || empty($_POST['movie_description']) ) {
                echo "Please fill in all the inputs";

            } else {
                $request = $database->prepare('INSERT INTO movies(genre, movie_name, movie_link, movie_description) VALUES (?, ?, ?, ?)');
                $request->execute(array($_POST['genre'], $_POST['movie_name'], $_POST['movie_link'], $_POST['movie_description'] ));
            }
        } 

    ?>
</body>
</html>