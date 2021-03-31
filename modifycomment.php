<?php
    include 'session.php';
    include 'dbconnection.php';
    include 'generalsettings.php';

    if (!isset($_POST['modify_comment'])) {  
        $idthiscomment = test_input($_POST['modify_comment']);
        
    }

?>