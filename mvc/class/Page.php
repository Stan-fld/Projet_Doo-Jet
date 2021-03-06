<?php

// classe:          Page

class Page
{
    // DEBUT DU CODE DE LA CLASSE Page
    public $home = "";

    protected $model;
    protected $view;
    protected $controller;

    function __construct()
    {
        $this->model = $this->view = $this->controller = null;
    }

    /**
     * Récupère le modèle
     */
    function getModel()
    {
        if (!$this->model) $this->model = new Model;
        return $this->model;
    }

    /**
     * Récupère la vue
     */
    function getView()
    {
        if (!$this->view) $this->view = new View;
        return $this->view;
    }

    /**
     * Récupère le contrôleur
     */
    function getController()
    {
        if (!$this->controller) $this->controller = new Controller;
        return $this->controller;
    }

    //- pour recuperer l'adresse de la page courante
    function getUrl()
    {
        $result = "";

        $uri = $_SERVER["REQUEST_URI"];
        $path = parse_url($uri, PHP_URL_PATH);

        $nomFichier = pathinfo($path, PATHINFO_FILENAME);
        $extension  = pathinfo($path, PATHINFO_EXTENSION);

        $result = [$nomFichier, $extension];

        return $result;
    }


    //- pour afficher la page demandée en fonction de l'URL
    function afficherPage()
    {
        $model         = $this->getModel();
        $nomPage = $this->getUrl();
        if ($nomPage[0] == $this->home) {
            $nomPage[0] = "index";
        }

        $cheminSolo = 'mvc/view/' . $nomPage[0] . '.php';
        $cheminPage = 'mvc/view/view-' . $nomPage[0] . '.php';

        if (is_file($cheminSolo)) {
            if($nomPage['0'] == "connexion" || $nomPage['0'] == "inscription" )
            {
                include ('mvc/view/head.php');
                //include('mvc/view/deconnexion.php.old');
                include($cheminSolo);
                include("mvc/view/footer.php");
            }
            else
            {
                include($cheminSolo);
            }
        }else if (is_file($cheminPage)) {

            // Si l'id présent d'en l'url n'existe pas on r'envoie à la page souhaité
            if($nomPage[0] == "infoemploye" && $model->getEmploye($_GET["id"]) == null)
            {
                header("location: /employe");
                exit;
            }

            // Si l'id présent d'en l'url n'existe pas on r'envoie à la page souhaité
            if($nomPage[0] == "infoclient" && $model->getClient($_GET["id"]) == null)
            {
                header("location: /client");
                exit;
            }

            // Si l'id présent d'en l'url n'existe pas on r'envoie à la page souhaité
            if($nomPage[0] == "infoequipement" && $model->getEquipement($_GET["id"]) == null)
            {
                header("location: /equipement");
                exit;
            }

            // Si l'id présent d'en l'url n'existe pas on r'envoie à la page souhaité
            if($nomPage[0] == "createreservation1" && $model->getClient($_GET["id"]) == null)
            {
                header("location: /createreservation");
                exit;
            }

            include ('mvc/view/head.php');
            include("mvc/view/header.php");
            include('mvc/view/deconnexion.php.old');
            include($cheminPage);
            include("mvc/view/footer.php");

        }
        else{
            header("HTTP/1.1 404 Not Found");
            //include("mvc/view/header.php");
            include ("mvc/view/404.php");
            //include("mvc/view/footer.php");
        }
    }

    // FIN DU CODE DE LA CLASSE Page
}
