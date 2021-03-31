<?php
// movie's genres list
$movie_genres = array('Action', 'Animation', 'Comedy', 'Crime', 'Drama', 'Fantasy', 'Historical', 'Horror', 'Romance', 'Science Fiction', 'Thriller');

// test inputs function
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}