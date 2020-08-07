<?php

$feedback = "";
$model    = new Model;

$etape  = $model->getInput('etape');

switch ($etape) {

    //|||||||||||||||||||||\\
    //| CHOIX DE LA MODIF |\\
    //|||||||||||||||||||||\\

    case 'update_equipement':

        // Récupere les ID du formulaire pour modifier un équipement
        $id_equipement     = $model->getInput('id_equipement');

        // Récupere les infos du formulaire pour les équipements
        $nom       = $model->getInput('nom');
        $commentaire     = $model->getInput('commentaire');
        $puissance    = $model->getInput('puissance');
        $service     = $model->getInput('service');

        $update_equipement = $model->updateEquipement($id_equipement, $nom, $commentaire, $puissance, $service);
        $feedback .= '<script type="text/javascript">alert("Equipement modifié");window.location.reload();</script>';

        break;


    case 'delete_equipement':

        // Récupere les ID du formulaire pour supprimer un équipement
        $id_equipement = $model->getInput('id_equipement');

        $delete_equipement = $model->deleteEquipement($id_equipement);
        $feedback .= '<script type="text/javascript">alert("Equipement supprimé");window.location.assign("/equipement");</script>';

        break;


    case 'create_equipement':

        // Récupere les infos du formulaire pour ajouter un équipement
        $nom       = $model->getInput('nom');
        $commentaire     = $model->getInput('commentaire');
        $puissance    = $model->getInput('puissance');
        $service     = $model->getInput('service');

        $add_equipement = $model->addEquipement($nom, $commentaire, $puissance, $service);
        $feedback .= '<script type="text/javascript">alert("Equipement ajouté");window.location.assign("/equipement");</script>';
        break;


    default:
        $feedback .= '<script type="text/javascript">alert("Erreur");window.location.assign("/");</script>';
        break;
}