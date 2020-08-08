<?php
$idclient = $_GET["id"];
//$_SESSION['reservation']['$idpersonne']    =   $idpersonne;
$equipement = $model->getEquipementAllOn();
?>
<!-- Title Page-->
<title>Sélectionner l'activitée</title>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Sélectionner l'activitée: </strong>
                            <button style="margin-left: 2vh" onclick="backp()" class="btn btn-outline-danger btn-sm">
                                <i class="fa fa-caret-square-o-left"></i> Retour
                            </button>
                        </div>
                        <div class="card-body card-block">
                            <form action="" method="post" class="form-horizontal ajax">
                                <input type="hidden" name="controller" value="updateRes">
                                <input type="hidden" id="etape" name="etape" value="et1">
                                <input type="hidden" name="id_client" value="<?php echo $idclient;?>">
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="equipement">Equipements : </label>
                                    <div class="col col-md-3">
                                        <select name="equipement" id="equipement" class="text-center form-control equipement" required  >
                                            <?php foreach($equipement as $equipements){ ?>
                                                <option value="<?php echo $equipements['Nom_Equipement'];?>"><?php echo $equipements['Nom_Equipement'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
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
        $(document).ready(function() {
            $('.equipement').select2();
        });

        function backp(){
            history.back();
        }
    </script>
