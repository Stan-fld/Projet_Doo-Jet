<?php

$feedback = "";
$model    = new Model;

$etape  = $model->getInput('etape');

switch ($etape) {

    case 'login':

        $identifiant = $model->getInput('identifiant');
        $password     = $model->getInput('password');

        $result = $model->getPassword($identifiant);
        $hash = $result['Password'];
        $id = $result['ID_Personne'];

        if (password_verify($password, $hash)) {

            $_SESSION['connexion']['id_connexion'] = $id;
            $_SESSION['connexion']['identifiant'] = $identifiant;
            $_SESSION['connexion']['passsword'] = $password;

            $feedback .= '<script type="text/javascript">alert("Vous êtes connecté");window.location.assign("/");</script>';

        } else {
            $feedback .= '<script type="text/javascript">alert("Mauvais nom d\'utilisateur ou mot de passe");</script>';
        }

        break;

    case 'logout':
        session_destroy();
        $feedback .= '<script type="text/javascript">alert("Déconnexion");window.location.assign("/connexion")</script>';
        break;
}