<?php
    include 'session.php';
    include 'generalsettings.php';
    include 'dbconnection.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
        <script type="text/javascript" src="backoffice.js" defer></script>
        <title>GetFlix - Backoffice</title>
    </head>
    <body>
        <!-- HEADER -->
        <?php //include 'header.php' ?>
        <main>
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
                <?php include 'moviesbackoffice.php'; ?>
            </article>
            <article id="comments-tab" class="tabcontent">
                <h1>Comments</h2>
                <?php include 'commentsbackoffice.php'; ?>
            </article>
            <article id="users-tab" class="tabcontent">
                <h1>Users</h2>
            </article>
        <main>
    </body>
</html>