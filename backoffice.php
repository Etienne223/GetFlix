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
        <script type="text/javascript" src="getflix.js" defer></script>
        <title>GetFlix - Backoffice</title>
    </head>
    <body>
        <!-- HEADER -->

        <main>
        <?php
        // Create new array from movie_genres so the changes made don't mess the original array
            $movie_genres2 = $movie_genres;
            array_unshift($movie_genres2, '---');
        
        // If Search button has been clicked
            if (isset($_GET['genre']) AND isset($_GET['search'])){
                $filter_selected = test_input($_GET['genre']);
                if (in_array($filter_selected, $movie_genres2)) {
                // mecanism to keep the filter selected on top of the select options
                    $_SESSION['selected_genre'] = $filter_selected;
                    $key = array_search($_SESSION['selected_genre'], $movie_genres2);
                    $movegenre = $movie_genres2[$key];
                    unset($movie_genres2[$key]);
                    array_unshift($movie_genres2, $movegenre);
                }
            // if no genre filter has been set 
                if ($_GET['genre'] == '---'){
                    // if search is made in search bar
                        if(!empty($_GET['search'])){
                            $search_film = test_input($_GET['search']);
                            $result_request = 'SELECT * FROM movies WHERE movie_name LIKE :film OR movie_link LIKE :film OR movie_description LIKE :film OR date LIKE :film';
                    // if nos search made in search bar
                        } else {
                            $result_request = 'SELECT * FROM movies';
                        }
            // if genre filter is set
                } else {
                    // if search is made in search bar
                        if(!empty($_GET['search'])){
                            $search_film = test_input($_GET['search']);
                            $result_request = 'SELECT * FROM movies WHERE (movie_name LIKE :film OR movie_link LIKE :film OR movie_description LIKE :film OR date LIKE :film) AND genre =:genre';
                    // if no search is made in search bar
                        } else {
                            $filter = $_GET['genre'];
                            $result_request = "SELECT * FROM movies WHERE genre='$filter'";
                        }
                }
        // if search button not clicked
            } else {
                $result_request = 'SELECT * FROM movies';
            }

            $answer_films = $db->prepare($result_request);
            $answer_films->execute(array(
                'genre'=> $_SESSION['selected_genre'],
                'film'=> '%'.$search_film.'%'
            ));

        // count how many lines in the table
            $count = $answer_films->rowCount();

        // insert form info into database
            if (isset($_POST['include_movie'])) {
                if ( empty($_POST['genre']) || empty($_POST['movie_name']) || empty($_POST['movie_link']) || empty($_POST['movie_description']) ) {
                    echo "Please fill in all the inputs";

                } else {
                    if (in_array($_POST['genre'], $movie_genres)) {
                        if (strlen($_POST['movie_name']) <= 150) {
                            if (preg_match("#^https://www\.youtube\.com/embed/#", $_POST['movie_link'])){
                            $genre = test_input($_POST['genre']);
                            $moviename = test_input($_POST['movie_name']);
                            $link = test_input($_POST['movie_link']);
                            $moviedescription = test_input($_POST['movie_description']);
                            $request = $db->prepare('INSERT INTO movies(genre, movie_name, movie_link, movie_description) VALUES (?, ?, ?, ?)');
                            $request->execute(array($genre, $moviename, $link, $moviedescription ));
                            echo '<p>Film uploaded with sucess !</p>';
                            } else {
                                echo "The url link must respect the format https://www.youtube.com/embed/example";
                            }
                        } else {
                            echo "The movie name is too long, it musts be less than 150 characters";
                        }
                    }
                }
            }

    // Action when delete comments in the table
        if (isset($_POST['delete_film'])) {
            $id_film = test_input($_POST['delete_film']);
            $delete_film= $db->prepare("DELETE FROM movies WHERE ID= :id");
            $delete_film->execute(array(
                'id'=>$id_film
            ));
            if (isset($_GET['search']) AND isset($_GET['genre'])){
                header('Location: backoffice.php?search='.$_GET['search'].'&genre='.$_GET['genre'].'');
            } else {
                header('Location: backoffice.php');
            }
        }
        ?>

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
                        <option value="<?php echo $movie_genres[$i] ?>"><?php echo $movie_genres[$i] ?></option>  
                        <?php } ?>
                    </select><br>

                    <label for="movie_name">Title</label>
                    <input type="text" name="movie_name" id="movie_name"><br>

                    <label for="movie_link">Link</label>
                    <input type="text" name="movie_link" id="movie_link"><br>

                    <label for="movie_link">Description</label>
                    <textarea name="movie_description" id="movie_description"></textarea><br>
                    <input type="submit" value="Include" name="include_movie">
                </form>
            </article>
        <!-- FILMS MANAGEMENT TABLE-->
            <article>
                <form method="get">
                    <input id="search" name="search" type="text" placeholder="Search..."/>
                    <select id="select" name="genre">
                    <?php for ($i = 0; $i < count($movie_genres2); $i++) { ?>
                        <option value="<?php echo $movie_genres2[$i];?>"><?php echo $movie_genres2[$i];?></option>
                    <?php } ?>   
                    </select>
                    <button type="submit">Search</button> 
                </form>
                <p>
                <?php if ($count == 0 || $count == 1) {
                        echo $count.' result.';
                    } else {
                        echo $count.' results.';
                    }
                ?>
                </p>
                <section>
                    <table>
                        <tr>
                            <th>Date</th>
                            <th>Genre</th>
                            <th>Movie</th>
                            <th>Movie link</th>
                            <th>Movie description</th>
                            <th>Delete</th>
                            <th>Modify</th>
                        </tr>
                    <?php while ($films = $answer_films->fetch()){ ?>
                        <form method="post">
                        <tr>
                            <td><?php echo $films['date']; ?></td>
                            <td><?php echo $films['genre']; ?></td>
                            <td><?php echo $films['movie_name']; ?></td>
                            <td><?php echo $films['movie_link']; ?></td>
                            <td><?php echo $films['movie_description']; ?></td>
                            <td>
                                <button type="submit" name="delete_film" value="<?php echo $films['ID'];?>">Delete</button>
                            </td>
                            <td>
                                <button type="submit" name="modify_film" value="<?php echo $films['ID'];?>">Modify</button>
                            </td>
                        </tr>
                        </form>  
                    <?php } ?>
                    </table>
                </section>
            </article>
        <main>
    </body>
</html>