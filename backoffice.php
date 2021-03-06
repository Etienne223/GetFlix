<?php
    include 'generalfiles/session.php';
    if ($_SESSION['authorization'] == 0) {
        header('Location: moviescatalog.php');
    }
    include 'generalfiles/generalsettings.php';
    include 'generalfiles/dbconnection.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="title" content="GetFlix - Back Office">
        <meta name="description" content="Discover all about the movies you like">
        <meta name="keywords" content="Streaming, VOD, GetFlix, Films, Movies, Series, Séries">
        <meta name="robots" content="index, follow">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="language" content="English">
        <meta name="revisit-after" content="10 days">
        <meta name="author" content="GetFlix Team">
        <link rel="shortcut icon" href="assets/images/favicon_getflix.ico"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
        <!-- <link rel="stylesheet" href="moviescatalog.css" /> -->
        <script type="text/javascript" src="Javascript/style.js" defer></script>
        <script type="text/javascript" src="Javascript/backoffice.js" defer></script> 
        <title>GetFlix - Back Office</title>
    </head>
    <body>
        <!-- HEADER -->
        <?php include 'generalfiles/header.php' ?>
        <main id="backOffice">
            <article class="tab">
                <button id="movies-btn" class="tablinks">
                    <a href="backoffice.php#movies">Movies</a>
                </button>
                <button id="comments-btn" class="tablinks">
                    <a href="backoffice.php#comments">Comments</a>
                </button>
                <button id="users-btn" class="tablinks">
                    <a href="backoffice.php#users">Users</a>
                </button>
            </article>
            <article id="movies-tab" class="tabcontent">
                <h1>Movies</h2>
                <div style="overflow-x:auto;">
                    <?php include 'generalfiles/moviesbackoffice.php'; ?>
                </div>
            </article>
            <article id="comments-tab" class="tabcontent">
                <h1>Comments</h2>
                <div style="overflow-x:auto;">
                    <?php include 'generalfiles/commentsbackoffice.php'; ?>
                </div>
            </article>
            <article id="users-tab" class="tabcontent">
                <h1>Users</h2>
                <div style="overflow-x:auto;">
                    <?php include 'generalfiles/usersbackoffice.php'; ?>
            </article>
        </main>
        <?php include 'generalfiles/footer.php' ?>
    </body>’
</html>
