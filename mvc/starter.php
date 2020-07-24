<?php

// FONCTION A APPELER POUR CHARGER LA DEFINITION D'UNE CLASSE
function loadClass ($className)
{
    $cheminClass = "mvc/class/$className.php";

    // CHARGE LE CODE DE LA CLASSE
    include_once($cheminClass);
}



// DIT A PHP D'ACTIVER LA FONCTION loadClass
// QUAND IL A BESOIN DE CHARGER LA DEFINITION D'UNE CLASSE
spl_autoload_register("loadClass");


// FORMULAIRES
