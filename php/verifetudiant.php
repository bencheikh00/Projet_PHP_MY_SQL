<?php

if (isset($_POST['email']) && isset($_POST['id'])) {
    // connexion à la base de données
    $db_username = '301672_iam';
    $db_password = 'alfadel';
    $db_name = 'projetfigmaofficiel_iam';
    $db_host = 'mysql-projetfigmaofficiel.alwaysdata.net';
    $db_port = 3306;
    $db = mysqli_connect($db_host, $db_username, $db_password, $db_name, $db_port)
        or die('could not connect to database');

    // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
    // pour éliminer toute attaque de type injection SQL et XSS
    $email = mysqli_real_escape_string($db, htmlspecialchars($_POST['email']));
    $id = mysqli_real_escape_string($db, htmlspecialchars($_POST['id']));

    if ($email !== "" && $id !== "") {
        $requete = "SELECT count(*) FROM etudiant where  E_MAIL = '" . $email . "' and ID_ETUDIANT = '" . $id . "' ";
        $exec_requete = mysqli_query($db, $requete);
        $reponse = mysqli_fetch_array($exec_requete);
        $count = $reponse['count(*)'];
        if ($count != 0) // nom d'utilisateur et mot de passe correctes
        {
            $_SESSION['email'] = $email;
            header('Location: /projetfigma1/php/chambretudiant.php');
        } else {
            header('Location: /projetfigma1/php/connexetudiant.php?erreur=1'); // utilisateur ou mot de passe invalide
        }
    } else {
        header('Location: /projetfigma1/php/connexetudiant.php?erreur=2'); // utilisateur ou mot de passe vide
    }
} else {
    header('Location: /projetfigma1/php/connexetudiant.php?erreur=3'); // champs manquantes
}
mysqli_close($db); // fermer la connexion
