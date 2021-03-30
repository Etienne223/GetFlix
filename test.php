<?php 
    session_start();

    if (isset($_SESSION['id']) AND isset($_SESSION['pseudo']) AND isset($_SESSION['password']) AND isset($_SESSION['authorization'])) {
        echo "Connecté à la session";
    } else {
        header('Location: admin.php');
    }

?>

<!-- <input type="hidden" name="thismovielink" value="<?php echo $data_movie['movie_link']?>"/>
            <input type="hidden" name="thismoviename" value="<?php echo $data_movie['movie_name']?>"/>
            <input type="hidden" name="thismoviedescription" value="<?php echo $data_movie['movie_description']?>"/> -->


            <input type="hidden" name="thismovielink" value="<?php echo $data_movie['movie_link']?>"/>
            <input type="hidden" name="thismoviename" value="<?php echo $data_movie['movie_name']?>"/>
            <input type="hidden" name="thismoviedescription" value="<?php echo $data_movie['movie_description']?>"/>


            /* if (isset($_POST['thismovielink']) AND isset($_POST['thismoviename']) AND isset($_POST['thismoviedescription'])){
                $thismovielink = test_input($_POST['thismovielink']);
                $thismoviename = test_input($_POST['thismoviename']);
                $thismoviedescription = test_input($_POST['thismoviedescription']);  */