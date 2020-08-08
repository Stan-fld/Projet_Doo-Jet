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

        // Récupere les infos
        $id_client = $model->getInput('id_client');
        $equipement = $model->getInput('equipement');

        // On met en session les informations
        $_SESSION['reservation']['$id_client']     = $id_client;
        $_SESSION['reservation']['nom_equipement'] = $equipement;

        // On passe à l'étape suivante
        $feedback .= '<script type="text/javascript">window.location.assign("createreservation2");</script>';

        break;

    //||||||||||||||||||||\\
    //| CHOIX DE LA DATE |\\
    //||||||||||||||||||||\\

    case 'et2':

        $valid = "";

        // Recupére les infos
        $dateFr = $model->getInput('date_res');
        $timeDeb = $model->getInput('time_deb');
        $timeFin = $model->getInput('time_fin');

        //Recupére l'infos en session
        $equipement = $_SESSION['reservation']['nom_equipement'];

        // Rajoute un 0 devant le jour s'il à était enlevé
        if (strlen($dateFr) < 10) {
            $dateFr = '0' . $dateFr;
        }

        // Converti la date au format US
        $dateRes = substr($dateFr, 6, 4) . '-' . substr($dateFr, 3, 2) . '-' . substr($dateFr, 0, 2);

        //Convertir l'heure de début et de fin choisie en minutes
        $debut_min = (substr($timeDeb, 0, 2)*60) + substr($timeDeb, 3, 2);
        $fin_min = (substr($timeFin, 0, 2)*60) + substr($timeFin, 3, 2);
        $res = $fin_min - $debut_min ;

        // Date du jour format US
        $now = date('Ymd');

        // Formatage de la date pour n'obtenir que des chiffres.
        $dateChoisie = substr($dateRes, 0, 4) . substr($dateRes, 5, 2) . substr($dateRes, 8, 2);

        if($equipement == "JETSKI" && ($res == 30 || $res == 60 || $res == 120)){

            $valid = "time_resa";
            // Si le temps de la réservation est de 30 mins ou 1h ou 2h,
            // on peut faire de réservation.

        }else if($equipement == "BATEAU" && ($res == 60 || $res== 120)){

            $valid = "time_resa";
            // Si le temps de la réservation est de 1h ou 2h,
            // on peut faire de réservation.

        }else if(($equipement == ("BOUEE" || "WAKE-BOARD" || "SKI-NAUTIQUE")) && $res == 30){

            $valid = "time_resa";
            // Si le temps de la réservation est de 30 mins
            // on peut faire de réservation.

        }else{

            // on ne peut pas faire de réservation.
            $feedback .= '<script type="text/javascript">alert("La durée est invalide pour cette activité! merci de réessayer.");document.getElementById("time_deb").focus();</script>';

        }

        if ($dateChoisie <= $now) {

            // Si date de réservation souhaitée antérieure ou égale à la date du jour,
            // on ne peut pas faire de réservation.
            $feedback .= '<script type="text/javascript">alert("La date doit etre supérieure à la date du jour ! merci de réessayer.");document.getElementById("date_res").focus();</script>';

        } else if ($valid == "time_resa"){

            // On met en session les informations
            $_SESSION['reservation']['date_res']    = $dateRes;
            $_SESSION['reservation']['date_res_fr'] = $dateFr;
            $_SESSION['reservation']['time_deb'] = $timeDeb.':00';
            $_SESSION['reservation']['time_fin'] = $timeFin.':00';
            $_SESSION['reservation']['duree'] = $res;
            // On passe à l'étape suivante
            $feedback .= '<script>window.location.assign("createreservation3");</script>';

        }
        break;


    //||||||||||||||||||||||\\
    //| CHOIX DES ARTICLES |\\
    //||||||||||||||||||||||\\
    /*
        case 'et2':

            // Si une date a été sélectionnée précédemment, on continue, sinon, on retourne à l'étape 1.
            if (isset($_SESSION['reservation']['date_res'])) {

                $produits = $model->getProduitsLouables();

                $qteTotale = 0;
                $prixTotal = 0;

                $_SESSION['reservation']['produits'] = [];

                foreach ($produits as $produit) {

                    // Pour chaque produit, on récupère toutes ses tailles.
                    $tailles = $model->getTaillesProduit($produit['slug']);

                    foreach ($tailles as $key => $taille) {
                        // Pour chaque taille, on vérifie si le select comporte une valeur supérieure à 0, si oui on continue, sinon on affiche un message d'erreur.
                        if (isset($_POST['qte-prod-' . $key]) && $_POST['qte-prod-' . $key] > 0) {
                            $prixProd   = $produit['promo'] > 0 ? $produit['promo'] : $produit['prix'];
                            $qteTotale += $_POST['qte-prod-' . $key];
                            $prixTotal += ($_POST['qte-prod-' . $key] * $prixProd);
                            $titre = $langue == 'fr' ? $produit['titre'] : $produit['titre-en'];

                            $_SESSION['reservation']['produits'][] = [
                                'id'          => $key,
                                'prix'        => $prixProd,
                                'taille'      => $taille,
                                'nom'         => $titre,
                                'quantite'    => $_POST['qte-prod-' . $key],
                            ];
                        }
                    }

                    $_SESSION['reservation']['total'] = $prixTotal;
                }

                // Si au moins un produit a été sélectionné, on continue, sinon une pop-up s'affiche informant d'une erreur.
                if ($qteTotale > 0) {
                    $feedback .= '<script type="text/javascript">window.location.assign("reservation2");</script>';
                } else {
                    $feedback .= '<p class="text-danger mt-5 mb-0">Il faut sélectionner au moins un produit ! Merci de réessayer.</p>';
                }
            } else {
                $feedback .= '<script type="text/javascript">alert("Votre session a expiré, merci de recommencer votre sélection");window.location.assign("/location-de-velos-en-ligne");</script>';
            }
            break;


        //||||||||||||||||||||||||||||||||\\
        //| RESEIGNEMENT DES COORDONNÉES |\\
        //||||||||||||||||||||||||||||||||\\

        case 'et3':

            if (isset($_SESSION['reservation']['date_res'])) {

                // Récupération des informations saisies dans le formulaire
                $nom         = $model->getInput('nom');
                $prenom      = $model->getInput('prenom');
                $societe     = $model->getInput('societe');
                $telephone   = $model->getInput('telephone');
                $email       = $model->getEmail('email');
                $adresse_1   = $model->getInput('adresse_1');
                $adresse_2   = $model->getInput('adresse_2');
                $code_postal = $model->getInput('code_postal');
                $ville       = $model->getInput('ville');
                $pays        = $model->getInput('pays');
                $cgv         = $model->getInput('cgv');
                $newsletter  = $model->getInput('newsletter');
                $cgv         = !empty($cgv)  ? 1 : 0;
                $newsletter  = !empty($newsletter) ? 1 : 0;

                // Mise en session des informations
                $_SESSION['reservation']['client']['nom']         = htmlentities($nom);
                $_SESSION['reservation']['client']['prenom']      = htmlentities($prenom);
                $_SESSION['reservation']['client']['societe']     = htmlentities($societe);
                $_SESSION['reservation']['client']['telephone']   = htmlentities($telephone);
                $_SESSION['reservation']['client']['email']       = htmlentities($email);
                $_SESSION['reservation']['client']['adresse_1']   = htmlentities($adresse_1);
                $_SESSION['reservation']['client']['adresse_2']   = htmlentities($adresse_2);
                $_SESSION['reservation']['client']['code_postal'] = htmlentities($code_postal);
                $_SESSION['reservation']['client']['ville']       = htmlentities($ville);
                $_SESSION['reservation']['client']['pays']        = htmlentities($pays);
                $_SESSION['reservation']['client']['cgv']         = $cgv;
                $_SESSION['reservation']['client']['newsletter']  = $newsletter;


                // Création de la commande en base de données
                $now      = date('Y-m-d H:i:s');
                $date_res = $_SESSION['reservation']['date_res'];

                if (isset($_SESSION['reservation']['commande_id'])) {
                    $commande_id   = $_SESSION['reservation']['commande_id'];

                    $requeteUPDATE = "UPDATE `commandes`
                                      SET    `valid_date` = :date_res
                                      WHERE  `id`         = :commande_id";

                    $bindUPDATE    = [
                        ":date_res"    => $date_res,
                        ":commande_id" => $commande_id,
                    ];

                    $model->executeSQL($requeteUPDATE, $bindUPDATE);

                    // On efface les ligne de commande et de facturation pour les recréer ensuite (wtf ? o_o).
                    $requeteDELETE = "DELETE FROM `commandes_lignes`
                                      WHERE       `commandes_id` = :commande_id";

                    $bindDELETE    = [':commande_id' => $_SESSION['reservation']['commande_id']];

                    $model->executeSQL($requeteDELETE, $bindDELETE);

                    // Facturation des commandes
                    $reqInsFact = "UPDATE `commandes_factures`
                                   SET    `societe`      = :societe,
                                          `nom`          = :nom,
                                          `prenom`       = :prenom,
                                          `tel1`         = :tel,
                                          `ad1`          = :adr1,
                                          `ad2`          = :adr2,
                                          `ville`        = :ville,
                                          `pays`         = :pays,
                                          `cp`           = :cp,
                                          `email`        = :email,
                                          `inscription`  = :newsletter
                                   WHERE  `commandes_id` = :commande_id";

                    $bindInsFact = [
                        ":societe"     => $societe,
                        ":nom"         => $nom,
                        ":prenom"      => $prenom,
                        ":tel"         => $telephone,
                        ":adr1"        => $adresse_1,
                        ":adr2"        => $adresse_2,
                        ":ville"       => $ville,
                        ":pays"        => $pays,
                        ":cp"          => $code_postal,
                        ":email"       => $email,
                        ":newsletter"  => $newsletter,
                        ":commande_id" => $_SESSION['reservation']['commande_id'],
                    ];

                    $model->executeSQL($reqInsFact, $bindInsFact);
                } else {

                    // Création de la commande dans la base de données.
                    $requeteINSERT = "INSERT INTO `commandes` (`id`, `cre_date`, `statut`, `valid_date`, `type`)
                                      VALUES (NULL, :cre_date, '0', :valid_date, 'CB')";

                    $bindINSERT    = [
                        ':cre_date'   => $now,
                        ':valid_date' => $date_res,
                    ];

                    $model->executeSQL($requeteINSERT, $bindINSERT);

                    // On récupère l'ID de la commande créée.
                    $reqID    = "SELECT `id` FROM `commandes` WHERE `cre_date` = :cre_date";
                    $bindID   = [':cre_date' => $now];
                    $statmtID = $model->executeSQL($reqID, $bindID);
                    $resID    = $statmtID->fetchAll(PDO::FETCH_COLUMN);

                    $commande_id = $_SESSION['reservation']['commande_id'] = $resID[0];

                    // Création des factures des commandes
                    $reqInsFact = "INSERT INTO `commandes_factures` (`commandes_id`, `societe`, `nom`, `prenom`, `tel1`, `ad1`, `ad2`, `ville`, `pays`, `cp`, `email`, `inscription`)
                                   VALUES      (:commandes_id, :societe, :nom, :prenom, :tel, :adr1, :adr2, :ville, :pays, :cp, :email, :newsletter)";

                    $bindInsFact = [
                        ":commandes_id" => $commande_id,
                        ":societe"     => $societe,
                        ":nom"         => $nom,
                        ":prenom"      => $prenom,
                        ":tel"         => $telephone,
                        ":adr1"        => $adresse_1,
                        ":adr2"        => $adresse_2,
                        ":ville"       => $ville,
                        ":pays"        => $pays,
                        ":cp"          => $code_postal,
                        ":email"       => $email,
                        ":newsletter"  => $newsletter,
                    ];

                    $model->executeSQL($reqInsFact, $bindInsFact);
                }

                // DANS TOUS LES CAS on (re)crée les lignes des commandes

                // Lignes des commandes
                $i = 0;
                foreach ($_SESSION['reservation']['produits'] as $produit) {
                    $idProduit = $produit['id'];
                    $qteProd   = $produit['quantite'];
                    $prixProd  = $produit['prix'];
                    $nomProd   = $produit['nom'];

                    $reqInsLignes = "INSERT INTO `commandes_lignes` (`commandes_id`, `ligne`, `produits_id`, `prix`, `quantite`, `nom`)
                                     VALUES      (:commandes_id, :ligne, :idProduit, :prixProd, :qteProd, :nomProd)";

                    $bindInsLignes = [
                        ":commandes_id" => $commande_id,
                        ":ligne"        => $i,
                        ":idProduit"    => $idProduit,
                        ":prixProd"     => $prixProd,
                        ":qteProd"      => $qteProd,
                        ":nomProd"      => $nomProd,
                    ];

                    $model->executeSQL($reqInsLignes, $bindInsLignes);

                    $i++;
                }



                $feedback .= '<script type="text/javascript">window.location.assign("reservation3");</script>';
            } else { //la session a expiré on renvoi à l'etape 1
                $feedback .= '<script type="text/javascript">alert("Votre session a expiré, merci de renouveler votre réservation");window.location.assign("/location-de-velos-porquerolles");</script>';
            }

            break;
    */
    default:
        $feedback .= '<script type="text/javascript">window.location.assign("/");</script>';
        break;
}
