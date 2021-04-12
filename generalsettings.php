<?php
// test inputs function
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
/*     sleep(1); */
    return $data;
}


// movie's genres list
$movie_genres = array('Action', 'Animation', 'Comedy', 'Crime', 'Drama', 'Fantasy', 'Historical', 'Horror', 'Romance', 'Science Fiction', 'Thriller');


// row count
include('dbconnection.php');
$sql = $db->query(" SELECT COUNT(*) FROM movies ");
$count_rows = $sql->fetchColumn();


// import php variable $movie_genres into external js file hover.js (used on file moviescatalog.php)
?>
<script type="text/javascript">
    let moviesGenres = <?php echo json_encode($movie_genres); ?>;
    let countRows = <?php echo json_encode($count_rows); ?>;
</script>
<script src="moviescatalog.js"></script>
<script src="hoverinfo.js"></script>



