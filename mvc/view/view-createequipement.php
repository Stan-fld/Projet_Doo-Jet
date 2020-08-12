<?php $equipements = $model->getEquipementDistinct() ?>
<!-- Title Page-->
<title>Création fiche équipement : </title>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Création fiche équipement : </strong>
                            <button style="margin-left: 2vh" onclick="backp()" class="btn btn-outline-danger btn-sm">
                                <i class="fa fa-caret-square-o-left"></i> Retour
                            </button>
                        </div>
                        <div class="card-body card-block">
                            <form action="" method="post" class="form-horizontal ajax">
                                <input type="hidden" name="controller" value="updateEquipement">
                                <input type="hidden" id="etape" name="etape" value="create_equipement">
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="nom">Nom : </label>
                                    <div class="col col-md-3">
                                        <select name="nom" id="nom" class="text-center form-control" required >
                                            <option selected disabled> Liste des équipements</option>
                                            <?php foreach($equipements as $equipement){ ?>
                                                <option value="<?php echo $equipement['Nom_Equipement'];?>"><?php echo $equipement['Nom_Equipement'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="commentaire">Commentaire : </label>
                                    <div class="col col-md-3">
                                        <input name="commentaire" id="commentaire" class="text-center form-control" type="text" required value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group" >
                                    <label class="col col-md-3 form-control-label" for="puissance">Puissance : </label>
                                    <div class="col col-md-3">
                                        <input name="puissance" id="puissance" class="text-center form-control"  type="text" required value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="service">Service : </label>
                                    <div class="col col-md-3">
                                        <select name="service" id="service" class="text-center form-control" required >
                                            <option value="1">En service</option>
                                            <option value="0">Hors service</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button id="hidebtnAnnuler" type="reset" style="margin-left: 2vh" class="btn btn-danger btn-sm">
                                        <i class="fa fa-ban"></i> Annuler
                                    </button>
                                    <button id="hidebtnValider" style="margin-left: 2vh" class="btn btn-success btn-sm">
                                        <i class="fa fa-check"></i> Valider
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-right">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function backp(){
            window.location.assign("/equipement")
        }
    </script>
