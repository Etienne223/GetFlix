<?php
// movie's genres list
$movie_genres = array('Action', 'Animation', 'Comedy', 'Crime', 'Drama', 'Fantasy', 'Historical', 'Horror', 'Romance', 'Science Fiction', 'Thriller');

// test inputs function
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
/*     sleep(1); */
    return $data;
}
?>



<!-- import php variable $movie_genres into external js file hover.js (used on file moviescatalog.php)-->
<script type="text/javascript">
    let moviesGenres = <?php echo json_encode($movie_genres); ?>;
</script>
<script src="hover.js"></script>

