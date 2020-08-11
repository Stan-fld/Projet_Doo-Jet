<?php
if(isset($_SESSION['reservation']))
{
    $total = 0;
    $totalF = 0;

    foreach ($_SESSION['reservation'] as $resa){
        $eq = $resa['equipement'];
        $date = $resa['date'];
        $debut = $resa['heure_deb'];
        $fin = $resa['heure_fin'];
        $duree = $resa['duree'];
        $id_resa = ['id_resa'];
    }
    if (!isset($eq) || !isset($date) || !isset($debut) || !isset($fin) || !isset($duree) || !isset($id_resa))
    {
        echo '<script type="text/javascript">alert("Votre session a expiré, merci de recommencer votre sélection !");window.location.assign("/createreservation");</script>';
    }else {
        $id_client = $_SESSION['reservation'][0]['id_client'];
        $client = $model->getClient($id_client); ?>
        <!-- Title Page-->
        <title>Récap réservation : <?php echo $client['Prenom']." ".$client['Nom'];?></title>
        <div class="page-wrapper">
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="row m-t-30">
                    <div class="col-md-12">
                        <div style="margin-bottom: 2vh!important; text-align: center!important;">
                            <h2 class="title-1">Récapitulatif réservation : <?php echo $client['Prenom']." ".$client['Nom'].", N° ". $_SESSION['reservation'][0]['id_resa'];?></h2>
                        </div>
                        <!-- DATA TABLE-->
                        <div class="table-responsive m-b-40">
                            <table class="table table-borderless table-data3">
                                <thead>
                                <tr >
                                    <th>Équipement</th>
                                    <th>Date</th>
                                    <th>Heure de début</th>
                                    <th>Heure de fin</th>
                                    <th>Nombre de personnes</th>
                                    <th>Prix par personne</th>
                                    <th class="total_column">Total</th>
                                </tr>
                                </thead>
                                <tbody class="text-center">
                                <?php foreach ($_SESSION['reservation'] as $resa){ ?>
                                    <tr>
                                        <td><?php echo $resa['equipement'];?></td>
                                        <td><?php echo $resa['date'];?></td>
                                        <td><?php echo $resa['heure_deb'];?></td>
                                        <td><?php echo $resa['heure_fin'];?></td>
                                        <td><?php echo $resa['nb_personne'];?></td>
                                        <td><?php echo $resa['prix'];?> &euro;</td>
                                        <?php if($resa['equipement'] == "JETSKI" && $resa['id_empolye'] !== ""){
                                            $total += ((($resa['prix']*$resa['nb_personne'])*20/100)+$resa['prix']);?>
                                            <td><?php echo $total;?> &euro;</td>
                                        <?php }else{
                                            $total = ($resa['prix']*$resa['nb_personne']);?>
                                            <td><?php echo $total;?> &euro;</td>
                                        <?php } ?>
                                    </tr>
                                    <?php $totalF += $total; $total = 0;} ?>
                                </tbody>
                                <tbody class="text-center">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="color: #1b1b1b; font-weight: bolder">TOTAL : </td>
                                <td style="color: #1b1b1b"><?php echo $totalF; ?> &euro;</td>
                                </tbody>
                            </table>
                            <form action="" method="post" class="form-horizontal ajax">
                                <input type="hidden" name="controller" value="updateRes">
                                <input type="hidden" id="etape" name="etape" value="et4">
                                <div class="card-body card-block text-right">
                                    <button style="margin-left: 2vh;" class="btn btn-success btn-sm">
                                        <i class="fa fa-check"></i> Valider
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- END DATA TABLE-->
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
else{
    echo '<script type="text/javascript">alert("Votre session a expiré, merci de recommencer votre sélection !");window.location.assign("/createreservation");</script>';
}
?>