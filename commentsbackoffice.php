<?php 
    // Action when delete comments in the table
        if (isset($_POST['delete_comment'])) {
            $id_comment = test_input($_POST['delete_comment']);
            $delete_comment= $db->prepare("DELETE FROM comments WHERE ID= :id");
            $delete_comment->execute(array(
                'id'=>$id_comment
            ));
            if (isset($_GET['searchc'])){
                header('Location: backoffice.php?searchc='.$_GET['searchc'].'#comments');
            } /* else if (!isset($_GET['searchc'])){
                header('Location: backoffice.php#comments');
            } */
        }

    // Action search comment
        if (isset($_GET['searchc'])) {
            $search_comment = test_input($_GET['searchc']);
            if (!empty($_GET['searchc'])){
                $answer_comments = $db->query("SELECT * FROM comments WHERE pseudo LIKE '%$search_comment%' OR movie_name LIKE '%$search_comment%' OR comment LIKE '%$search_comment%' OR date LIKE '%$search_comment%'");
            } else {
                $answer_comments = $db->query('SELECT * FROM comments');
            }
        } else {
            $answer_comments = $db->query('SELECT * FROM comments');
        }
        
    ?>

        <article id="commentsmanagement">
            <form method="get">
                <input id="search" name="searchc" type="text" placeholder="Search..."/>
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
                    while ($mysearch= $answer_comments->fetch()){
                ?>
                <tr>
                    <td><?php echo $mysearch['date']; ?></td>
                    <td><?php echo $mysearch['pseudo']; ?></td>
                    <td><?php echo $mysearch['movie_name']; ?></td>
                    <td><?php echo $mysearch['comment']; ?></td>
                    <td>
                        <form method="post">
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