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
        $query  = "CALL update_employe_personne(:idemploye, :nomE, :prenomE, :annivE, :telE, :permisE, :secu, :bees, :contrat, :embauche, :medical)";
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
        $stmt   = $this->executeSQL($query, $bind);
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

}
