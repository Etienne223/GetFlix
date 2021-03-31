<?php
    include 'session.php';
    include 'dbconnection.php';
    include 'generalsettings.php';
?>


<?php 
/**** BACK-OFFICE PAGE *****/

// Action when delete comments in the table
    if (isset($_POST['delete_comment'])) {
        $id_comment = test_input($_POST['delete_comment']);
            $delete_comment= $db->prepare("DELETE FROM comments WHERE ID= :id");
            $delete_comment->execute(array(
                'id'=>$id_comment
            ));
            if (isset($_GET['search'])){
                header('Location: comments.php?search='.$_GET['search'].'');
            } else {
                header('Location: comments.php');
            }
           
    };

// Action when submit Search in search bar for comments
    if (isset($_POST['submit_search'])) {
        $search_comment = test_input($_POST['submit_search']);
        $answer_search_comment = $db->prepare('SELECT * FROM comments WHERE pseudo LIKE "%:search_comment%" OR movie_name LIKE "%:search_comment%"');
        $answer_search_comment->execute(array(
            ':search_comment'=> $search_comment       
        ));
        while ($mysearch= $answer_search_comment->fetch()){
?>
            <tr>
                <td><?php echo $mysearch['date']; ?></td>
                <td><?php echo $mysearch['pseudo']; ?></td>
                <td><?php echo $mysearch['movie_name']; ?></td>
                <td><?php echo $mysearch['comment']; ?></td>
                <td>
                    <form action="backofficesettings.php" method="post">
                        <button type="submit" name="delete_comment" value="<?php echo $mysearch['ID'];?>">Delete</button></td>
                    </form>    
            </tr>
<?php
        }
    }
?>