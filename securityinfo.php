<?php
// FORMAT DETECTION
$search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); // htmlspecial characters, ENT_QUOTES (escape single and double quotes)
trim(); // remove unnecessary characters
stripslasehs(); // remove backslashes

//E-MAIL
    // validate
    if(filter_var($address, FILTER_VALIDATE_EMAIL)){ 
    echo "Email is valid."; 
    } else { 
    echo "Not valid."; 
    }

    //Remove all characters from the email except letters, digits and !#$%&'*+-=?^_`{|}~@.[] 
    echo filter_var($dirtyAddress, FILTER_SANITIZE_EMAIL);

    // filter_var quand fonction existe / regex quand format spécifique


// DATABASE
    // database name and password on file config.php --> define() Ex: define('DB_NAME', 'name);
    // privileges to each user (create, alter, select, insert, update, delete)


// ACTION IN FORM
?><form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"></form><?php

sleep() // pour les forms, à la fin https://nouvelle-techno.fr/actualites/php-les-failles-et-attaques-courantes-comment-se-proteger



// PHP CSRF (Cross Site Request Forgery) Protection
    // generate token by user input (include as a hidden input on click) <input type="hidden" name="token" value="---generatedTokeNumber---">
    // store token inside a SESSION, so hacker won't have access to it
    // tutorial on generating token: https://www.youtube.com/watch?v=VflbINBabc4

    

// external options
    // https://docs.laminas.dev/laminas-filter/intro/
    


// --------- VERIFIER !! ---------
    // ARRAY PROTECTION (pas pour PDO)
    array('mysql_real_escape_string', $array);
    // https://www.php.net/manual/fr/function.mysql-real-escape-string.php
    // https://stackoverflow.com/questions/14012642/what-is-the-pdo-equivalent-of-function-mysql-real-escape-string/14012675

