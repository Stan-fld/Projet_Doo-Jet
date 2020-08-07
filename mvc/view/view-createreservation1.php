<?php

$model = new Model;


if (!isset($_SESSION['reservation']['date_res']) && !isset($_SESSION['reservation']['time_deb'])) {
    echo '<script type="text/javascript">window.location.assign("/createreservation");</script>';
} else {

?>

<?php } ?>