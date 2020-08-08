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
                        <form action="" method="post" class="form-horizontal ajax">
                            <div class="card-body card-block">
                                <input type="hidden" name="controller" value="updateRes">
                                <input type="hidden" id="etape" name="etape" value="et1">
                                <input type="hidden" name="id_client" value="<?php echo $idclient;?>">
                                <?php foreach($equipement as $equipements){?>
                                    <div class="row form-group">
                                        <label id="equipement" class="col col-md-3 form-control-label"><?php echo $equipements['Nom_Equipement'];?></label>
                                        <div class="col col-md-3">
                                            <label class="switch switch-default switch-primary-outline-alt switch-pill mr-2">
                                                <input type="checkbox" class="switch-input" name="<?php echo $equipements['Nom_Equipement'];?>" value="<?php echo $equipements['Nom_Equipement'];?>">
                                                <span class="switch-label" style="background-color: #d1ecf1"></span>
                                                <span class="switch-handle"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <hr>
                                <?php } ?>
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

    function backp(){
        history.back();
    }
</script>
