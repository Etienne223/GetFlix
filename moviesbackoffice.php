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

    // Action when delete comments in the table
    if (isset($_POST['delete_film'])) {
        $id_film = test_input($_POST['delete_film']);
        $delete_film= $db->prepare("DELETE FROM movies WHERE ID= :id");
        $delete_film->execute(array(
            'id'=>$id_film
        ));
        if (isset($_GET['search']) AND isset($_GET['genre'])){
            header('Location: backoffice.php?search='.$_GET['search'].'&genre='.$_GET['genre'].'#movies');
        } else if (!isset($_GET['search']) AND !isset($_GET['genre'])){
            header('Location: backoffice.php#movies');
        }
    }

    // insert form info into database
    if (isset($_POST['include_movie'])) {
        
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
                                $request = $db->prepare('INSERT INTO movies(genre, movie_name, movie_link, movie_img, movie_description) VALUES (:genre, :movie_name, :movie_link, :movie_img, :movie_description)');
                                $request->execute(array(
                                    'genre'=>test_input($genre[$i]),
                                    'movie_name'=> test_input($moviename[$i]),
                                    'movie_link'=> test_input($link[$i]),
                                    'movie_img'=> test_input($movieimg[$i]),
                                    'movie_description'=> test_input($moviedescription[$i])
                                ));
                            }
                        } 
                    }
                }
            }
        }
        include 'includeimg.php';
        header('Location: backoffice.php#movies');       
    }
    ?>
        
    <!-- INPUT FILMS TO DATABASE -->
        <h2>Include Movie</h2>
            <!-- form to input movies -->
                <form method="post">
                <article id="parentNode">
                <section class="trythis" id="form-to-clone">
                    <label for="genre">Genre</label>
                    <select name="genre[]" id="genre">
                        <?php // movie genres list 
                        for ($i = 0; $i < count($movie_genres); $i++) {  
                        ?>
                        <option value="<?php echo $movie_genres[$i] ?>"><?php echo $movie_genres[$i] ?></option>  
                        <?php } ?>
                    </select><br>

                    <label for="movie_name">Title</label>
                    <input type="text" name="movie_name[]" id="movie-name" required><br>

                    <label for="movie_link">Link</label>
                    <input type="text" name="movie_link[]" id="movie-link" placeholder="https://www.youtube.com/embed/example" required><br>
                    <input type="hidden" name="hidden_img[]" value="movie_img" >

                    <label for="movie_description">Description</label>
                    <textarea name="movie_description[]" id="movie-description" required></textarea><br>
                </section>
                <section id="submit-form">
                    <button id="addfilm-btn" type="button" name="include_movie">Include</button>
                    <button type="button" id="clone-form">+</button>
                </section>
                </article>
                </form>
                <p id="form-message"></p>
            
            
        <!-- FILMS MANAGEMENT TABLE-->
            <article id="formMovies">
                <form method="get">
                    <input id="search" name="search" type="text" placeholder="Search..."/>
                    <select id="select" name="genre">
                    <?php for ($i = 0; $i < count($movie_genres2); $i++) { ?>
                        <option value="<?php echo $movie_genres2[$i];?>"><?php echo $movie_genres2[$i];?></option>
                    <?php } ?>   
                    </select>
                    <button type="submit"><i class="fas fa-search"></i></button> 
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
                            <th class="DescSize">Movie description</th>
                            <th>Delete</th>
                            <th>Modify</th>
                        </tr>
                    <?php while ($films = $answer_films->fetch()){ ?>
                        <!-- <form method="post"> -->
                        <tr>
                            <td><?php echo $films['date']; ?></td>
                            <td><?php echo $films['genre']; ?></td>
                            <td><?php echo $films['movie_name']; ?></td>
                            <td><?php echo $films['movie_link']; ?></td>
                            <td  class="movieDescSize"><?php echo $films['movie_description']; ?></td>
                        <form method="post">   
                            <td>
                                <button type="submit" name="delete_film" value="<?php echo $films['ID'];?>"><i class="fas fa-trash"></i></button>
                            </td>
                        </form>  
                            <td>
                            <form action="changefilm.php" method="get">
                                <button type="submit" name="id" value="<?php echo $films['ID'];?>"><i class="far fa-edit"></i></button>
                            </form> 
                            </td>
                        </tr> 
                    <?php } ?>
                    </table>
                </section>
            </article>

            