<header>
    <nav>
        <a href="moviescatalog.php"><img src="assets/images/getflix_logo.png" alt="getflix_logo"></a>
        <ul id="navLink">
            <li><a href="moviescatalog.php">Home</a></li>
            <li><a href="movies.php">New</a></li>
            <li><a href="topmovies.php">Popular</a></li>
            <li><a href="mylist.php">My List</a></li>
            <li><a href="https://www.youtube.com/watch?v=Lrj2Hq7xqQ8" target="_blank">Dare clicking?</a></li>
            <li><!-- search bar -->
                <form  action="search.php" method="get">
                    <input id="searchInfo" name="searchinfo" type="text" placeholder="Search on website..."/>
                    <button id="searchBar" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </li> 
            <li><i id="gearProfil" class="fas fa-cog"></i></li>
        </ul>
        <ul id="profil">
            <li><?php echo "Hi, " . ucfirst($_SESSION['pseudo']); ?></li>
            <li>
                <form method="post">
                    <button type="submit" value="settings" name="settings"><i class="fas fa-cog"></i></button>
                </form>  
            </li>
            <li>
                <form method="post">
                    <button type="submit" value="logout" name="logout"><i class="fas fa-sign-out-alt"></i></button>
                </form>  
            </li>
        </ul>
        <i id="burger" class="fa fa-bars"></i>
    </nav>
</header>

    
<?php
// ACCESS TO BACKOFFICE OR USERPROFILE DEPENDING ON USER
if(isset($_POST['settings'])) {
   if($_SESSION['authorization'] == 0) {
        header('location: userprofile.php');
   } else {
        header('location: backoffice.php');
   }
}

// LOGOUT BUTTON
if(isset($_POST['logout'])) {
    session_destroy();
    header('location: index.php');
}
?>