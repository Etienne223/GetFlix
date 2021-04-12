<?php
// When click to edit user rank
    if (isset($_POST['edit_rank'])) {
      $id_user = test_input($_POST['edit_rank']);
      $edit_rank= $db->prepare("UPDATE users SET authorization='1' WHERE ID=:id");
      $edit_rank->execute(array(
          'id'=>$id_user
      ));
    }
// When click to delete user
    if (isset($_POST['delete_user'])) {
        $id_user = test_input($_POST['delete_user']);
        $delete_user= $db->prepare("DELETE FROM users WHERE ID= :id");
        $delete_user->execute(array(
            'id'=>$id_user
        ));
        if (isset($_GET['searchu'])){
        header('Location: backoffice.php?searchu='.$_GET['searchu'].'#users');
      } else { header('Location: backoffice.php#users'); }
    }
// When searching for user
    if (isset($_GET['searchu'])) {
        $search_user = test_input($_GET['searchu']);
        if (!empty($_GET['searchu'])){
            $answer_users = $db->query("SELECT * FROM users WHERE pseudo LIKE '%$search_user%' OR mail LIKE '%$search_user%'");
        } else {
            $answer_users = $db->query('SELECT * FROM users');
        }
    } else {
        $answer_users = $db->query('SELECT * FROM users ORDER BY ID ASC');
    }
?>
  <article id="usersmanagement">
    <form method="get">
        <input id="search" name="searchu" type="text" placeholder="Search..."/>
        <button type="submit"><i class="fas fa-search"></i></button>
    </form>
    <section>
        <table id="tableusers">
            <tr>
                <th>Id</th>
                <th>Pseudo</th>
                <th>Email</th>
                <th>Registration date</th>
                <th>Rank</th>
                <th>Edit Rank</th>
                <th>Delete</th>
            </tr>
        <?php
            while ($mysearch= $answer_users->fetch()){
        ?>
        <tr>
            <td><?php echo $mysearch['id']; ?></td>
            <td><?php echo $mysearch['pseudo']; ?></td>
            <td><?php echo $mysearch['mail']; ?></td>
            <td><?php echo $mysearch['date_insc']; ?></td>
            <td class="DescSize"><?php if ($mysearch['authorization'] == 1){echo 'Admin';} else {echo 'User';} ?></td>
            <td>
              <form method="post">
                <button type="submit" name="edit_rank" value="<?php echo $mysearch['id']; ?>"><i class="fas fa-crown"></i></button>
              </form>
            </td>
            <td>
                <form method="post">
                    <button type="submit" name="delete_user" value="<?php echo $mysearch['id'];?>"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
        <?php
            }
        ?>
        </table>
    </section>
</article>
