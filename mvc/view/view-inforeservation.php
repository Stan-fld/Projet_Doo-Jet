<?php
//session_destroy();

//On récupère les infos de l'employé à partir de son id
$idreservation = $_GET["id"];
$reservation = $model->getReservation($idreservation);
//On récupère tous les pays
$pays = $model->getPays();

?>
<!-- Title Page-->
<title>Réservation de <?php echo $reservation[0]['Prenom']." ".$reservation[0]['Nom'] ?> du : : <?php echo substr($reservation[0]['debut'], 0, 10);?></title>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Réservation de <?php echo $reservation[0]['Prenom']." ".$reservation[0]['Nom'] ?> du :  </strong><?php echo substr($reservation[0]['debut'], 0, 10);?>
                            <button style="margin-left: 2vh" onclick="backp()" class="btn btn-outline-danger btn-sm">
                                <i class="fa fa-caret-square-o-left"></i> Retour
                            </button>
                        </div>
                        <div class="card-body card-block">
                            <div class="row form-group">
                                <label class="col col-md-3" for="nom">Nom moniteurs : </label>
                                <?php foreach($reservation as $resa){?>
                                    <div class="col col-md-3">
                                        <input name="nom" id="nom" class="text-center form-control"  type="text" disabled value="<?php echo $resa['Nom'];?>">
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row form-group">
                                <label class="col col-md-3" for="prenom">Prénom : </label>
                                <div class="col col-md-3">
                                    <input name="prenom" id="prenom" class="text-center form-control"  type="text" disabled value="<?php echo $reservation[0]['Prenom'];?>">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col col-md-3" for="tel">Téléphone : </label>
                                <div class="col col-md-3">
                                    <input name="tel" id="tel" class="text-center form-control"  type="text" disabled value="<?php echo $reservation[0]['Telephone']?>">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col col-md-3" for="permis">Numéro de permis : </label>
                                <div class="col col-md-3">
                                    <input name="permis" id="permis" class="text-center form-control"  type="text" disabled value="<?php echo $reservation[0]['N_Permis']?>">
                                </div>
                            </div>
                            <form action="" method="post" class="form-horizontal ajax">
                                <input type="hidden" name="controller" value="updateResa">
                                <input type="hidden" id="etape" name="etape" value="">
                                <input type="hidden" name="id_personne" value="<?php echo $reservation[0]['ID_Personne'];?>">
                                <div class="row form-group">
                                    <label class="col col-md-3" for="equipement">Équipement(s) : </label>
                                    <?php foreach($reservation as $resa){
                                        $debut = (substr($resa['debut'], 11, 2)*60) + substr($resa['debut'], 14, 2);
                                        $fin = (substr($resa['fin'], 11, 2)*60) + substr($resa['fin'], 14, 2);
                                        $res = $fin - $debut ;
                                        $prix = $model->getPrix($resa['ID_Equipement'], $res);
                                        $allprix[] = $prix['Prix'];
                                        ?>
                                        <div class="col col-md-3">
                                            <input name="equipement" id="equipement" class="text-center form-control"  type="text" disabled required value="<?php echo $resa['Nom_Equipement']?>">
                                        </div>
                                    <?php } ?>
                                </div>
                                <input type="hidden" name="id_equipement" value="<?php echo $resa['ID_Equipement'];?>">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    ?>
    <script>
        function backp(){
            history.back();
        }

    </script>
