<?php
    include 'session.php';
    include 'dbconnection.php';
    include 'generalsettings.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="backoffice.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
        <title>GetFlix - Backoffice</title>
    </head>
    <body>
    <article id="commentsmanagement">
        <form method="get">
            <input id="search" name="search" type="text" placeholder="Search..."/>
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
        <section>
            <table id="tablecomments">
                <tr>
                    <th>Date</th>
                    <th>User</th>
                    <th>Movie</th>
                    <th>Comment</th>
                    <th>Delete</th>
                </tr>
            <?php 
                if (isset($_GET['search'])) {
                    $search_comment = test_input($_GET['search']);
                    if (!empty($_GET['search'])){
                        $answer_comments = $db->query("SELECT * FROM comments WHERE pseudo LIKE '%$search_comment%' OR movie_name LIKE '%$search_comment%' OR comment LIKE '%$search_comment%' OR date LIKE '%$search_comment%'");
                    } else {
                        $answer_comments = $db->query('SELECT * FROM comments');
                        header('Location: comments.php');
                    }
                } else {
                    $answer_comments = $db->query('SELECT * FROM comments');
                }
                    
                    while ($mysearch= $answer_comments->fetch()){
            ?>
            <tr>
                <td><?php echo $mysearch['date']; ?></td>
                <td><?php echo $mysearch['pseudo']; ?></td>
                <td><?php echo $mysearch['movie_name']; ?></td>
                <td><?php echo $mysearch['comment']; ?></td>
                <td>
                    <form action="backofficesettings.php" method="post">
                        <button type="submit" name="delete_comment" value="<?php echo $mysearch['ID'];?>">Delete</button>
                    </form>    
                </td>
            </tr>
            <?php
                }
            ?>
            </table>
        </section>        
    </article>
    </body>
</html>