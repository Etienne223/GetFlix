<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    include('dbconnection.php');

    // transforming inputed link into image
    $get_links = $db->query("SELECT ID, movie_name, movie_link, movie_img FROM movies ");

    while ($data = $get_links->fetch()) {
        $id = $data['ID'];
        $link = $data['movie_link'];
        $img = $data['movie_img'];
        $name = $data['movie_name'];

        // divide link in every slash and get id (last part of link)
        $divide = explode('/', $link);
        $get_id = end($divide);  

        // create movie img link following this example (http://img.youtube.com/vi/<insert-youtube-video-id-here>/0.jpg)
        $movie_img = "http://img.youtube.com/vi/" . $get_id ."/0.jpg";
        //echo $movie_img . " - " . $id . "<br>";

    } 
    $rqt = $db->query(" UPDATE movies SET movie_img = '$movie_img' WHERE ID=$id ");


    ?>
</body>
</html>
