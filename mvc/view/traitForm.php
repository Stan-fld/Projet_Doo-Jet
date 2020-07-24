<?php

$model = new Model;

$feedback = "";

$controller = $model->getInput("controller");
$controller = basename($controller);
$cheminFichierController = "mvc/controller/ctrl-$controller.php";

//DEBUG
//echo $cheminFichierController;
//exit;

if (file_exists($cheminFichierController))
{

//DEBUG
//echo "INCLUDE OK !";

    include($cheminFichierController);
}
echo $feedback;