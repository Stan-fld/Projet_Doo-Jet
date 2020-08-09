<?php
if(isset($_SESSION['reservation']))
{
    foreach ($_SESSION['reservation'] as $resa){
        $eq = $resa['equipement'];
        $date = $resa['date'];
        $debut = $resa['datetime_deb'];
        $fin = $resa['datetime_fin'];
        $duree = $resa['duree'];
    }
    if (!isset($eq) || !isset($date) || !isset($debut) || !isset($fin) || !isset($duree))
    {
        echo '<script type="text/javascript">alert("Votre session a expiré, merci de recommencer votre sélection !");window.location.assign("/createreservation");</script>';

    }else {?>

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
                                        $eq_dispo = $model->getEquipementDispo($resa['datetime_deb'], $resa['datetime_fin'], $resa['equipement'], $resa['duree']);?>
                                        <div class="row form-group">
                                            <label class="col col-md-3 form-control-label" for="ideq">Equipements : <?php echo $resa['equipement'] ?> </label>
                                            <div class="col col-md-3">
                                                <select name="ideq_<?php echo $resa['equipement']; ?>" id="ideq" class="text-center form-control" required>
                                                    <?php foreach($eq_dispo as $eq_dispos){
                                                        if($eq_dispos['Nom_Equipement'] == "JETSKI"){?>
                                                            <option value="<?php echo $eq_dispos['ID_Equipement'];?>"><?php echo $eq_dispos['Commentaire']." - ".$eq_dispos['Puissance']." cv - ".$eq_dispos['Prix'] ;?> &euro;</option>
                                                        <?php }else{ ?>
                                                            <option value="<?php echo $eq_dispos['ID_Equipement'];?>"><?php echo $eq_dispos['Commentaire']." - ".$eq_dispos['Prix'] ;?> &euro;</option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                                <?php if($resa['equipement'] == "JETSKI" || $resa['equipement'] == "BATEAU"){}else{?>
                                                    <strong style="color: red">Par Personne !!!</strong>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <hr>
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
        </script>
        <?php
    }
}
else{
    echo '<script type="text/javascript">alert("Votre session a expiré, merci de recommencer votre sélection !");window.location.assign("/createreservation");</script>';
}
?>