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
            $_SESSION['connexion']['passsword'] = $hash;

            $feedback .= '<script type="text/javascript">alert("Vous êtes connecté");window.location.assign("/");</script>';

        } else {
            $feedback .= '<script type="text/javascript">alert("Mauvais nom d\'utilisateur ou mot de passe");</script>';
        }

        break;

    case'updatepassword':

        $hash = $_SESSION['connexion']['passsword'];
        $id = $_SESSION['connexion']['id_connexion'];
        $old_password         = $model->getInput('old_password');
        $new_password         = $model->getInput('new_password');

        if(password_verify($old_password, $hash))
        {
            // On Hash le mot de passe
            $pswd = password_hash($new_password, PASSWORD_DEFAULT);
            $_SESSION['connexion']['passsword'] = $pswd;

            $newpswd = $model->updatePassword($id, $pswd);
            $feedback.= '<script>alert("Mot de passe changé");window.location.assign("/")</script>';

        }
        else
        {
            $feedback.= '<script>alert("Ancien mot de passe incorect")</script>';
        }

        break;
    /*
        case 'logout':
            session_destroy();
            $feedback .= '<script type="text/javascript">alert("Déconnexion");window.location.assign("/connexion")</script>';
            break;
    */
}