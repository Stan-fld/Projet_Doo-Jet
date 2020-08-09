<?php

$feedback = "";
$model    = new Model;

// On récupere l'etape en cours.
$etape  = $model->getInput('etape');

// En fonction de l'étape en cours, un traitement sera effectué.
switch ($etape) {

    //|||||||||||||||||||||||||\\
    //| CHOIX DE L'EQUIPEMENT |\\
    //|||||||||||||||||||||||||\\

    case 'et1':

        unset($_SESSION['reservation']);
        $equipement = $model->getEquipementAllOn();

        // Récupere les infos
        $id_client = $model->getInput('id_client');
        $valuecount=0;


        foreach ($equipement as $eq)
        {
            $name = $eq['Nom_Equipement'];
            $value = $model->getInput("$name");
            $pers_num = $model->getInput("$name".'pers_num');

            if($value !== "")
            {
                //On compte le nombre de valeur sélectionné
                $valuecount ++;

                if($eq['Nom_Equipement'] == "JETSKI" || $eq['Nom_Equipement'] == "BATEAU")
                {
                    // On créer un table par équipement
                    $array[] = ["id_client" => $id_client, "equipement" => $value, "nb_personne" => 1];

                    // On met en session les informations
                    $_SESSION['reservation'] = $array;
                }
                else
                {
                    // On créer un table par équipement
                    $array[] = ["id_client" => $id_client, "equipement" => $value, "nb_personne" => $pers_num];

                    // On met en session les informations
                    $_SESSION['reservation'] = $array;
                }
            }
        }

        if ($valuecount == 0)
        {
            // Si aucune activité sélectionné, erreur
            $feedback .= '<script type="text/javascript">alert("Sélectionner au moins une activité !");</script>';
        }
        else
        {
            // On passe à l'étape suivante
            $feedback .= '<script type="text/javascript">alert("Vous avez sélectionné : '.$valuecount.' activités !");window.location.assign("createreservation2");</script>';
        }

        break;

    //||||||||||||||||||||\\
    //| CHOIX DE LA DATE |\\
    //||||||||||||||||||||\\

    case 'et2':

        $valid = 0;
        $valid2 = 0;

        // Recupére les infos
        $dateFr = $model->getInput('date_res');

        // Converti la date au format US
        $dateRes = substr($dateFr, 6, 4) . '-' . substr($dateFr, 3, 2) . '-' . substr($dateFr, 0, 2);

        // Rajoute un 0 devant le jour s'il à était enlevé
        if (strlen($dateFr) < 10) {
            $dateFr = '0' . $dateFr;
        }

        // Date du jour format US
        $now = date('Ymd');

        // Formatage de la date pour n'obtenir que des chiffres.
        $dateChoisie = substr($dateRes, 0, 4) . substr($dateRes, 5, 2) . substr($dateRes, 8, 2);

        if ($dateChoisie <= $now)
        {
            // Si date de réservation souhaitée antérieure ou égale à la date du jour,
            // on ne peut pas faire de réservation.
            $feedback .= '<script type="text/javascript">alert("La date doit etre supérieure à la date du jour ! merci de réessayer.");document.getElementById("date_res").focus();</script>';
        }
        else
        {
            foreach ($_SESSION['reservation'] as $resa)
            {
                $name = $resa['equipement'];
                $debut = $model->getInput('time_deb_'."$name");
                $fin = $model->getInput('time_fin_'."$name");

                //Convertir l'heure de début et de fin choisie en minutes
                $debut_min = (substr($debut, 0, 2)*60) + substr($debut, 3, 2);
                $fin_min = (substr($fin, 0, 2)*60) + substr($fin, 3, 2);
                $res = $fin_min - $debut_min ;

                if($res == 30 || $res == 60 || $res == 90 || $res == 120 || $res == 150 || $res == 180 || $res == 210 || $res == 240 || $res == 270 || $res == 300)
                {
                    // On met les infos en session
                    $array[] = ["id_client" => $resa['id_client'],
                        "equipement" => $resa['equipement'],
                        "nb_personne" => $resa['nb_personne'],
                        "date" => $dateFr,
                        "date_us" => $dateRes,
                        "datetime_deb" => $dateRes." ".$debut.':00',
                        "datetime_fin" => $dateRes." ".$fin.':00',
                        "heure_deb" => $debut,
                        "heure_fin"=> $fin,
                        "duree" => $res,];
                    $_SESSION['reservation'] = $array;
                    $valid ++;
                }

                else
                {
                    $array[] = ["id_client" => $resa['id_client'],
                        "equipement" => $resa['equipement'],
                        "nb_personne" => $resa['nb_personne'],];
                    $_SESSION['reservation'] = $array;
                    // on ne peut pas faire de réservation.
                    $feedback .= '<script type="text/javascript">alert("La durée est invalide pour cette activité! merci de réessayer.");</script>';
                }
            }

            foreach ($_SESSION['reservation'] as $r) { $valid2++; }


            if($valid == $valid2)
            {
                // On passe à l'étape suivante
                $feedback .= '<script>window.location.assign("/createreservation3");</script>';
            }
        }

        break;


    case 'et3':

        $valid = 0;
        $valid2 = 0;

        foreach ($_SESSION['reservation'] as $resa){
            $eq = $resa['equipement'];
            $id = $resa['id_client'];
            $nb_pers = ['nb_personne'];
            $debut = ['datetime_deb'];
            $fin = ['datetime_fin'];
            $duree = ['duree'];
            $valid2++;
        }
        if(isset($eq) && isset($id) && isset($debut) && isset($fin) && isset($duree) && isset($nb_pers))
        {

            // On créer une nouvelle réservation
            $newresa = $model->addIdresa();
            $id_resa = $newresa['id'];

            $addResaEC = $model->addResaEC($id_resa, $id);

            foreach ($_SESSION['reservation'] as $resa)
            {
                $name = $resa['equipement'];
                $eq = $resa['equipement'];
                $id = $resa['id_client'];
                $nb_pers = $resa['nb_personne'];
                $debut = $resa['datetime_deb'];
                $fin = $resa['datetime_fin'];
                $duree = $resa['duree'];

                // On récupére l'id de l'équipement
                $id_eq = $model->getInput('ideq_'."$name");

                $addresaEq = $model->addResaEq($id_resa, $id_eq, $debut, $fin);

                // On met les infos en session
                $array[] = ["id_client" => $resa['id_client'],
                    "equipement" => $resa['equipement'],
                    "nb_personne" => $resa['nb_personne'],
                    "date" => $resa['date'],
                    "date_us" => $resa['date_us'],
                    "heure_deb" => $resa['heure_deb'],
                    "heure_fin"=> $resa['heure_fin'],
                    "duree" => $resa['duree'],
                    "id_eq"=> $id_eq,
                ];
                $_SESSION['reservation'] = $array;

                $valid++;
            }
        }
        else {
            $feedback .= '<script type="text/javascript">alert("Votre session a expiré, merci de recommencer votre sélection !");window.location.assign("/createreservation");</script>';
        }

        if($valid == $valid2)
        {
            // On passe à l'étape suivante
            $feedback .= '<script>alert("Réservation prise avec succès !");window.location.assign("/createreservation4");</script>';
        }

        break;

}
