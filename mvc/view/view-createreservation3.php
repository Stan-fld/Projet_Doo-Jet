<?php
if(isset($_SESSION['reservation']))
{
    foreach ($_SESSION['reservation'] as $resa){
        $eq = $resa['equipement'];
        $date = $resa['date_us'];
        $debut = $resa['datetime_deb'];
        $fin = $resa['datetime_fin'];
        $duree = $resa['duree'];
    }
    if (!isset($eq) || !isset($date) || !isset($debut) || !isset($fin) || !isset($duree))
    {
        echo '<script type="text/javascript">alert("Votre session a expiré, merci de recommencer votre sélection !");window.location.assign("/createreservation");</script>';

    }else {
        $id_client = $_SESSION['reservation'][0]['id_client'];
        $client = $model->getClient($id_client);
        ?>
        <!-- Title Page-->
        <title>Reservation</title>
        <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <strong>Reservation </strong>
                                <button style="margin-left: 2vh" onclick="backp()" class="btn btn-outline-danger btn-sm">
                                    <i class="fa fa-caret-square-o-left"></i> Retour
                                </button>
                            </div>
                            <div class="card-body card-block">
                                <form action="" method="post" class="form-horizontal ajax">
                                    <input type="hidden" name="controller" value="updateRes">
                                    <input type="hidden" id="etape" name="etape" value="et3">
                                    <?php foreach ($_SESSION['reservation'] as $resa){
                                        $eq_dispo = $model->getEquipementDispo($resa['datetime_deb'], $resa['datetime_fin'], $resa['equipement'], $resa['duree']);
                                        $employe_dispo = $model->getEqmployeDispo($resa['date_us'], $resa['datetime_deb'], $resa['datetime_fin'])?>
                                        <div class="row form-group">
                                            <label class="col col-md-3 form-control-label" for="ideq">Equipements : <?php echo $resa['equipement'] ?> </label>
                                            <div class="col col-md-3">
                                                <select name="ideq_<?php echo $resa['equipement']; ?>" id="ideq" class="text-center form-control" required>
                                                    <?php foreach($eq_dispo as $eq_dispos){
                                                        $val = $eq_dispos['ID_Equipement']."-".$eq_dispos['Prix'];
                                                        if($eq_dispos['Nom_Equipement'] == "JETSKI"){?>
                                                            <option value="<?php echo $val;?>"><?php echo $eq_dispos['Commentaire']." - ".$eq_dispos['Puissance']." cv - ".$eq_dispos['Prix'] ;?> &euro;</option>
                                                        <?php }else{ ?>
                                                            <option value="<?php echo $val;?>"><?php echo $eq_dispos['Commentaire']." - ".$eq_dispos['Prix'] ;?> &euro;</option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                                <?php if($resa['equipement'] == "JETSKI" || $resa['equipement'] == "BATEAU"){}else{?>
                                                    <strong style="color: red">Par Personne !!!</strong>
                                                <?php } ?>
                                            </div>
                                            <div class="col col-md-3">
                                                <?php if($resa['equipement'] == "JETSKI"){?>
                                                    <select name="idemp_<?php echo $resa['equipement']; ?>" id="idemp" class="text-center form-control" <?= $client['N_Permis'] == NULl ? 'required' : '' ?>>
                                                        <option disabled selected value=""><?= $client['N_Permis'] == NULl ? 'MONITEUR OBLIGATOIRE' : 'MONITEUR FACULTATIF' ?></option>
                                                        <?php foreach ($employe_dispo as $emp){
                                                            if($emp['N_BEES'] !== NULL){?>
                                                                <option value="<?php echo $emp['ID_Personne'];?>"><?php echo $emp['Prenom']." - ".$emp['Nom']." - ".$emp['N_BEES'] ;?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                <?php } ?>
                                                <?php if($resa['equipement'] == "BATEAU" ||$resa['equipement'] == "BOUEE"){?>
                                                    <select name="idemp_<?php echo $resa['equipement']; ?>" id="idem" class="text-center form-control" required>
                                                        <option disabled selected value="">MONITEUR OBLIGATOIRE</option>
                                                        <?php foreach ($employe_dispo as $emp){
                                                            if($emp['N_Permis'] !== NULL){?>
                                                                <option value="<?php echo $emp['ID_Personne'];?>"><?php echo $emp['Prenom']." - ".$emp['Nom']." - ".$emp['N_Permis'] ;?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                <?php } ?>
                                                <?php if($resa['equipement'] == "WAKE-BOARD" ||$resa['equipement'] == "SKI-NAUTIQUE"){?>
                                                    <select name="idemp_<?php echo $resa['equipement']; ?>" id="idemp" class="text-center form-control" required>
                                                        <option disabled selected value="">MONITEUR OBLIGATOIRE</option>
                                                        <?php foreach ($employe_dispo as $emp){
                                                            if($emp['N_Permis'] !== NULL && $emp['N_BEES'] !== NULL){?>
                                                                <option value="<?php echo $emp['ID_Personne'];?>"><?php echo $emp['Prenom']." - ".$emp['Nom']." - ".$emp['N_Permis'] ;?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                <?php } ?>
                                            </div>
                                            <label style="color: #00a2e3" class="col col-md-3 form-control-label" for="service"><?php echo $resa['heure_deb'].'-'.$resa['heure_fin'] ?></label>
                                        </div>
                                        <hr>
                                    <?php } ?>
                                    <div class="card-footer text-right">
                                        <button class="btn btn-success btn-sm">
                                            <i class="fa fa-check"></i> Valider
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function backp(){
                window.location.assign("createreservation2");
            }
            let forbidden_value = [];
            $(document).on('focus', 'select', function(){
                $(this).data('val', this.value);
            }).on('change','select', function(){
                var prev = $(this).data('val');
                var current = $(this).val();
                if ($.inArray(prev, forbidden_value) !== -1){
                    forbidden_value = $.grep(forbidden_value, function(value) {
                        return value != prev;
                    });
                }
                forbidden_value.push(current);
                $(this).attr('valu', current)
                $('select').not(this).children().each(function(){
                    let otherval = $(this).attr('value');
                    if ($.inArray(otherval, forbidden_value) !== -1 && $(this).parent().attr('valu') !== otherval ){
                        $(this).prop('disabled', true);
                    }else{
                        $(this).prop('disabled', false);
                    }
                })
                $(this).blur();
            });

        </script>
        <?php
    }
}
else{
    echo '<script type="text/javascript">alert("Votre session a expiré, merci de recommencer votre sélection !");window.location.assign("/createreservation");</script>';
}
?>