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
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
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
    function getEmail($name)
    {
        $email = $this->getInput($name);
        // FILTRE L'EMAIL
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);

        return $email;
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
    function getPays()
    {
        $query  = "SELECT Nom_Pays FROM pays";
        $stmt   = $this->executeSQL($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    function updateInactivite($idpers, $motif, $debut, $fin)
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
        $query  = "CALL create_personne(:nomC, :prenomC, :annivC, :telC, :permisC, :villeC, :code_postC, :paysC, :num_rueC, :rueC, :voieC, NULL, NULL, NULL, NULL, NULL, NULL)";
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

}
