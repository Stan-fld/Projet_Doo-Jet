<?php
//session_destroy();
$idclient = $_GET["id"];
$client = $model->getClient($idclient);
$pays = $model->getPays();
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
                            <form action="" method="post" class="form-horizontal ajax">
                                <input type="hidden" name="controller" value="updatePersonne">
                                <input type="hidden" id="etape" name="etape" value="">
                                <input type="hidden" name="id_client" value="<?php echo $client['ID_Personne'];?>">
                                <input type="hidden" name="id_adresse" value="<?php echo $client['ID_Adresse'];?>">
                                <div class="row form-group">
                                    <label class="col col-md-3" for="nom">Nom : </label>
                                    <div class="col col-md-3">
                                        <input name="nom" id="nom" class="text-center form-control"  type="text" required disabled value="<?php echo $client['Nom'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="prenom">Prénom : </label>
                                    <div class="col col-md-3">
                                        <input name="prenom" id="prenom" class="text-center form-control" type="text" required disabled value="<?php echo $client['Prenom'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group" >
                                    <label class="col col-md-3 form-control-label" for="date_naissance">Date de naissance : </label>
                                    <div class="col col-md-3">
                                        <input name="date_naissance" id="date_naissance" class="text-center form-control"  type="text" required disabled value="<?php echo $client['anniv'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="telephone">Téléphone : </label>
                                    <div class="col col-md-3">
                                        <input name="telephone" id="telephone" class="text-center form-control" type="text" required disabled value="<?php echo $client['Telephone'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="num_permis">Numéro de permis : </label>
                                    <div class="col col-md-3">
                                        <input name="num_permis" id="num_permis" class="text-center form-control"  type="text" disabled value="<?php echo $client['N_Permis'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="pays">Pays : </label>
                                    <div class="col col-md-3">
                                        <select name="nom_pays" id="nom_pays" class="text-center form-control pays" required disabled>
                                            <?php foreach($pays as $Pays){ ?>
                                                <?php if($Pays['Nom_Pays'] == $client['Nom_Pays']) {?>
                                                    <option selected value="<?php echo $Pays['Nom_Pays'];?>"><?php echo $Pays['Nom_Pays'];?></option>
                                                <?php }else{ ?>
                                                    <option value="<?php echo $Pays['Nom_Pays'];?>"><?php echo $Pays['Nom_Pays'];?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="num_voie">Numéro de voie: </label>
                                    <div class="col col-md-3">
                                        <input name="num_voie" id="num_voie" class="text-center form-control"  type="text" required disabled value="<?php echo $client['Numero_Rue'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="type_voie">Type de voie: </label>
                                    <div class="col col-md-3">
                                        <input name="type_voie" id="type_voie" class="text-center form-control"  type="text" required disabled value="<?php echo $client['Type_Voie'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="nom_voie">Nom de voie: </label>
                                    <div class="col col-md-3">
                                        <input name="nom_voie" id="nom_voie" class="text-center form-control"  type="text" required disabled value="<?php echo $client['Rue'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="ville">Ville : </label>
                                    <div class="col col-md-3">
                                        <input name="ville" id="ville" class="text-center form-control"  type="text" required disabled value="<?php echo $client['Nom_Ville'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="code_postal">Code postal : </label>
                                    <div class="col col-md-3">
                                        <input name="code_postal" id="code_postal" class="text-center form-control"  type="text" required disabled value="<?php echo $client['Code_Postal'];?>">
                                    </div>
                                </div>
                                <div class="card-footer text-right" id="hidebtn1">
                                    <button id="hidebtnAnnuler" type="button" style="margin-left: 2vh; display:none" onclick="reload()" class="btn btn-danger btn-sm">
                                        <i class="fa fa-ban"></i> Annuler
                                    </button>
                                    <button id="hidebtnValider" style="margin-left: 2vh; display:none" class="btn btn-success btn-sm">
                                        <i class="fa fa-check"></i> Valider
                                    </button>
                                </div>
                            </form>

                            <div style="margin-top: 2vh" class="text-right">
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
            $("#hidebtnAnnuler").css("display", "");
            $("#hidebtnValider").css("display", "");
            $("#supp").css("display", "none");
            $('#etape').val('update_client');
            $('.pays').select2();
        }

        function supp() {
            $("#hidebtnAnnuler").css("display", "");
            $("#hidebtnValider").css("display", "");
            $('#etape').val('delete_client');
            $("#modif").css("display", "none");
        }

        function reload() {
            window.location.reload();
        }
    </script>
