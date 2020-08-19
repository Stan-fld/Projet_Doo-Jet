<?php
//session_destroy();

//On récupère les infos de l'equipement à partir de son id
$idequipement = $_GET["id"];
$equipement = $model->getEquipement($idequipement);
$prix = $model->getPrix($idequipement);

$equipementAlls = $model->getEquipementDistinct()
?>
<!-- Title Page-->
<title>Fiche équipement : <?php echo $equipement['Nom_Equipement']." ".$equipement['Commentaire'];?></title>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Fiche équipement : <?php echo $equipement['Nom_Equipement']." ".$equipement['Commentaire'];?>
                                <button style="margin-left: 2vh" onclick="backp()" class="btn btn-outline-danger btn-sm">
                                    <i class="fa fa-caret-square-o-left"></i> Retour
                                </button>
                        </div>
                        <div class="card-body card-block">
                            <form action="" method="post" class="form-horizontal ajax">
                                <input type="hidden" name="controller" value="updateEquipement">
                                <input type="hidden" id="etape" name="etape" value="">
                                <input type="hidden" name="id_equipement" value="<?php echo $equipement['ID_Equipement'];?>">
                                <div class="row form-group" >
                                    <label class="col col-md-3 form-control-label">Numéro équipement : </label>
                                    <div class="col col-md-3 text-center">
                                        <label style="font-size: x-large; color: #17a2b8" class="form-control-label" type="text"><?php echo $equipement['ID_Equipement'];?></label>
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="nom">Nom : </label>
                                    <div class="col col-md-3">
                                        <select name="nom" id="nom" class="text-center form-control" required disabled>
                                            <?php foreach($equipementAlls as $equipementAll){ ?>
                                                <option <?= $equipement['Nom_Equipement'] == $equipementAll['Nom_Equipement'] ? 'selected' : '' ?> value="<?php echo $equipementAll['Nom_Equipement'];?>"><?php echo $equipementAll['Nom_Equipement'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="commentaire">Commentaire : </label>
                                    <div class="col col-md-3">
                                        <textarea name="commentaire" id="commentaire" class="text-center form-control" type="text" required disabled><?php echo $equipement['Commentaire'];?></textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group" >
                                    <label class="col col-md-3 form-control-label" for="puissance">Puissance : </label>
                                    <div class="col col-md-3">
                                        <input name="puissance" id="puissance" class="text-center form-control"  type="text" required disabled value="<?php echo $equipement['Puissance'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="service">Service : </label>
                                    <div class="col col-md-3">
                                        <select name="service" id="service" class="text-center form-control" required disabled>
                                            <option <?= $equipement['Service'] == 1 ? 'selected' : '' ?> value="1">En service</option>
                                            <option <?= $equipement['Service'] == 0 ? 'selected' : '' ?> value="0">Hors service</option>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <div class="col col-md-3 text-center">
                                        <strong style="font-size: large">Durée</strong>
                                    </div>
                                    <div class="col col-md-3 text-center">
                                        <strong style="font-size: large">Prix </strong>(&euro;)
                                    </div>
                                </div>
                                <hr style="border-top: 1px dashed;">
                                <?php foreach ($prix as $Prix){
                                    $duree = ($Prix['Duree'])/60;
                                    $dureeH = substr($duree, 0, 1)."h".(substr($duree,2,1)*6);
                                    if(strlen($dureeH) == 3){ $dureeH = substr($dureeH,0,3)."0"; }?>
                                        <input type="hidden" name="id_prix_<?php echo $Prix['Duree'] ?>" value="<?php echo $Prix['ID_Prix_Horaire'] ?>">
                                    <div class="row form-group" >
                                        <label class="col col-md-3 form-control-label text-center" for="prix_<?php echo $Prix['Duree'] ?>"><?php echo $dureeH; ?></label>
                                        <div class="col col-md-3">
                                            <input name="prix_<?php echo $Prix['Duree'] ?>" id="prix_<?php echo $Prix['Duree'] ?>" class="text-center form-control"  type="text" required disabled value="<?php echo $Prix['Prix'] ?>">
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="card-footer text-right">
                                    <button id="hidebtnAnnuler" type="button" style="margin-left: 2vh; display:none" onclick="reload()" class="btn btn-danger btn-sm">
                                        <i class="fa fa-ban"></i> Annuler
                                    </button>
                                    <button id="hidebtnValider" style="margin-left: 2vh; display:none" class="btn btn-success btn-sm">
                                        <i class="fa fa-check"></i> Valider
                                    </button>
                                </div>
                            </form>
                            <div style="margin-top: 2vh"  class="text-right">
                                <button id="modif" style="margin-left: 2vh" onclick="modif()" class="btn btn-warning btn-sm">
                                    <i class="fa fa-cog"></i> Modifier
                                </button>
                                <button id="supp" style="margin-left: 2vh" onclick="supp()" class="btn btn-danger btn-sm">
                                    <i class="fa fa-cog"></i> Supprimer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function modif() {
            $("input").prop('disabled', false);
            $("select").prop('disabled', false);
            $("textarea").prop('disabled', false);
            $("#hidebtnAnnuler").css("display", "");
            $("#hidebtnValider").css("display", "");
            $("#supp").css("display", "none");
            $('#etape').val('update_equipement');
        }

        function supp() {
            $("#hidebtnAnnuler").css("display", "");
            $("#hidebtnValider").css("display", "");
            $('#etape').val('delete_equipement');
            $("#modif").css("display", "none");
        }

        function backp(){
            window.location.assign("/equipement")
        }

        function reload() {
            window.location.reload();
        }
    </script>
