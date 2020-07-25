<?php
if ($_GET['id'] == null or $_GET['id'] == 0) {
    echo '<script type="text/javascript">window.location.assign("/employe");</script>';
} else {
    //session_destroy();
    $idemploye = $_GET["id"];
    $employe = $model->getEmploye($idemploye);
?>
<!-- Title Page-->
<title>Fiche client : <?php echo $employe['Prenom']." ".$employe['Nom'];?></title>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Fiche client : </strong><?php echo $employe['Prenom']." ".$employe['Nom'];?>
                        </div>
                        <div class="card-body card-block">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <input type="hidden" name="controller" value="updateEmploye">
                                <input type="hidden" name="id_employe" value="<?php echo $employe['ID_Personne'];?>">
                                <div class="row form-group">
                                    <label class="col col-md-3" for="nom">Nom : </label>
                                    <div class="col col-md-3">
                                        <input name="nom" id="nom" class="text-center form-control"  type="text" disabled value="<?php echo $employe['Nom'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="prenom">Prénom : </label>
                                    <div class="col col-md-3">
                                        <input name="prenom" id="prenom" class="text-center form-control"  type="text" disabled value="<?php echo $employe['Prenom'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group" >
                                    <label class="col col-md-3 form-control-label" for="date_naissance">Date de naissance : </label>
                                    <div class="col col-md-3">
                                        <input name="date_naissance" id="date_naissance" class="text-center form-control"  type="text" disabled value="<?php echo $employe['anniv'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="telephone">Téléphone : </label>
                                    <div class="col col-md-3">
                                        <input name="telephone" id="telephone" class="text-center form-control" type="text" disabled value="<?php echo $employe['Telephone'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="num_permis">Numéro de permis : </label>
                                    <div class="col col-md-3">
                                        <input name="num_permis" id="num_permis" class="text-center form-control"  type="text" disabled value="<?php echo $employe['N_Permis'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="num_secu">Numéro de sécurité sociale : </label>
                                    <div class="col col-md-3">
                                        <input name="num_secu" id="num_secu" class="text-center form-control"  type="text" disabled value="<?php echo $employe['N_Securite_Sociale'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="num_bees">Numéro BEES : </label>
                                    <div class="col col-md-3">
                                        <input name="num_bees" id="num_bees" class="text-center form-control"  type="text" disabled value="<?php echo $employe['N_BEES'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="contrat">Contrat : </label>
                                    <div class="col col-md-3">
                                        <input name="contrat" id="contrat" class="text-center form-control"  type="text" disabled value="<?php echo $employe['Contrat'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="date_embauche">Date d'embauche : </label>
                                    <div class="col col-md-3">
                                        <input name="date_embauche" id="date_embauche" class="text-center form-control"  type="text" disabled value="<?php echo $employe['dateembau'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="date_visite_med">Date dernière visite médicale</label>
                                    <div class="col col-md-3">
                                        <input name="date_visite_med" id="date_visite_med" class="text-center form-control"  type="text" disabled value="<?php echo $employe['datevisit'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="adresse">Adresse</label>
                                    <div class="col col-md-3">
                                        <input name="adresse" id="adresse" class="text-center form-control"  type="text" disabled value="<?php echo $employe['Numero_Rue']." ".$employe['Rue'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="ville">Ville</label>
                                    <div class="col col-md-3">
                                        <input name="ville" id="ville" class="text-center form-control"  type="text" disabled value="<?php echo $employe['Nom_Ville'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="code_postal">Code postal</label>
                                    <div class="col col-md-3">
                                        <input name="code_postal" id="code_postal" class="text-center form-control"  type="text" disabled value="<?php echo $employe['Code_Postal'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="pays">Pays</label>
                                    <div class="col col-md-3">
                                        <input name="pays" id="pays" class="text-center form-control"  type="text" disabled value="<?php echo $employe['Nom_Pays'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="motifs">Motifs</label>
                                    <div class="col col-md-3">
                                        <input name="motifs" id="motifs" class="text-center form-control"  type="text" disabled value="<?php echo $employe['Motif'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" id="date_debut_ina">Date début d'inactivité</label>
                                    <div class="col col-md-3">
                                        <input name="date_debut_ina" id="date_debut_ina" class="text-center form-control"  type="text" disabled value="<?php echo $employe['max_date_debut'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="date_fin_ina">Date fin d'inactivité</label>
                                    <div class="col col-md-3">
                                        <input name="date_fin_ina" id="date_fin_ina" class="text-center form-control" type="text" disabled value="<?php echo $employe['max_date_fin'];?>">
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button id="hidebtn1" style="margin-left: 2vh; display:none" onclick="reload()" class="btn btn-danger btn-sm">
                                        <i class="fa fa-ban"></i> Annuler
                                    </button>
                                    <button id="hidebtn2" style="margin-left: 2vh; display:none" type="submit" class="btn btn-success btn-sm ajax">
                                        <in class="fa fa-check"></in> Valider
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-right">
                            <button style="margin-left: 2vh" onclick="enable()" class="btn btn-warning btn-sm">
                                <i class="fa fa-cog"></i> Modifier
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function enable() {
            $("input").prop('disabled', false);
            $("#hidebtn1").css("display", "");
            $("#hidebtn2").css("display", "");
        }
        function reload() {
            location.reload();
        }
    </script>
    <?php }?>

    <?php

    $nom         = $model->getInput('nom');
    $_SESSION['update']['employe']['nom']                  =  $nom;
    var_dump($_SESSION);
    ?>
