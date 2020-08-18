<?php

$feedback = "";
$model    = new Model;

$etape  = $model->getInput('etape');

switch ($etape) {

    //|||||||||||||||||||||\\
    //| CHOIX DE LA MODIF |\\
    //|||||||||||||||||||||\\

    case 'update_employe':

        $inact="";

        // Récupere les ID du formulaire pour modifier un employé
        $id_employe     = $model->getInput('id_employe');
        $id_adresse     = $model->getInput('id_adresse');

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

        // Récupere les infos du formulaire pour l'inactivité
        $motif       = $model->getInput('motifs');
        $date_debut  = $model->getInput('date_debut_ina');
        $date_fin    = $model->getInput('date_fin_ina');

        // Conversion des dates au format US
        $newanniv    = substr($anniv, 6, 4) . '-' . substr($anniv, 3, 2) . '-' . substr($anniv, 0, 2);
        $newembauche = substr($embauche, 6, 4) . '-' . substr($embauche, 3, 2) . '-' . substr($embauche, 0, 2);
        $newmedical  = substr($visit_med, 6, 4) . '-' . substr($visit_med, 3, 2) . '-' . substr($visit_med, 0, 2);
        $newdebut    = substr($date_debut, 6, 4) . '-' . substr($date_debut, 3, 2) . '-' . substr($date_debut, 0, 2);
        $newfin      = substr($date_fin, 6, 4) . '-' . substr($date_fin, 3, 2) . '-' . substr($date_fin, 0, 2);

        // Si la date est null on dit que la conversion est null
        if($date_fin == null)
        {
            $newfin = NULL;
        }

        // Date du jour -15 ans format US
        $now     = date('Y');
        $datenow = ($now - 15).date('-m-d');

        //On convertit les dates en nombre pour les comparer
        $date_debutcompare = substr($newdebut, 0, 4) . substr($newdebut, 5, 2) . substr($newdebut, 8, 2);
        $date_fincompare   = substr($newfin, 0, 4) . substr($newfin, 5, 2) . substr($newfin, 8, 2);

        $employe = $model->getEmploye($id_employe);
        if($employe['max_date_debut'] == null){
            $inact = "vide";
        }

        if ($inact == "vide")
        {
            //Si l'année de naissance est supérieur ou égal à l'année actuel -15 ans on retourne une erreur
            if(substr($newanniv, 0, 4) >=  substr($datenow, 0, 4))
            {
                $feedback .= '<script type="text/javascript">alert("Trop jeune")';
            }
            else
            {
                $update_employe = $model->updateEmploye($id_employe, $nom, $prenom, $newanniv, $telephone, $permis, $secu, $bees, $contrat, $newembauche, $newmedical);
                $update_ville = $model->updateVille($id_adresse, $ville, $code_post, $pays);
                $udpate_adresse = $model->updateAdresse($id_adresse, $num_rue, $rue, $voie);

                $feedback .= '<script type="text/javascript">alert("Modifications effectuées");window.location.assign("infoemploye?id=' . $id_employe . '");</script>';
            }

        }
        else
        {
            //Si l'année de naissance est supérieur ou égal à l'année actuel -15 ans on retourne une erreur
            if(substr($newanniv, 0, 4) >=  substr($datenow, 0, 4))
            {
                $feedback .= '<script type="text/javascript">alert("Trop jeune")';
            }
            //Sinon si la date de fin d'inactivité est inférieure et qu'elle n'est as égale à 0 à celle de début on retourne une erruer
            else if($date_fincompare <= $date_debutcompare && $newfin!==null)
            {
                $feedback .= '<script type="text/javascript">alert("La date de fin d\'inactivité ne peut pas être inférieure ou égale à celle de début")';
            }
            //Sinon si la période d'inactivité n'est pas renseigné on update pas
            else if($newdebut==null || $motif==null)
            {
                $feedback .= '<script type="text/javascript">alert("Date de début ou motif non renseigné")';
            }
            //Enfin on execute les requêtes préparées
            else{
                $update_employe = $model->updateEmploye($id_employe, $nom, $prenom, $newanniv, $telephone, $permis, $secu, $bees, $contrat, $newembauche, $newmedical);
                $update_ville = $model->updateVille($id_adresse, $ville, $code_post, $pays);
                $udpate_adresse = $model->updateAdresse($id_adresse, $num_rue, $rue, $voie);
                $update_inactivite = $model->updatePeriodeinact($id_employe, $motif, $newdebut, $newfin);

                $feedback .= '<script type="text/javascript">alert("Modifications effectuées");window.location.assign("infoemploye?id=' . $id_employe . '");</script>';
            }
        }
        break;


    case 'update_client':

        // Récupere les ID du formulaire pour modifier un client
        $id_client = $model->getInput('id_client');
        $id_adresse = $model->getInput('id_adresse');

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
            $update_employe = $model->updateClient($id_client, $nom, $prenom, $newanniv, $telephone, $permis);
            $update_ville = $model->updateVille($id_adresse, $ville, $code_post, $pays);
            $udpate_adresse = $model->updateAdresse($id_adresse, $num_rue, $rue, $voie);

            $feedback .= '<script type="text/javascript">alert("Modifications effectuées");window.location.assign("infoclient?id=' . $id_client . '");</script>';
        }
        break;


    case 'delete_client':

        $count = 0;

        // Récupere les ID du formulaire pour supprimer un client
        $id_client = $model->getInput('id_client');

        $id_adresse    = $model->getInput('id_adresse');

        // Date du jour format US
        $now = date('Y-m-d');

        $res = $model->getResaClientForDelete($id_client);

        foreach ($res as $resa)
        {
            if($resa['date'] >= $now)
            {
                $count ++;
            }
        }

        if($count !== 0)
        {
            $feedback .= '<script type="text/javascript">alert("Client requis pour une réservation future, suppression impossible");window.location.assign("/reservation");</script>';
        }
        else
        {
            foreach ($res as $resa)
            {
                $id_resa = $resa['ID_Reservation'];
                $delete_resa = $model->deletePersonneResa($id_resa, $id_client);
            }
            $delete_client = $model->deletePersonne($id_client, 'Client', $id_adresse);
            $feedback .= '<script type="text/javascript">alert("Client supprimé");window.location.assign("client");</script>';
        }

        break;


    case 'delete_employe':

        $count = 0;

        // Récupere les ID du formulaire pour supprimer un client
        $id_employe     = $model->getInput('id_employe');
        $id_adresse    = $model->getInput('id_adresse');

        $id_inact = $model->getEmployemalade($id_employe);

        $delete_employemalade = $model->deleteEmployemalade($id_employe);

        // Date du jour format US
        $now = date('Y-m-d');

        foreach ($id_inact as $inactivite)
        {
            $delete_inact = $model->deletePeriodeInact($inactivite['ID_Inactivite']);
        }

        $res = $model->getResaEmploForDelete($id_employe);

        foreach ($res as $resa)
        {
            if($resa['date'] >= $now)
            {
                $count ++;
            }
        }

        if($count !== 0)
        {
            $feedback .= '<script type="text/javascript">alert("Employé requis pour une réservation future, suppression impossible");window.location.assign("/reservation");</script>';
        }
        else
        {
            foreach ($res as $resa)
            {
                $id_resa = $resa['ID_Reservation'];
                $delete_resa = $model->deletePersonneResa($id_resa, $id_employe);
            }

            $delete_client = $model->deletePersonne($id_employe, "Employé", $id_adresse);
            $feedback .= '<script type="text/javascript">alert("Employé supprimé");window.location.assign("/employe");</script>';
        }

        break;


    case 'create_inact':

        $inactDate = "";

        // Récupere les ID du formulaire pour modifier un employé
        $id_employe_inact     = $model->getInput('id_employe');

        // Récupere les infos du formulaire pour l'inactivité
        $motifs         = $model->getInput('newmotifs');
        $newdate_debut  = $model->getInput('newdate_debut');
        $newdate_fin    = $model->getInput('newdate_fin');

        // Conversion des dates au format US
        $debut    = substr($newdate_debut, 6, 4) . '-' . substr($newdate_debut, 3, 2) . '-' . substr($newdate_debut, 0, 2);
        $fin      = substr($newdate_fin, 6, 4) . '-' . substr($newdate_fin, 3, 2) . '-' . substr($newdate_fin, 0, 2);

        // Si la date est null on dit que la conversion est null
        if($newdate_fin == null)
        {
            $fin = NULL;
        }

        //On convertit les dates en nombre pour les comparer
        $debut_compare = substr($debut, 0, 4) . substr($debut, 5, 2) . substr($debut, 8, 2);
        $fin_compare   = substr($fin, 0, 4) . substr($fin, 5, 2) . substr($fin, 8, 2);

        $employe = $model->getEmploye($id_employe_inact);

        //Si la date de fin est vide et que les autres champs ne son pas vide on ne peut pas ajouter une nouvelle periode d'inactivité
        if($employe['max_date_fin'] == null && $employe['max_date_debut'] !==null && $employe['Motif'] !== null){
            $inactDate = "date_vide";
        }

        //Si la date de fin est vide on retourne une erreur
        if($inactDate == "date_vide")
        {
            $feedback .= '<script type="text/javascript">alert("Pour ajouter une nouvelle période d\'inactivité, il faut que l\'ancienne période soit finie.")';
        }
        else {
            //Si la date de fin d'inactivité est inférieure et qu'elle n'est as égale à 0 à celle de début on retourne une erreur
            if ($fin_compare <= $debut_compare && $fin !== null) {
                $feedback .= '<script type="text/javascript">alert("La date de fin d\'inactivité ne peut pas être inférieure ou égale à celle de début.")';
            }
            //Sinon si la date de fin d'inactivité est inférieure et qu'elle n'est as égale à 0 à celle de début on retourne une erruer
            else if ($debut == null || $motifs == null) {
                $feedback .= '<script type="text/javascript">alert("Date de début ou motif non renseigné")';
            }
            //Enfin on execute les requêtes préparées
            else {
                $new_inact = $model->addPeriodeinact($id_employe_inact, $motifs, $debut, $fin);
                $feedback .= '<script type="text/javascript">alert("Période d\'inactictivité ajoutée");window.location.assign("infoemploye?id=' . $id_employe_inact . '");</script>';
            }
        }

        break;


    case 'create_employe':


        // Récupere les infos du formulaire pour les personnes
        $nom       = $model->getInput('nom');
        $prenom    = $model->getInput('prenom');
        $anniv     = $model->getInput('date_naissance');
        $telephone = $model->getInput('telephone');
        $password = $model->getInput('password');
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


        // On Hash le mot de passe
        $pswd = password_hash($password, PASSWORD_DEFAULT);

        // Conversion des dates au format US
        $newanniv    = substr($anniv, 6, 4) . '-' . substr($anniv, 3, 2) . '-' . substr($anniv, 0, 2);
        $newembauche = substr($embauche, 6, 4) . '-' . substr($embauche, 3, 2) . '-' . substr($embauche, 0, 2);
        $newmedical  = substr($visit_med, 6, 4) . '-' . substr($visit_med, 3, 2) . '-' . substr($visit_med, 0, 2);


        // Date du jour -15 ans format US
        $now     = date('Y');
        $datenow = ($now - 15).date('-m-d');

        if($permis == ""){$permis = NULL;}
        if($bees == ""){$bees = NULL;}


        //Si l'année de naissance est supérieur ou égal à l'année actuel -15 ans on retourne une erreur
        if(substr($newanniv, 0, 4) >=  substr($datenow, 0, 4))
        {
            $feedback .= '<script type="text/javascript">alert("Trop jeune")';
        }
        else
        {
            $add_employe= $model->addEmploye($nom, $prenom, $newanniv, $telephone, $permis, $ville, $code_post, $pays, $num_rue, $rue, $voie, $secu, $bees, $contrat, $newembauche, $newmedical, $pswd);
            $feedback .= '<script type="text/javascript">alert("Employé ajouté");window.location.assign("/")</script>';
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

        if($permis == ""){$permis = NULL;}

        //Si l'année de naissance est supérieur ou égal à l'année actuel on retourne une erreur
        if(substr($newanniv, 0, 4) >=  substr($datenow, 0, 4))
        {
            $feedback .= '<script type="text/javascript">alert("Trop jeune")';
        }
        //Enfin on execute les requêtes préparées
        else
        {
            $add_cient = $model->addClient($nom, $prenom, $newanniv, $telephone, $permis, $ville, $code_post, $pays, $num_rue, $rue, $voie);
            $feedback .= '<script type="text/javascript">alert("Client ajouté");window.location.assign("/client")</script>';
        }
        break;


    default:
        $feedback .= '<script type="text/javascript">alert("Erreur");window.location.assign("/");</script>';
        break;
}