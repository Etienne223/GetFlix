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
    // Create new array from movie_genres so the changes made don't mess the original array
        $movie_genres2 = $movie_genres;
        array_unshift($movie_genres2, '---');
    
    // If Search button has been clicked
        if (isset($_GET['genre']) AND isset($_GET['search'])){
            $filter_selected = test_input($_GET['genre']);
            $search_film = test_input($_GET['search']);
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
                        $answer_films = $db->prepare('SELECT * FROM movies WHERE movie_name LIKE :film OR movie_link LIKE :film OR movie_description LIKE :film OR date LIKE :film ORDER BY ID DESC');
                        $answer_films->execute(array(
                            'film'=> '%'.$search_film.'%'
                        ));
                // if no search made in search bar
                    } else {
                        $answer_films = $db->query('SELECT * FROM movies ORDER BY ID DESC');
                    }
        // if genre filter is set
            } else {
                // if search is made in search bar
                    if(!empty($_GET['search'])){
                        $answer_films = $db->prepare('SELECT * FROM movies WHERE (movie_name LIKE :film OR movie_link LIKE :film OR movie_description LIKE :film OR date LIKE :film) AND genre =:genre ORDER BY ID DESC');
                        $answer_films->execute(array(
                            'film'=> '%'.$search_film.'%',
                            'genre'=> $_SESSION['selected_genre']
                        ));
                // if no search is made in search bar
                    } else {
                        $answer_films = $db->prepare('SELECT * FROM movies WHERE genre= :genre ORDER BY ID DESC');
                        $answer_films->execute(array(
                            'genre'=> $_SESSION['selected_genre']
                        ));
                    }
            }
    // if search button not clicked
        } else {
            $answer_films = $db->query('SELECT * FROM movies ORDER BY ID DESC');
        }


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
                            if ($_POST['hidden_img'] == 'movie_img') {
                        $genre = test_input($_POST['genre']);
                        $moviename = test_input($_POST['movie_name']);
                        $link = test_input($_POST['movie_link']);
                        $moviedescription = test_input($_POST['movie_description']);
                        $movieimg = test_input($_POST['hidden_img']);
                        
                        $request = $db->prepare('INSERT INTO movies(genre, movie_name, movie_link, movie_img, movie_description) VALUES (?, ?, ?, ?, ?)');
                        $request->execute(array($genre, $moviename, $link, $_POST['hidden_img'], $moviedescription ));
                        include('includeimg.php'); 
                        
                        echo '<p>Film uploaded with sucess !</p>';
                            }
                        } else {
                            echo "The url link must respect the format https://www.youtube.com/embed/example";
                        }
                    } else {
                        echo "The movie name is too long, it musts be less than 150 characters";
                    }
                    header('Refresh: 0');
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
                        <option value="<?php echo $movie_genres[$i] ?>"><?php echo $movie_genres[$i] ?></option>  
                        <?php } ?>
                    </select><br>

                    <label for="movie_name">Title</label>
                    <input type="text" name="movie_name" id="movie_name"><br>

                    <label for="movie_link">Link</label>
                    <input type="text" name="movie_link" id="movie_link"><br>
                    <input type="hidden" name="hidden_img" value="movie_img" >

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
                        </form>  
                            <td>
                            <form action="changefilm.php" method="get">
                                <button type="submit" name="id" value="<?php echo $films['ID'];?>">Modify</button>
                            </form> 
                            </td>
                        </tr> 
                    <?php } ?>
                    </table>
                </section>
            </article>
        <main>
    </body>
</html>