<?php

$model    = new Model;

$etape  = $model->getInput('etape');

switch ($etape) {

    //|||||||||||||||||||||\\
    //| CHOIX DE LA MODIF |\\
    //|||||||||||||||||||||\\

    case 'create_employe':


        // Récupere les infos du formulaire pour les personnes
        $nom       = $model->getInput('nom');
        $prenom    = $model->getInput('prenom');
        $anniv     = $model->getInput('date_naissance');
        $telephone = $model->getInput('telephone');
        $permis    = $model->getInput('num_permis');
        $secu      = $model->getInput('num_secu');
        $bees      = $model->getInput('num_bees');
        $contrat   = $model->getInput('contrat');
        $embauche  = $model->getInput('date_embauche');
        $visit_med = $model->getInput('date_visite_med');

        // Récupere les infos du formulaire pour la ville
        $ville         = $model->getInput('ville');
        $code_post     = $model->getInput('code_postal');
        $pays          = $model->getInput('nom_pays');

        // Récupere les infos du formulaire pour l'adresse
        $num_rue     = $model->getInput('num_voie');
        $rue         = $model->getInput('nom_voie');
        $voie        = $model->getInput('type_voie');


        // Conversion des dates au format US
        $newanniv    = substr($anniv, 6, 4) . '-' . substr($anniv, 3, 2) . '-' . substr($anniv, 0, 2);


        // Date du jour -15 ans format US
        $now     = date('Y');
        $datenow = ($now - 15).date('-m-d');


        //Si l'année de naissance est supérieur ou égal à l'année actuel -15 ans on retourne une erreur
        if(substr($newanniv, 0, 4) >=  substr($datenow, 0, 4))
        {
            $feedback .= '<script type="text/javascript">alert("Trop jeune")';
        }
        else
            {
                $add_cient = $model->addEmploye($nom, $prenom, $newanniv, $telephone, $permis, $ville, $code_post, $pays, $num_rue, $rue, $voie, $secu, $bees, $contrat, $embauche, $visit_med);
            }

        break;


    case 'create_client':

        // Récupere les infos du formulaire pour les personnes
        $nom       = $model->getInput('nom');
        $prenom    = $model->getInput('prenom');
        $anniv     = $model->getInput('date_naissance');
        $telephone = $model->getInput('telephone');
        $permis    = $model->getInput('num_permis');

        // Récupere les infos du formulaire pour la ville
        $ville         = $model->getInput('ville');
        $code_post     = $model->getInput('code_postal');
        $pays          = $model->getInput('nom_pays');

        // Récupere les infos du formulaire pour l'adresse
        $num_rue     = $model->getInput('num_voie');
        $rue         = $model->getInput('nom_voie');
        $voie        = $model->getInput('type_voie');


        // Conversion des dates au format US
        $newanniv = substr($anniv, 6, 4) . '-' . substr($anniv, 3, 2) . '-' . substr($anniv, 0, 2);

        // Date du jour format US
        $now     = date('Y');
        $datenow = ($now - 15).date('-m-d');

        //Si l'année de naissance est supérieur ou égal à l'année actuel on retourne une erreur
        if(substr($newanniv, 0, 4) >=  substr($datenow, 0, 4))
        {
            $feedback .= '<script type="text/javascript">alert("Trop jeune")';
        }
        //Enfin on execute les requêtes préparées
        else
        {
            $add_cient = $model->addClient($nom, $prenom, $newanniv, $telephone, $permis, $ville, $code_post, $pays, $num_rue, $rue, $voie);
            $feedback .= '<script type="text/javascript">alert("Client ajouté");window.location.assign("/")</script>';
        }
        break;

    default:
        $feedback .= '<script type="text/javascript">alert("Erreur");window.location.assign("/")</script>';
        break;
}