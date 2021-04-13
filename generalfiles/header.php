<header>
    <nav>
        <a href="moviescatalog.php"><img src="assets/images/getflix_logo.png" alt="getflix_logo"></a>
        <ul id="navLink">
            <li><a href="moviescatalog.php">Home</a></li>
            <li><a href="movies.php">Movies</a></li>
            <li><a href="topmovies.php">Popular</a></li>
            <li><a href="mylist.php">My List</a></li>
            <li><a href="https://www.youtube.com/watch?v=Lrj2Hq7xqQ8" target="_blank">Dare clicking?</a></li>
            <li><!-- search bar -->
                <form  action="search.php" method="get">
                    <input id="searchInfo" name="searchinfo" type="text" placeholder="Search on website..."/>
                    <button id="searchBar" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </li> 
            <li>
                <?php if($_SESSION['authorization'] == 0) {
                    ?><a href="userprofile.php"><i id="gearProfil" class="fas fa-cog"></i></a><?php
                } else {
                    ?><a href="backoffice.php"><i id="gearProfil" class="fas fa-cog"></i></a><?php
                }?>
                
                <a href="generalfiles/logout.php"><i id="logoutMob" class="fas fa-sign-out-alt"></i></a>
            </li>
        </ul>
        <ul id="profil">
            <li><?php echo "Hi, " . ucfirst($_SESSION['pseudo']); ?></li>
            <li>
                <?php if($_SESSION['authorization'] == 0) {
                    ?><a href="userprofile.php"><i class="fas fa-cog"></i></a><?php
                } else {
                    ?><a href="backoffice.php"><i class="fas fa-cog"></i></a><?php
                }?>
            </li>
            <li>
                <a href="generalfiles/logout.php"><i class="fas fa-sign-out-alt"></i></a>
            </li>
        </ul>
        <i id="burger" class="fa fa-bars"></i>
    </nav>
</header>
