<?php
if (!isset($_SESSION['reservation']['date_res']) || !isset($_SESSION['reservation']['time_fin'])  || !isset($_SESSION['reservation']['nom_equipement']) || !isset($_SESSION['reservation']['duree'])) {
    echo '<script type="text/javascript">alert("Votre session a expiré, merci de recommencer votre sélection");window.location.assign("/createreservation");</script>';
}else{
$equipement = $_SESSION['reservation']['nom_equipement'];
$date = $_SESSION['reservation']['date_res'];
$debut = $date." ".$_SESSION['reservation']['time_deb'];
$fin = $date." ". $_SESSION['reservation']['time_fin'];
$durees = $_SESSION['reservation']['duree'];
$eq_dispo = $model->getEquipementDispo($debut, $fin, $equipement, $durees);
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
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="ideq">Equipements : <?php echo $equipement ?> </label>
                                    <div class="col col-md-3">
                                        <select name="ideq" id="ideq" class="text-center form-control pays" required>
                                            <?php foreach($eq_dispo as $eq_dispos){ ?>
                                                    <option value="<?php echo $eq_dispos['ID_Equipement'];?>"><?php echo $eq_dispos['Commentaire']." - ".$eq_dispos['Puissance']." cv - ".$eq_dispos['Prix'] ;?> &euro;</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
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
<?php } ?>