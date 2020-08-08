<?php
if (!isset($_SESSION['reservation']['$id_client']) || !isset($_SESSION['reservation']['nom_equipement'])) {
    echo '<script type="text/javascript">window.location.assign("/createreservation");</script>';
} else {?>

<body class="animsition">
<div class="page-wrapper">
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="col-md-12">
                <div style="text-align: center!important;">
                    <h2 class="title-1">Date souhaitée pour la réservation :</h2>
                </div>
            </div>
            <form id="form-reservation" class="ajax" action="" method="post">
                <input type="hidden" name="controller" value="updateRes">
                <input type="hidden" name="etape" value="et2">
                <section class="statistic statistic2">
                    <div class="container">
                        <div style="margin: auto" class="col-md-6 col-lg-4">
                            <div class="statistic__item statistic__item--blue" style="border-radius: 16px;">
                                <input class="text-center form-control" type="text" name="date_res" id="date_res" value="<?= isset($dateRes) ? $dateRes : null ?>" placeholder="Choisir la date" required>
                                <label for="date_res" class="desc">Choisir la date</label>
                                <div class="icon">
                                    <i class="zmdi zmdi-calendar-note"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div style="margin: auto" class="col-md-6 col-lg-4">
                                <div class="statistic__item statistic__item--green" style="border-radius: 16px;">
                                    <input class="text-center form-control" type="text" name="time_deb" id="time_deb" value="<?= isset($timeDeb) ? $timeDeb : null ?>" placeholder="Choisir l'heure de début" required>
                                    <label for="time_deb" class="desc">Choisir l'heure de début</label>
                                    <div class="icon">
                                        <i class="zmdi zmdi-calendar-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div style="margin: auto" class="col-md-6 col-lg-4">
                                <div class="statistic__item statistic__item--red" style="border-radius: 16px;">
                                    <input class="text-center form-control" type="text" name="time_fin" id="time_fin" value="<?= isset($timeFin) ? $timeFin : null ?>" placeholder="Choisir l'heure de fin" required>
                                    <label for="time_fin" class="desc">Choisir l'heure de fin</label>
                                    <div class="icon">
                                        <i class="zmdi zmdi-calendar-close"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="text-center">
                    <button class="btn btn-outline-success">Étape suivante</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<script>
    $( function() {
        $( "#date_res" ).datepicker({
            dateFormat: "dd/mm/yy", //affichage de la date au format français jj-mm-yyyy
            showAnim: "blind",
            dayNames: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
            dayNamesMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
            dayNamesShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
            firstDay: 1,
            monthNames: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
        });
        $("#time_deb").timepicker({
            timeOnlyTitle: 'Choisir l\'heure de début',
        });
        $("#time_fin").timepicker({
            timeOnlyTitle: 'Choisir l\'heure de fin',});
    });
</script>
<?php } ?>