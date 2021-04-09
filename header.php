<?php
    // Create new array from movie_genres so the changes made don't mess the original array
    $movie_genres3 = $movie_genres;
    array_unshift($movie_genres3, 'Genre');
?>

<header>
    <nav>
        <a href="moviescatalog.php"><img src="assets/images/getflix_logo.png" alt="getflix_logo"></a>
        <ul id="navLink">
            <li><a href="moviescatalog.php">Home</a></li>
            <li><a href="">Series</a></li>
            <li><a href="moviescatalog.php">Movies</a></li>
            <li><a href="mylist.php">My List</a></li>
            <li><a href="https://www.youtube.com/watch?v=Lrj2Hq7xqQ8" target="_blank">Dare clicking?</a></li>
            <li><!-- search bar -->
                <form action="search.php" method="get">
                    <select name="searchgenre">
                        <?php for ($i = 0; $i < count($movie_genres3); $i++) { ?>
                            <option value="<?php echo $movie_genres3[$i];?>"><?php echo $movie_genres3[$i];?></option>
                        <?php } ?>   
                    </select>
                    <input id="searchInfo" name="searchinfo" type="text" placeholder="Search on website..."/>
                    <button id="searchBar" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </li> 
            <li><i id="gearProfil" class="fas fa-cog"></i></li>
        </ul>
        <ul id="profil">
            <li><i class="fas fa-cog"></i></li>
        </ul>
        <i id="burger" class="fa fa-bars"></i>
    </nav>
</header>