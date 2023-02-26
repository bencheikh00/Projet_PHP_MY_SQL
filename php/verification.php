<?php

if (isset($_POST['identifiant']) && isset($_POST['numero'])) {
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
    $identifiant = mysqli_real_escape_string($db, htmlspecialchars($_POST['identifiant']));
    $numero = mysqli_real_escape_string($db, htmlspecialchars($_POST['numero']));

    if ($identifiant !== "" && $numero !== "") {
        $requete = "SELECT count(*) FROM administrateur where  ID_ADMI = '" . $identifiant . "' and TELEPHONE = '" . $numero . "' ";
        $exec_requete = mysqli_query($db, $requete);
        $reponse = mysqli_fetch_array($exec_requete);
        $count = $reponse['count(*)'];
        if ($count != 0) // nom d'utilisateur et mot de passe correctes
        {
            $_SESSION['identifiant'] = $identifiant;
            header('Location: option.php');
        } else {
            header('Location: connexion.php?erreur=1'); // utilisateur ou mot de passe invalide
        }
    } else {
        header('Location: connexion.php?erreur=2'); // utilisateur ou mot de passe vide
    }
} else {
    header('Location: connexion.php?erreur=3'); // champs manquantes
}
mysqli_close($db); // fermer la connexion
