<?php
$idclient = $_GET["id"];
$client = $model->getClient($idclient);
?>
<!-- Title Page-->
<title>Fiche client : <?php echo $client['Prenom']." ".$client['Nom'];?></title>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Fiche client : </strong><?php echo $client['Prenom']." ".$client['Nom'];?>
                        </div>
                        <div class="card-body card-block">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label class=" form-control-label">Nom</label>
                                    </div>
                                    <div class="col col-md-3">
                                        <label class=" form-control-label"><?php echo $client['Nom'];?></label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label class=" form-control-label">Prénom</label>
                                    </div>
                                    <div class="col col-md-3">
                                        <label class=" form-control-label"><?php echo $client['Prenom'];?></label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label class=" form-control-label">Date de naissance</label>
                                    </div>
                                    <div class="col col-md-3">
                                        <label class=" form-control-label"><?php echo $client['anniv'];?></label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label class=" form-control-label">Téléphone</label>
                                    </div>
                                    <div class="col col-md-3">
                                        <label class=" form-control-label"><?php echo $client['Telephone'];?></label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label class=" form-control-label">Numéro de permis</label>
                                    </div>
                                    <div class="col col-md-3">
                                        <label class=" form-control-label"><?php echo $client['N_Permis'];?></label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label class=" form-control-label">Adresse</label>
                                    </div>
                                    <div class="col col-md-3">
                                        <label class=" form-control-label"><?php echo $client['Numero_Rue']." ".$client['Rue'];?></label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label class=" form-control-label">Ville</label>
                                    </div>
                                    <div class="col col-md-3">
                                        <label class=" form-control-label"><?php echo $client['Nom_Ville'];?></label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label class=" form-control-label">Code postal</label>
                                    </div>
                                    <div class="col col-md-3">
                                        <label class=" form-control-label"><?php echo $client['Code_Postal'];?></label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label class=" form-control-label">Pays</label>
                                    </div>
                                    <div class="col col-md-3">
                                        <label class=" form-control-label"><?php echo $client['Nom_Pays'];?></label>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-dot-circle-o"></i> Submit
                            </button>
                            <button type="reset" class="btn btn-danger btn-sm">
                                <i class="fa fa-ban"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>