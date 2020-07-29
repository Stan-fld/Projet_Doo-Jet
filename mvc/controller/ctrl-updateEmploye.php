<?php

$model    = new Model;

$etape  = $model->getInput('etape');

switch ($etape) {

    //|||||||||||||||||||||\\
    //| CHOIX DE LA MODIF |\\
    //|||||||||||||||||||||\\

    case 'update_employe':

        $id_employe = $model->getInput('id_employe');
        $id_adresse       = $model->getInput('id_adresse');

        // Récupere les infos du formulaire pour les personnes
        $nom = $model->getInput('nom');
        $prenom = $model->getInput('prenom');
        $anniv = $model->getInput('date_naissance');
        $telephone = $model->getInput('telephone');
        $permis = $model->getInput('num_permis');
        $secu = $model->getInput('num_secu');
        $bees = $model->getInput('num_bees');
        $contrat = $model->getInput('contrat');
        $embauche = $model->getInput('date_embauche');
        $visit_med = $model->getInput('date_visite_med');

        // Récupere les infos du formulaire pour la ville
        $ville            = $model->getInput('ville');
        $code_post        = $model->getInput('code_postal');
        $pays             = $model->getInput('nom_pays');

        // Récupere les infos du formulaire pour l'adresse
        $num_rue     = $model->getInput('num_voie');
        $rue         = $model->getInput('nom_voie');
        $voie         = $model->getInput('type_voie');

        // Récupere les infos du formulaire pour l'inactivité
        $motif       = $model->getInput('motifs');
        $date_debut  = $model->getInput('date_debut_ina');
        $date_fin    = $model->getInput('date_fin_ina');

        // Conversion des dates au format US
        $newanniv = substr($anniv, 6, 4) . '-' . substr($anniv, 3, 2) . '-' . substr($anniv, 0, 2);
        $newembauche = substr($embauche, 6, 4) . '-' . substr($embauche, 3, 2) . '-' . substr($embauche, 0, 2);
        $newmedical = substr($visit_med, 6, 4) . '-' . substr($visit_med, 3, 2) . '-' . substr($visit_med, 0, 2);
        $newdebut = substr($date_debut, 6, 4) . '-' . substr($date_debut, 3, 2) . '-' . substr($date_debut, 0, 2);
        $newfin = substr($date_fin, 6, 4) . '-' . substr($date_fin, 3, 2) . '-' . substr($date_fin, 0, 2);

        // Date du jour format US
        $now = date('Y');
        $datenow = ($now - 15).date('-m-d');

        //On convertit les dates en nombre pour les comparer
        $date_debutcompare = substr($newdebut, 0, 4) . substr($newdebut, 5, 2) . substr($newdebut, 8, 2);
        $date_fincompare = substr($newfin, 0, 4) . substr($newfin, 5, 2) . substr($newfin, 8, 2);

        // Si la date est null on dit que la conversion est null
        if($date_fin == null)
        {
            $newfin = NULL;
        }

        //Si l'année de naissance est supérieur ou égal à l'année actuel on retourne une erreur
        if(substr($newanniv, 0, 4) >=  substr($datenow, 0, 4))
        {
            $feedback .= '<script type="text/javascript">alert("Trop jeune")';
        }
        else if($date_fincompare <= $date_debutcompare && $newfin!==null)
        {
            $feedback .= '<script type="text/javascript">alert("La date de fin d\'inactivité ne peut pas être inférieure ou égale à celle de début")';
        }
        else
        {
            $update_employe = $model->updateEmploye($id_employe, $nom, $prenom, $newanniv, $telephone, $permis, $secu, $bees, $contrat, $newembauche, $newmedical);
            $update_ville = $model->updateVille($id_adresse, $ville, $code_post, $pays);
            $udpate_adresse = $model->updateAdresse($id_adresse, $num_rue, $rue, $voie);
            $update_inactivite = $model->updateInactivite($id_employe, $motif, $newdebut, $newfin);

            $feedback .= '<script type="text/javascript">alert("Modifications effectuées");window.location.assign("infoemploye?id=' . $id_employe . '");</script>';
        }
        break;

    default:
        $feedback .= '<script type="text/javascript">window.location.assign("/");</script>';
        break;
}


//$employe = $model->updateEmploye($id_employe, $nom, $prenom, $newanniv, $telephone, $permis, $secu, $bees, $contrat, $newembauche, $newmedical);
// Récupération des informations saisies dans le formulaire

// Mise en session des informations
/*$_SESSION['update']['employe']['id_employe']                  = $id_employe;
$_SESSION['update']['employe']['nom']                  =  $nom;
$_SESSION['update']['employe']['Prenom']               =  $prenom;
$_SESSION['update']['employe']['date_naissance']                =  $anniv;
$_SESSION['update']['employe']['telephone']            = $telephone;
$_SESSION['update']['employe']['num_permis']             = $permis;
$_SESSION['update']['employe']['num_secu']   = $secu;
$_SESSION['update']['employe']['num_bees']               = $bees;
$_SESSION['update']['employe']['contrat']              = $contrat;
$_SESSION['update']['employe']['date_embauche']            = $embauche;
$_SESSION['update']['employe']['date_visite_med']            = $visit_med;
$_SESSION['update']['employe']['Numero_Rue']           = htmlentities($num_rue);
$_SESSION['update']['employe']['Rue']                  = htmlentities($rue);
$_SESSION['update']['employe']['Nom_Ville']            = htmlentities($ville);
$_SESSION['update']['employe']['Code_Postal']          = htmlentities($code_post);
$_SESSION['update']['employe']['Nom_Pays']             = htmlentities($pays);
$_SESSION['update']['employe']['Motif']                = htmlentities($motif);
$_SESSION['update']['employe']['max_date_debut']       = htmlentities($date_debut);
$_SESSION['update']['employe']['max_date_fin']         = htmlentities($date_fin);*/
/*


        $dateFr = $model->getInput('date_res');
        if (strlen($dateFr) < 10) {
            $dateFr = '0' . $dateFr;
        }

        $dateRes = substr($dateFr, 6, 4) . '-' . substr($dateFr, 3, 2) . '-' . substr($dateFr, 0, 2);

        // Date du jour format US
        $now = date('Ymd');

        // Formatage de la date pour n'obtenir que des chiffres.
        $dateChoisie = substr($dateRes, 0, 4) . substr($dateRes, 5, 2) . substr($dateRes, 8, 2);

        if ($dateChoisie <= $now || substr($dateChoisie, -4) == '1225' || substr($dateChoisie, -4) == '0101') {

            // Si date de réservation souhaitée antérieure ou égale à la date du jour ou correspondant aux jours de fermetures de l'établissement,
            // on ne peut pas faire de réservation.
            $feedback .= '<script type="text/javascript">alert("La date doit etre supérieure à la date du jour et différente de nos jours de fermeture ! merci de réessayer."); console.log("' . $dateRes . ' / now:' . $now . '");document.getElementById("date_res").classList.add("borderRed");document.getElementById("date_res").focus();</script>';
        } else {
            $_SESSION['reservation']['date_res']    = $dateRes;
            $_SESSION['reservation']['date_res_fr'] = $dateFr;
            $feedback .= '<script>window.location.assign("reservation1");</script>';
        }
        break;


        //||||||||||||||||||||||\\
        //| CHOIX DES ARTICLES |\\
        //||||||||||||||||||||||\\

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
}
*/