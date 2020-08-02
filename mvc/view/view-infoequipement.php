<?php
//session_destroy();

//On récupère les infos de l'equipement à partir de son id
$idequipement = $_GET["id"];
$equipement = $model->getEquipement($idequipement);
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
                                <div class="row form-group">
                                    <label class="col col-md-3" for="nom">Nom : </label>
                                    <div class="col col-md-3">
                                        <input name="nom" id="nom" class="text-center form-control"  type="text" required disabled value="<?php echo $equipement['Nom_Equipement'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="commentaire">Commentaire : </label>
                                    <div class="col col-md-3">
                                        <input name="commentaire" id="commentaire" class="text-center form-control" type="text" required disabled value="<?php echo $equipement['Commentaire'];?>">
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
                                <div class="row form-group" >
                                    <label class="col col-md-3 form-control-label" for="service">Service : </label>
                                    <div class="col col-md-3">
                                        <input name="service" id="service" class="text-center form-control"  type="text" required disabled value="<?php echo $equipement['Service'];?>">
                                    </div>
                                </div>
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
