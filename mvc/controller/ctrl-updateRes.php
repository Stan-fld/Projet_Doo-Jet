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

        // On vide la session réservation à chaque nouvelles réservations par sécurité
        unset($_SESSION['reservation']);

        // On récupére les équipement en service
        $equipement = $model->getEquipementAllOn();

        // Récupere les infos du formulaire
        $id_client = $model->getInput('id_client');

        // On initialise notre compteur
        $valuecount=0;


        foreach ($equipement as $eq)
        {
            $name = $eq['Nom_Equipement'];
            $value = $model->getInput("$name");
            $pers_num = $model->getInput("$name".'pers_num');

            if($value !== "")
            {
                // On compte le nombre de valeurs sélectionnés
                $valuecount ++;

                // Si c'est jetski ou bateau on met le compteur de personne sur 1
                if($eq['Nom_Equipement'] == "JETSKI" || $eq['Nom_Equipement'] == "BATEAU")
                {
                    // On créer un tableau par équipement
                    $array[] = ["id_client" => $id_client, "equipement" => $value, "nb_personne" => 1];

                    // On met en session les informations
                    $_SESSION['reservation'] = $array;
                }
                else
                {
                    // On créer un tableau par équipement
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

        // On initialise nos différents compteurs
        $valid = 0;
        $valid2 = 0;
        $valid3 = 0;
        $count = 0;

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

        if ($dateChoisie < $now)
        {
            // Si date de réservation souhaitée antérieure ou égale à la date du jour,
            // on ne peut pas faire de réservation.
            $feedback .= '<script type="text/javascript">alert("La date ne doit pas être inférieur à la date du jour ! merci de réessayer.");document.getElementById("date_res").focus();</script>';
        }
        else
        {
            // Pour chaque groupe d'équipement réservé
            foreach ($_SESSION['reservation'] as $resa)
            {
                // On récupère les valeurs en session et du formulaire
                $name = $resa['equipement'];
                $debut = $model->getInput('time_deb_'."$name");
                $fin = $model->getInput('time_fin_'."$name");

                //Convertir l'heure de début et de fin choisie en minutes
                $debut_min = (substr($debut, 0, 2)*60) + substr($debut, 3, 2);
                $fin_min = (substr($fin, 0, 2)*60) + substr($fin, 3, 2);
                $res = $fin_min - $debut_min ;

                // Si on a des plage horaires de 30 mins en 30 mins c'est ok
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
                    // On ajoute +1 au passage de chaque équipement pour pouvoir passer à létape suivante
                    $valid ++;
                }

                else
                {
                    //On remet quand même les anciennes info en session ar sécurité
                    $array[] = ["id_client" => $resa['id_client'],
                        "equipement" => $resa['equipement'],
                        "nb_personne" => $resa['nb_personne'],];
                    $_SESSION['reservation'] = $array;
                    // on ne peut pas faire de réservation.
                    $feedback .= '<script type="text/javascript">alert("La durée est invalide pour '.$name.' ! merci de réessayer.");</script>';
                }
            }

            // On compte le nombre de réservation pour le comparer avec celui plus haut
            foreach ($_SESSION['reservation'] as $r) { $valid2++; }

            // On fait cette vérification seulement si la plage horaire sélectionné est valide
            if($valid == $valid2)
            {
                // Pour groupe d'équipement on va vérifier si au moin un équipement est disponible avant de passer à la suite
                foreach ($_SESSION['reservation'] as $resa)
                {
                    // On appelle la fonction qui appelle la procédure stockée
                    $eq_dispo = $model->getEquipementDispo($resa['datetime_deb'], $resa['datetime_fin'], $resa['equipement'], $resa['duree']);

                    // Pour chaque équipement appartenant au groupe sélectionner que retourne la requête
                    foreach($eq_dispo as $eq_dispos)
                    {
                        // Si l'équipement est dispo on lui attribut la valeur 1
                        if($eq_dispos['Nom_Equipement'] !== "" || $eq_dispos['ID_Equipement'] !== "")
                        {
                            $count = 1;
                        }
                    }

                    // Si le groupe d'équipement retourne 0 cela veux dire que aucun équipement n'est disponible
                    if($count == 0)
                    {
                        // On retourne une erreur et on ajoute la valeur 1 à la validation 3
                        $feedback .= '<script>alert("Pas de '.$resa['equipement'].' disponibles pour cette tranche horaire!");</script>';
                        $valid3 = 1;
                    }
                    // On remet le compteur à 0 afin que si il y est plusieurs groupe d'équipements dans la réservation,
                    // la vérification se fasse bien
                    $count = 0;
                }
            }

            // On passe à létape suivante si il n'y à eu aucuns problèmes
            if($valid == $valid2 && $valid3 == 0)
            {
                // On passe à l'étape suivante
                $feedback .= '<script>alert("Équipements disponibles !");window.location.assign("/createreservation3");</script>';
            }
        }

        break;


    case 'et3':

        // On initialise nos compteurs
        $valid = 0;
        $valid2 = 0;

        foreach ($_SESSION['reservation'] as $resa){
            $eq = $resa['equipement'];
            $id_client = $resa['id_client'];
            $nb_pers = ['nb_personne'];
            $debut = ['datetime_deb'];
            $fin = ['datetime_fin'];
            $duree = ['duree'];
            $valid2++;
        }

        // On vérifie si les infos sont bien toujours présentent en session
        if(isset($eq) && isset($id_client) && isset($debut) && isset($fin) && isset($duree) && isset($nb_pers))
        {

            // On créer une nouvelle réservation dans la table réservation
            $newresa = $model->addIdresa();

            // On récupère l'ID de cette réservation
            $id_resa = $newresa['id'];

            // On ajoute le client à la table réservtion_client_employé
            $addResaEC = $model->addResaEC($id_resa, $id_client);

            // Pour chaque groupe d'équipement réservé
            foreach ($_SESSION['reservation'] as $resa)
            {
                $total = 0;

                // On récupére les infos en session
                $name = $resa['equipement'];
                $id_client = $resa['id_client'];
                $nb_pers = $resa['nb_personne'];
                $debut = $resa['datetime_deb'];
                $fin = $resa['datetime_fin'];
                $duree = $resa['duree'];

                // On récupére l'id de l'équipement
                $val = $model->getInput('ideq_'."$name");
                list($id_eq, $prix) = explode('-',$val);

                // On récupére l'id de l'employé
                $id_employe = $model->getInput('idemp_'."$name");

                if($id_employe !== "")
                {
                    // On ajoute l'employé à la table réservtion_client_employé
                    $addResaEC = $model->addResaEC($id_resa, $id_employe);

                    if($resa['equipement'] == "JETSKI")
                    {
                        $total = ((($prix*$resa['nb_personne'])*20/100)+$prix);

                        // On ajoute la réservation dans la table equipements réservés
                        $addresaEq = $model->addResaEq($id_resa, $id_eq, $debut, $fin, $total, $nb_pers, $id_employe);
                    }
                    else
                    {
                        $total = ($prix*$resa['nb_personne']);

                        // On ajoute la réservation dans la table equipements réservés
                        $addresaEq = $model->addResaEq($id_resa, $id_eq, $debut, $fin, $total, $nb_pers, $id_employe);
                    }

                }
                else
                {
                    $total = ($prix*$resa['nb_personne']);

                    // On ajoute la réservation dans la table equipements réservés
                    $addresaEq = $model->addResaEq($id_resa, $id_eq, $debut, $fin, $total, $nb_pers, NULL);
                }

                // On met les infos en session
                $array[] = ["id_client" => $id_client,
                    "equipement" => $name,
                    "nb_personne" => $resa['nb_personne'],
                    "date" => $resa['date'],
                    "heure_deb" => $resa['heure_deb'],
                    "heure_fin" => $resa['heure_fin'],
                    "duree" => $duree,
                    "id_eq" => $id_eq,
                    "id_resa" =>$id_resa,
                    "id_employe" => $id_employe,
                    "prix" => $prix];
                $_SESSION['reservation'] = $array;

                // On vérifie si l'action se fait bien pour les deux
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


    case 'etPDF':

        $total = 0;
        $totalF = 0;

        $id_resa = $_SESSION['reservation'][0]['id_resa'];
        $id_client = $_SESSION['reservation'][0]['id_client'];
        $date = $_SESSION['reservation'][0]['date'];

        $client = $model->getClient($id_client);

        $nom = $model->getInput('nom');
        $prenom = $model->getInput('prenom');
        $tel = $model->getInput('tel');
        $adresse = $client['Numero_Rue']." ".$client['Type_Voie']." ".$client['Rue']." - ".$client['Code_Postal']." ".$client['Nom_Ville']." - ".$client['Nom_Pays'];


        require_once __DIR__.'/../../vendor/autoload.php';


        $mpdf = new \Mpdf\Mpdf();

        // Creation du PDF
        $data = '';

        $data .='<img src="../../images/icon/logo.png"/>
                 <p style="text-align: right; margin-top: -50px"><strong>reservation numéro : </strong>'.$id_resa.'</p>
                 <h1 style="text-align: center; margin-top: 60px">Réservation pour le : <span style="font-weight: normal">'.$date.'</span></h1>';


        $data .= '<p style="margin-top: 5px; margin-bottom: 5px"> </p>';
        $data .= '<h2 style="font-weight: normal; margin-top: 0px;">De : </h2>';
        $data .= '<strong>Nom : </strong>'.$nom.'<br/>';
        $data .= '<p style="margin-top: 5px; margin-bottom: 5px"> </p>';
        $data .= '<strong>Prénom : </strong>'. $prenom .'<br/>';
        $data .= '<p style="margin-top: 5px; margin-bottom: 5px"> </p>';
        $data .= '<strong>Téléphone : </strong>'. $tel .'<br/>';
        $data .= '<p style="margin-top: 5px; margin-bottom: 5px"> </p>';
        $data .= '<strong>Adresse : </strong>'. $adresse .'<br/>';
        $data .= '<p style="margin-top: 5px; margin-bottom: 5px"> </p>';
        $data .= '<hr>';

        foreach ($_SESSION['reservation'] as $resa) {

            $id_eq = $resa['id_eq'];
            $id_employe = $resa['id_employe'];
            $nb_pers = $resa['nb_personne'];
            $debut = $resa['heure_deb'];
            $fin = $resa['heure_fin'];
            $prix = $resa['prix'];
            $nom_eq = $resa['equipement'];

            $employe = $model->getEmploye($id_employe);
            $nom_emp = $employe['Nom'];
            $prenom_emp = $employe['Prenom'];


            $eq = $model->getEquipement($id_eq);
            $commentaire = $eq['Commentaire'];

            $data .= '<p style="margin-top: 5px; margin-bottom: 5px"> </p>';
            $data .= '<h2 style="font-weight: normal; margin-top: 0px;">Activité : <span style="font-weight: bold">' . $nom_eq . '</span></h2>';

            if ($nom_eq == "JETSKI") {
                $data .= '<strong>Nom du Jetski : </strong>' . $commentaire . '<br/>';
                $data .= '<p style="margin-top: 5px; margin-bottom: 5px"> </p>';
            } else {}

            $data .= '<strong>Nombre de personnes : </strong>' . $nb_pers . '<br/>';
            $data .= '<p style="margin-top: 5px; margin-bottom: 5px"> </p>';
            $data .= '<strong>Heure de début : </strong>' . $debut . '<br/>';
            $data .= '<p style="margin-top: 5px; margin-bottom: 5px"> </p>';
            $data .= '<strong>Heure de fin : </strong>' . $fin . '<br/>';
            $data .= '<p style="margin-top: 5px; margin-bottom: 5px"> </p>';
            if ($id_employe !== "") {
                $data .= '<strong>Nom employé : </strong>' . $nom_emp . '<br/>';
                $data .= '<p style="margin-top: 5px; margin-bottom: 5px"> </p>';
                $data .= '<strong>Prénom employé : </strong>' . $prenom_emp . '<br/>';
            }else{}
            $data .= '<p style="margin-top: 5px; margin-bottom: 5px"> </p>';
            $data .= '<strong>Prix par personne : </strong>' . $prix . ' &euro;<br/>';
            $data .= '<p style="margin-top: 5px; margin-bottom: 5px"> </p>';

            if ($nom_eq == "JETSKI" && $id_employe !== "") {
                $total += ((($prix * $nb_pers) * 20 / 100) + $prix);
            } else {
                $total = ($prix * $nb_pers);
            }
            $data .= '<strong>Total pour l\'activité ' . $commentaire . ' : </strong>' . $total . ' &euro;<br/>';
            $data .= '<p style="margin-top: 5px; margin-bottom: 5px"> </p>';
            $data .= '<hr>';

            $totalF += $total;
        }

        $data .=  '<h2 style="text-align: center; margin-top: 30px">TOTAL : <span style="font-weight: normal">'.$totalF.' &euro;</span></h2>';

        // Ecrit le PDF
        $mpdf->writeHTML($data);


        $dateUS = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);

        $pdfFilePath = '[reservation_N°'.$id_resa.']'.$dateUS.'.pdf';

        // Envoie au navigateur
        $mpdf->Output("reservations/".$pdfFilePath, "F");

        $feedback.='<script>$( document ).ready(function() {$("#pdfhide").css("display", "none");$("#pdfhide").prop("disabled", false);});window.open("reservations/'.$pdfFilePath.'", "_blank");</script>';

        break;


    case 'etFini':
        // On vide la session réservation à la fin de la réservations par sécurité
        unset($_SESSION['reservation']);
        $feedback .= '<script>window.location.assign("/reservation");</script>';
        break;


    case 'update':

        $bool1 = 0;
        $bool2 = 0;

        // On récupère les infos
        $date = $model->getInput('date');

        // On récupére les équipement en service
        $equipement = $model->getEquipementAllOn();

        // Date du jour format US
        $now = date('Y-m-d');

        // Converti la date au format US
        $dateRes = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);

        /* if($dateRes >= $now)
         {*/

        foreach ($equipement as $eq) {
            $name = $eq['Nom_Equipement'];
            $eq = $model->getInput('eq_'."$name");

            if($eq !== "")
            {
                // On récupère les infos
                $id_client = $model->getInput('id_personne');
                $id_employe = $model->getInput('id_employe'."$name");
                $id_employe_old = $model->getInput('old_id_emp_'."$name");
                $id_eq = $model->getInput('equipement_'."$name");
                $id_resa = $model->getInput('id_resa');

                $debut = $model->getInput('debut_'."$name");
                $fin = $model->getInput('fin_'."$name");

                $debut_init = $model->getInput('debut_init_'."$name");
                $fin_init = $model->getInput('fin_init_'."$name");

                $nb_pers = $model->getInput('nb_pers_'."$name");
                $prix = $model->getInput('total_'."$name");

                // On récupére les équipments et les employés disponibles
                $dispo = $model->getEquipementDispoUpdate($dateRes.' '.$debut.':00', $dateRes.' '.$fin.':00', $name, $id_resa);
                $employe_dispo = $model->getEqmployeDispoUpdate($dateRes, $dateRes.' '.$debut.':00', $dateRes.' '.$fin.':00',$id_resa);

                // Convertir l'heure de début et de fin choisie en minutes
                $debut_min = (substr($debut, 0, 2)*60) + substr($debut, 3, 2);
                $fin_min = (substr($fin, 0, 2)*60) + substr($fin, 3, 2);
                $res = $fin_min - $debut_min ;

                // Convertir l'heure de début et de fin initale en minutes
                $debut_init_min = (substr($debut_init, 0, 2)*60) + substr($debut_init, 3, 2);
                $fin_init_min = (substr($fin_init, 0, 2)*60) + substr($fin_init, 3, 2);
                $res_init = $fin_init_min - $debut_init_min ;

                if($res_init !== $res)
                {
                    $feedback .= '<script type="text/javascript">alert("La plage horaire doit rester indentique pour '.$name.'");</script>';
                }
                else
                {
                    if($id_employe !== "" && $id_employe_old !== "")
                    {
                        // Pour chaque équipement appartenant au groupe sélectionner que retourne la requête
                        foreach ($dispo as $eq) {
                            // Si l'équipement est dispo on lui attribut la valeur 1
                            if ($eq !== "") {
                                $bool1 = 1;
                            }
                        }

                        // Pour chaque employé appartenant
                        foreach ($employe_dispo as $emp) {
                            // Si l'employé est dispo on lui attribut la valeur 1
                            if ($emp['ID_Personne'] == $id_employe) {
                                $bool2 = 1;
                            }
                        }
                    }
                    else if($id_employe !== "" && $id_employe_old == "")
                    {
                        // Pour chaque équipement appartenant au groupe sélectionner que retourne la requête
                        foreach ($dispo as $eq) {
                            // Si l'équipement est dispo on lui attribut la valeur 1
                            if ($eq !== "") {
                                $bool1 = 1;
                            }
                        }

                        // Pour chaque employé appartenant
                        foreach ($employe_dispo as $emp) {
                            // Si l'employé est dispo on lui attribut la valeur 1
                            if ($emp['ID_Personne'] == $id_employe) {
                                $bool2 = 1;
                            }
                        }
                        $id_employe_old = NULL;
                    }
                    else if($id_employe_old !== "" && $id_employe == "")
                    {
                        $id_employe = NULL;
                        $bool1 = 1;
                        $bool2 = 1;
                    }
                    else
                    {
                        $id_employe = NULL;
                        $id_employe_old = NULL;
                        $bool1 = 1;
                        $bool2 = 1;
                    }
                    if($bool1 == 0)
                    {
                        $feedback .= '<script type="text/javascript">alert("Equipements indisponible sur cette plage horaire! Pour '.$name.'");</script>';
                    }
                    else if($bool2 == 0)
                    {
                        $feedback .= '<script type="text/javascript">alert("Employé indisponible sur cette plage horaire! Pour '.$name.'");</script>';
                    }
                    else
                    {
                        $update = $model->updateReservation($id_eq, $id_resa, $dateRes.' '.$debut.':00', $dateRes.' '.$fin.':00', $prix, $nb_pers, $id_employe, $id_employe_old);
                        $feedback .= '<script type="text/javascript">alert("Réservation '.$name.' modifiée");window.location.assign("/inforeservation?id='.$id_resa.'");</script>';
                    }
                }
            }
            $bool1 = 0;
            $bool2 = 0;
        }
        /*  }
          else
          {
              // Si date de réservation souhaitée antérieure ou égale à la date du jour,
              // on ne peut pas faire de réservation.
              $feedback .= '<script type="text/javascript">alert("La date ne doit pas être inférieur à la date du jour ! merci de réessayer.");document.getElementById("date").focus();</script>';
          }
        */
        break;


    case 'delete':

        $id_resa = $model->getInput('id_resa');

        $deleteEqResa = $model->deleteEqResa($id_resa);

        $deleteEmpClientResa = $model->deleteEmpClientResa($id_resa);

        $deletResa = $model->deleteResa($id_resa);

        $feedback .= '<script type="text/javascript">alert("Réservation supprimé");window.location.assign("/reservation");</script>';

        break;

    default:
        $feedback .= '<script type="text/javascript">alert("Erreur");window.location.assign("/");</script>';
        break;
}
