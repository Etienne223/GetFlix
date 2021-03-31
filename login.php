<?php
    // connect to database
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=getflix', 'root', 'root');
    }
    catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
    // SI PSEUDO ET PASSWORD SONT ISSET : RECHERCHE DANS LE TABLEAU L'ID ET LE PASSWORD CORRESPONDANT AU PSEUDO ENTRER
    if(isset($_POST['pseudo']) && isset($_POST['password'])){
    $pseudo = $_POST['pseudo'];
    $req = $db->prepare('SELECT id, password, authorization FROM users WHERE pseudo = :pseudo');
    $req->execute(array('pseudo' => $pseudo));
    $resultat = $req->fetch();

    // SI MOT DE PASSE != MOT DE PASSE CORRESPONDANT AU PSEUDO DANS LA BDD => MESSAGE D'ERREUR
    $isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);
        if (!$resultat){
            echo '<p>Mauvais identifiant ou mot de passe !</p>';
        }
        // SI MOT DE PASSE + MOT DE PASSE CORRESPONDANT AU PSEUDO -> CREATION D'UNE SESSION ET REDIRECTION VERS LA PAGE DE FILM
        else{
            if ($isPasswordCorrect){
                session_start();
                $_SESSION['id'] = $resultat['id'];
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['password'] = $resultat;
                $_SESSION['authorization'] = $resultat['authorization'];
                header('location: index.php');
            }
            else {
                echo 'Mauvais identifiant ou mot de passe !';
            }
        }
    }
?>
