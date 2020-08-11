<?php
if(isset($_SESSION['reservation']))
{
    foreach ($_SESSION['reservation'] as $resa){
        $eq = $resa['equipement'];
        $id = $resa['id_client'];
        $nb_pers = $resa['nb_personne'];
    }
    if (!isset($eq) || !isset($id) || !isset($nb_pers)){
        echo '<script type="text/javascript">alert("Veuillez renseigner une personne et un équipement !");window.location.assign("/createreservation");</script>';
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
                    <button style="margin-left: 2vh" onclick="backp()" class="btn btn-outline-danger btn-danger">
                        <i class="fa fa-caret-square-o-left"></i> Retour
                    </button>
                    <form id="form-reservation" class="ajax" action="" method="post">
                        <input type="hidden" name="controller" value="updateRes">
                        <input type="hidden" name="etape" value="et2">
                        <section class="statistic statistic2">
                            <div class="container">
                                <div style="margin: auto" class="col-md-6 col-lg-4">
                                    <div class="statistic__item statistic__item--blue" style="border-radius: 16px;">
                                        <input class="text-center form-control" type="text" name="date_res" id="date_res" value="<?= isset($_SESSION['reservation'][0]['date']) ? $_SESSION['reservation'][0]['date'] : null ?>" placeholder="Choisir la date" required>
                                        <label for="date_res" class="desc">Choisir la date</label>
                                        <div class="icon">
                                            <i class="zmdi zmdi-calendar-note"></i>
                                        </div>
                                    </div>
                                </div>
                                <?php foreach ($_SESSION['reservation'] as $resa){ ?>
                                    <hr>
                                    <div style="margin-bottom: 2vh!important; text-align: center!important;">
                                        <h2 class="title-1"><?php echo $resa['equipement']; ?></h2>
                                    </div>
                                    <div class="row">
                                        <div style="margin: auto" class="col-md-6 col-lg-4">
                                            <div class="statistic__item statistic__item--green" style="border-radius: 16px;">
                                                <input class="text-center form-control time_deb" type="text" name="time_deb_<?php echo $resa['equipement']; ?>" id="time_deb" value="<?= isset($resa['heure_deb']) ? $resa['heure_deb'] : null ?>" placeholder="Choisir l'heure de début" required>
                                                <label for="time_deb" class="desc">Choisir l'heure de début</label>
                                                <div class="icon">
                                                    <i class="zmdi zmdi-calendar-check"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="margin: auto" class="col-md-6 col-lg-4">
                                            <div class="statistic__item statistic__item--red" style="border-radius: 16px;">
                                                <input class="text-center form-control time_fin" type="text" name="time_fin_<?php echo $resa['equipement']; ?>" id="time_fin" value="<?= isset($resa['heure_fin']) ? $resa['heure_fin'] : null ?>" placeholder="Choisir l'heure de fin" required>
                                                <label for="time_fin" class="desc">Choisir l'heure de fin</label>
                                                <div class="icon">
                                                    <i class="zmdi zmdi-calendar-close"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
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
                $(".time_deb").timepicker({
                    timeOnlyTitle: 'Choisir l\'heure de début',
                });
                $(".time_fin").timepicker({
                    timeOnlyTitle: 'Choisir l\'heure de fin',});
            });

            function backp(){
                window.location.assign("createreservation1?id=<?php echo $_SESSION['reservation'][0]['id_client'] ?>");
            };
        </script>
        <?php
    }
}
else{
    echo '<script type="text/javascript">alert("Veuillez renseigner une personne et un équipement !");window.location.assign("/createreservation");</script>';
}
?>