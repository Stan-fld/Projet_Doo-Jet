<?php

class Model{

    function __construct()
    {
        $this->pdo = null;
    }

    function getConnexion()
    {
        if ($this->pdo == null) {
            // AU DEPART ON N'A PAS DE CONNEXION
            // ALORS ON LA CREE UNE SEULE FOIS

            // PARAMETRES DE CONNEXION A LA BASE DE DONNEES
            $nomDatabase  = "doo-jet";
            $userDatabase = "root";
            $mdpDatabase  = "P@ssword13";
            $hostDatabase = "localhost";

            // Data Source Name
            $dsn = "mysql:dbname=$nomDatabase;host=$hostDatabase;charset=utf8;";

            // LA CLASSE PDO GERE LA CONNEXION ENTRE PHP ET MYSQL
            // ON CREE UN OBJET DE LA CLASSE PDO
            $this->pdo = new PDO($dsn, $userDatabase, $mdpDatabase);

            // AFFICHER LES MESSAGES D'ERREUR DE MYSQL
            //$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }

        // RENVOIE LA CONNEXION EN COURS
        return $this->pdo;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getInput($name)
    {
        $resultat = "";
        // VERIFIER SI L'INFO EST FOURNIE
        if (isset($_REQUEST["$name"])) {
            // trim ENLEVES LES ESPACES AU DEBUT ET A LA FIN
            $resultat = trim($_REQUEST["$name"]);
        } elseif (isset($_COOKIE["$name"])) {
            // trim ENLEVES LES ESPACES AU DEBUT ET A LA FIN
            $resultat = trim($_COOKIE["$name"]);
        }
        return $resultat;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function executeSQL($requeteSQL, $tableauBind = [])
    {
        // CONNEXION A LA BASE DE DONNEES
        $pdo = $this->getConnexion();

        // PREPARATION DE LA FUTURE REQUETE SQL
        // SECURITE CONTRE LES INJECTIONS SQL
        $statement = $pdo->prepare($requeteSQL);

        // $statement->bindValue(":nom", $nom);
        foreach ($tableauBind as $cle => $valeur) {
            // REMPLACER CHAQUE JETON PAR SA VALEUR
            $statement->bindValue($cle, $valeur);
        }

        // EXECUTER LA REQUETE SQL
        $statement->execute();
        // RENVOIE L'OBJET $statement
        // QUI PERMETTRA DE PARCOURIR LES RESULTATS
        return $statement;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getClientAll()
    {
        $query  = "CALL select_client_all";
        $stmt   = $this->executeSQL($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getEquipementAll()
    {
        $query  = "CALL select_equipement_all";
        $stmt   = $this->executeSQL($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getClient($idclient)
    {
        $query  = "CALL select_client(:idclient)";
        $bind = [":idclient" => $idclient,];
        $stmt   = $this->executeSQL($query, $bind);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getEmployeAll()
    {
        $query  = "CALL select_employe_all";
        $stmt   = $this->executeSQL($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getEmploye($idemploye)
    {
        $query  = "CALL select_employe(:idemploye)";
        $bind   = [":idemploye" => $idemploye,];
        $stmt   = $this->executeSQL($query, $bind);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getEquipement($idequipement)
    {
        $query  = "CALL select_equipement(:idequipement)";
        $bind   = [":idequipement" => $idequipement,];
        $stmt   = $this->executeSQL($query, $bind);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getEquipementAllOn()
    {
        $query  = "SELECT Nom_Equipement FROM equipement WHERE Service = 1 GROUP BY Nom_Equipement";
        $stmt   = $this->executeSQL($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getEquipementDistinct()
    {
        $query  = "SELECT Nom_Equipement FROM equipement GROUP BY Nom_Equipement";
        $stmt   = $this->executeSQL($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getEquipementDispo($date_deb, $date_fin, $nom_eq, $duree)
    {
        $query  = "CALL select_equipement_dispo(:date_deb, :date_fin, :nom_eq, :duree)";
        $bind   = [":date_deb" => $date_deb,
            ":date_fin" => $date_fin,
            ":nom_eq" => $nom_eq,
            ":duree" => $duree];
        $stmt   = $this->executeSQL($query, $bind);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    //----------------------------------------------------------------------------------------------------------------------------------
    function getEquipementDispoUpdate($date_deb, $date_fin, $nom_eq, $id_res)
    {
        $query  = "CALL select_equipement_dispo_update(:date_deb, :date_fin, :nom_eq, :id_res)";
        $bind   = [":date_deb" => $date_deb,
            ":date_fin" => $date_fin,
            ":nom_eq" => $nom_eq,
            ":id_res"=>$id_res];
        $stmt   = $this->executeSQL($query, $bind);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getEqmployeDispo($date, $date_deb, $date_fin)
    {
        $query  = "CALL select_employe_dispo(:date, :date_deb, :date_fin)";
        $bind   = [":date" => $date,
            ":date_deb" => $date_deb,
            ":date_fin" => $date_fin];
        $stmt   = $this->executeSQL($query, $bind);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getEqmployeDispoUpdate($date, $date_deb, $date_fin, $id_res)
    {
        $query  = "CALL select_employe_dispo_update(:date, :date_deb, :date_fin, :id_res)";
        $bind   = [":date" => $date,
            ":date_deb" => $date_deb,
            ":date_fin" => $date_fin,
            ":id_res"=> $id_res];
        $stmt   = $this->executeSQL($query, $bind);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getPays()
    {
        $query  = "SELECT Nom_Pays FROM pays";
        $stmt   = $this->executeSQL($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getEmployemalade($id_personne)
    {
        $query  = "SELECT ID_Inactivite FROM employe_malade WHERE ID_Personne = :id_personne";
        $bind = [":id_personne" => $id_personne];
        $stmt   = $this->executeSQL($query, $bind);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getPeriodeinact($id_pers)
    {
        $query  = "SELECT * FROM periode_inactivite 
                   LEFT JOIN employe_malade ON periode_inactivite.ID_Inactivite = employe_malade.ID_Inactivite 
                   WHERE employe_malade.ID_Personne = :id_pers 
                   ORDER BY DATE_FORMAT(Date_Debut_Inactivite, '%Y-%m-%d') ASC";
        $bind = [":id_pers" => $id_pers];
        $stmt   = $this->executeSQL($query, $bind);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getReservationAll($statut)
    {
        $query  = "CALL select_reservation_alL(:statut)";
        $bind = [":statut" => $statut];
        $stmt   = $this->executeSQL($query, $bind);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getReservationEmp()
    {
        $query  = "SELECT ID_Equipement, ID_Reservation, DATE_FORMAT(equipement_reserve.Date_Heure_Debut_Reservation, '%d/%m/%Y %Hh%i') as debut, DATE_FORMAT(equipement_reserve.Date_Heure_Fin_Reservation, '%d/%m/%Y %Hh%i') as fin, Nom, Prenom, ID_Personne, Telephone FROM equipement_reserve 
LEFT JOIN personne ON equipement_reserve.id_employe = personne.ID_Personne
WHERE (id_employe IS NOT NULL)ORDER BY debut DESC, fin DESC;";
        $stmt   = $this->executeSQL($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getReservationEq()
    {
        $query  = "SELECT equipement.ID_Equipement, ID_Reservation, DATE_FORMAT(equipement_reserve.Date_Heure_Debut_Reservation, '%d/%m/%Y %Hh%i') as debut, DATE_FORMAT(equipement_reserve.Date_Heure_Fin_Reservation, '%d/%m/%Y %Hh%i') as fin, Nom_Equipement, Commentaire FROM equipement_reserve 
LEFT JOIN equipement ON equipement_reserve.ID_Equipement = equipement.ID_Equipement
ORDER BY debut DESC, fin DESC";
        $stmt   = $this->executeSQL($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getReservation($id_resa){
        $query  = "CALL select_reservation(:id_resa)";
        $bind = [":id_resa" => $id_resa];
        $stmt   = $this->executeSQL($query, $bind);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getResaEmploForDelete($id_personne){
        $query  = "SELECT ID_Reservation, DATE_FORMAT(equipement_reserve.Date_Heure_Debut_Reservation, '%d/%m/%Y') as date  FROM equipement_reserve
WHERE equipement_reserve.id_employe = :id";
        $bind = [":id" => $id_personne];
        $stmt   = $this->executeSQL($query, $bind);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getResaEquipementForDelete($id_eq){
        $query  = "SELECT ID_Reservation, DATE_FORMAT(equipement_reserve.Date_Heure_Debut_Reservation, '%d/%m/%Y') as date  FROM equipement_reserve
WHERE equipement_reserve.ID_Equipement = :id";
        $bind = [":id" => $id_eq];
        $stmt   = $this->executeSQL($query, $bind);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getResaClientForDelete($id_personne){
        $query  = "SELECT equipement_reserve.ID_Reservation,DATE_FORMAT(equipement_reserve.Date_Heure_Debut_Reservation, '%d/%m/%Y') as date FROM reservation_client_employe
LEFT JOIN personne ON reservation_client_employe.ID_Personne = personne.ID_Personne
LEFT JOIN equipement_reserve ON reservation_client_employe.ID_Reservation = equipement_reserve.ID_Reservation
WHERE(personne.ID_Personne = :id)";
        $bind = [":id" => $id_personne];
        $stmt   = $this->executeSQL($query, $bind);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getReservationClient($id_resa){
        $query  = "CALL select_reservation_client(:id_resa)";
        $bind = [":id_resa" => $id_resa];
        $stmt   = $this->executeSQL($query, $bind);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getPrix($id_eq){
        $query  = "CALL select_prix(:id_eq)";
        $bind = [":id_eq" => $id_eq];
        $stmt   = $this->executeSQL($query, $bind);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getDuree(){
        $query  = "CALL select_duree()";
        $stmt   = $this->executeSQL($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getReservationDistinct($current_year)
    {
        $query  = "SELECT DISTINCT ID_Reservation FROM equipement_reserve WHERE DATE_FORMAT(Date_Heure_Fin_Reservation, '%Y') = :current_year";
        $bind = [":current_year" => $current_year];
        $stmt   = $this->executeSQL($query, $bind);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function getPassword($identifiant)
    {
        $query  = "CALL connexion(:identifiant);";
        $bind = [":identifiant" => $identifiant];
        $stmt   = $this->executeSQL($query, $bind);

        //Si la procédure retourne erreur 45000 alors l'utilisateur existe déjà
        if($stmt->errorCode() == '45000')
        {
            echo '<script type="text/javascript">alert("Mauvais nom d\'utilisateur ou mot de passe");</script>';
            exit;
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function updateEmploye($idemploye, $nomE, $prenomE, $annivE, $telE, $permisE, $secu, $bees, $contrat, $embauche, $medical)
    {
        $query  = "CALL update_tb_personne_employe(:idemploye, :nomE, :prenomE, :annivE, :telE, :permisE, :secu, :bees, :contrat, :embauche, :medical)";
        $bind = [":idemploye" => $idemploye,
            ":nomE" => $nomE,
            ":prenomE" => $prenomE,
            ":annivE" => $annivE,
            ":telE" => $telE,
            ":permisE" => $permisE,
            ":secu" => $secu,
            ":bees" => $bees,
            ":contrat" => $contrat,
            ":embauche" => $embauche,
            ":medical" => $medical,];
        $result   = $this->executeSQL($query, $bind);
        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function updateClient($idclient, $nomC, $prenomC, $annivC, $telC, $permisC)
    {
        $query  = "CALL  	update_tb_personne_client(:idclient, :nomC, :prenomC, :annivC, :telC, :permisC)";
        $bind = [":idclient" => $idclient,
            ":nomC" => $nomC,
            ":prenomC" => $prenomC,
            ":annivC" => $annivC,
            ":telC" => $telC,
            ":permisC" => $permisC];
        $result   = $this->executeSQL($query, $bind);
        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function updateVille($idad, $nom_ville, $code_postal, $pays)
    {
        $query  = "CALL update_ville(:idadresse, :ville, :code_postal, :pays)";
        $bind = [":idadresse" => $idad,
            ":ville" => $nom_ville,
            ":code_postal" => $code_postal,
            ":pays" => $pays];
        $result   = $this->executeSQL($query, $bind);
        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function updateAdresse($idad, $num, $rue, $voie)
    {
        $query  = "CALL update_adresse(:idadresse, :numero, :rue, :voie)";
        $bind = [":idadresse" => $idad,
            ":numero" => $num,
            ":rue" => $rue,
            ":voie" => $voie];
        $result   = $this->executeSQL($query, $bind);
        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function updateEquipement($id_equipement, $nom, $commentaire, $puissance, $service)
    {
        $query  = "CALL update_equipement(:id_equipement, :nom, :commentaire, :puissance, :service)";
        $bind = [":id_equipement" => $id_equipement,
            ":nom" => $nom,
            ":commentaire" => $commentaire,
            ":puissance" => $puissance,
            ":service" => $service];
        $result   = $this->executeSQL($query, $bind);
        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function updatePeriodeinact($idpers, $motif, $debut, $fin)
    {
        $query  = "
                    UPDATE periode_inactivite
                    SET periode_inactivite.Motif = :motif,
                        periode_inactivite.Date_Debut_Inactivite = :date_debut,
                        periode_inactivite.Date_Fin_Inactivite = :date_fin
                    WHERE 
                    (ID_Inactivite = (SELECT MAX(ID_Inactivite)as maxid FROM employe_malade WHERE employe_malade.ID_Personne = :idpersonne))
                    
                    ";
        $bind = [":idpersonne" => $idpers,
            ":motif" => $motif,
            ":date_debut" => $debut,
            ":date_fin" => $fin];
        $result   = $this->executeSQL($query, $bind);
        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function updatePassword($ipers, $password)
    {
        $query  = "UPDATE personne SET personne.Password = :password WHERE(ID_Personne = :ipers)";
        $bind = [":ipers" => $ipers,
                 ":password" => $password];
        $result   = $this->executeSQL($query, $bind);
        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function updateReservation($id_eq, $id_resa, $debut, $fin, $prix, $nb_pers, $id_pers, $id_emp_old)
    {
        $query  = "CALL update_reservation(:id_eq, :id_resa, :debut, :fin, :prix, :nb_pers, :id_pers, :id_emp_old)";
        $bind = [":id_eq" => $id_eq,
                 ":id_resa" => $id_resa,
                 ":debut" => $debut,
                 ":fin" => $fin,
                 ":prix" => $prix,
                 ":nb_pers" => $nb_pers,
                 ":id_pers" => $id_pers,
                 ":id_emp_old" => $id_emp_old];
        $result   = $this->executeSQL($query, $bind);
        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function updatePrix($prix, $id_eq, $id_prix)
    {
        $query  = "CALL update_prix(:prix, :id_eq, :id_prix);";
        $bind = [":prix" => $prix,
                 ":id_eq" => $id_eq,
                 ":id_prix" => $id_prix];
        $result   = $this->executeSQL($query, $bind);
        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function addPeriodeinact($idemploye, $motif, $debut, $fin)
    {
        $query  = "
                    INSERT INTO periode_inactivite (Motif, Date_Debut_Inactivite, Date_Fin_Inactivite)
      	            VALUES (:motif, :date_debut,  :date_fin);
                    INSERT INTO employe_malade (ID_Personne, ID_Inactivite) 
      	            VALUES (:idemploye, LAST_INSERT_ID())
      	            
                    ";
        $bind = [":idemploye" => $idemploye,
            ":motif" => $motif,
            ":date_debut" => $debut,
            ":date_fin" => $fin];
        $result   = $this->executeSQL($query, $bind);
        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function addClient($nomC, $prenomC, $annivC, $telC, $permisC, $villeC, $code_postC, $paysC, $num_rueC, $rueC, $voieC)
    {
        $query  = "CALL create_personne('Client', :nomC, :prenomC, :annivC, :telC, :permisC, :villeC, :code_postC, :paysC, :num_rueC, :rueC, :voieC, NULL, NULL, NULL, NULL, NULL, NULL)";
        $bind = [
            ":nomC" => $nomC,
            ":prenomC" => $prenomC,
            ":annivC" => $annivC,
            ":telC" => $telC,
            ":permisC" => $permisC,
            ":villeC" => $villeC,
            ":code_postC" => $code_postC,
            ":paysC" => $paysC,
            ":num_rueC" => $num_rueC,
            ":rueC" => $rueC,
            ":voieC" => $voieC,

        ];
        $result   = $this->executeSQL($query, $bind);

        //Si la procédure retourne erreur 45000 alors l'utilisateur existe déjà
        if($result->errorCode() == '45000')
        {
            echo '<script type="text/javascript">alert("Utilisateur déjà existant")</script>';
            exit;
        }

        return $result;
    }
    //----------------------------------------------------------------------------------------------------------------------------------
    function addEmploye($nomC, $prenomC, $annivC, $telC, $permisC, $villeC, $code_postC, $paysC, $num_rueC, $rueC, $voieC, $secu, $bees, $contrat, $embauche, $vmedicale,$password)
    {
        $query  = "CALL create_personne('Employé', :nomC, :prenomC, :annivC, :telC, :permisC, :villeC, :code_postC, :paysC, :num_rueC, :rueC, :voieC, :secu, :bees, :contrat, :embauche, :vmedicale, :password)";
        $bind = [
            ":nomC" => $nomC,
            ":prenomC" => $prenomC,
            ":annivC" => $annivC,
            ":telC" => $telC,
            ":permisC" => $permisC,
            ":villeC" => $villeC,
            ":code_postC" => $code_postC,
            ":paysC" => $paysC,
            ":num_rueC" => $num_rueC,
            ":rueC" => $rueC,
            ":voieC" => $voieC,
            ":secu" => $secu,
            ":bees" => $bees,
            ":contrat" => $contrat,
            ":embauche" => $embauche,
            ":vmedicale" => $vmedicale,
            ":password" => $password,
        ];
        $result   = $this->executeSQL($query, $bind);

        //Si la procédure retourne erreur 45000 alors l'utilisateur existe déjà
        if($result->errorCode() == '45000')
        {
            echo '<script type="text/javascript">alert("Utilisateur déjà existant")</script>';
            exit;
        }

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function addEquipement($nom, $commentaire, $puissance, $service)
    {
        $query  = "CALL create_equipement(:nom, :commentaire, :puissance, :service)";
        $bind = [":nom" => $nom,
            ":commentaire" => $commentaire,
            ":puissance" => $puissance,
            ":service" => $service];
        $stmt   = $this->executeSQL($query, $bind);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function addPrix($prix, $id_eq, $id_prix)
    {
        $query  = "CALL create_prix(:prix, :id_eq, :id_prix);";
        $bind = [":prix" => $prix,
            ":id_eq" => $id_eq,
            ":id_prix" => $id_prix];
        $result   = $this->executeSQL($query, $bind);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function addIdresa()
    {
        $query  = "CALL create_resa_id()";
        $stmt   = $this->executeSQL($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function addResaEC($idres, $idpersonne)
    {
        $query  = "INSERT INTO reservation_client_employe (ID_Reservation, ID_Personne) VALUES (:idres, :idpersonne)";
        $bind = [":idres" => $idres,
            ":idpersonne" => $idpersonne];
        $result   = $this->executeSQL($query, $bind);;

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function addResaEq($idres, $ideq, $debut, $fin, $total, $nb_pers, $id_emplo)
    {
        $query  = "INSERT INTO equipement_reserve 
                    (ID_Equipement, ID_Reservation, Date_Heure_Debut_Reservation, Date_Heure_Fin_Reservation, Prix_Total, Nombre_Personne, id_employe) 
                    VALUES (:ideq, :idres, :debut, :fin, :total, :nb_pers, :id_emplo)";
        $bind = [":idres" => $idres,
            ":ideq" => $ideq,
            ":debut" => $debut,
            ":fin" => $fin,
            ":total" => $total,
            ":nb_pers" => $nb_pers,
            ":id_emplo" => $id_emplo];
        $result   = $this->executeSQL($query, $bind);;

        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function deletePersonne($idpersonne, $statut, $id_adresse)
    {
        $query  = "CALL delete_personne (:idpersonne, :statut, :id_adresse)";
        $bind = [":idpersonne" => $idpersonne,
            ":statut" => $statut,
            ":id_adresse" => $id_adresse];
        $result   = $this->executeSQL($query, $bind);
        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function deleteEmployemalade($idemploye)
    {
        $query  = "
                    DELETE FROM employe_malade WHERE (ID_Personne = :id_personne);
                    ";
        $bind = [":id_personne" => $idemploye];
        $result   = $this->executeSQL($query, $bind);
        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function deletePeriodeInact($idinact)
    {
        $query  = "
                    DELETE FROM periode_inactivite WHERE (ID_Inactivite = :id_inact); 
                    ";
        $bind = [":id_inact" => $idinact];
        $result   = $this->executeSQL($query, $bind);
        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function deleteEquipement($id_equipement)
    {
        $query  = "CALL delete_equipement(:id_equipement)";
        $bind = [":id_equipement" => $id_equipement];
        $result   = $this->executeSQL($query, $bind);
        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function deletePrix($id_equipement)
    {
        $query  = "DELETE FROM prix_horaire_equipement WHERE prix_horaire_equipement.ID_Equipement = :id_equipement";
        $bind = [":id_equipement" => $id_equipement];
        $result   = $this->executeSQL($query, $bind);
        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function deletePersonneResa($id_resa, $id_personne)
    {
        $query  = "DELETE FROM reservation_client_employe WHERE (ID_Reservation = :id_resa and ID_Personne = :id_personne)";
        $bind = [":id_resa" => $id_resa,
                 ":id_personne" => $id_personne];
        $result   = $this->executeSQL($query, $bind);
        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function deleteEqResa($id_resa)
    {
        $query  = "DELETE FROM equipement_reserve WHERE (ID_Reservation = :id_resa)";
        $bind = [":id_resa" => $id_resa];
        $result   = $this->executeSQL($query, $bind);
        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function deleteEmpClientResa($id_resa)
    {
        $query  = "DELETE FROM reservation_client_employe WHERE (ID_Reservation = :id_resa)";
        $bind = [":id_resa" => $id_resa];
        $result   = $this->executeSQL($query, $bind);
        return $result;
    }

    //----------------------------------------------------------------------------------------------------------------------------------
    function deleteResa($id_resa)
    {
        $query  = "DELETE FROM reservation WHERE (ID_Reservation = :id_resa)";
        $bind = [":id_resa" => $id_resa];
        $result   = $this->executeSQL($query, $bind);
        return $result;
    }
}
