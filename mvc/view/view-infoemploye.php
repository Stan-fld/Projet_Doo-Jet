<?php
//session_destroy();

//On récupère les infos de l'employé à partir de son id
$idemploye = $_GET["id"];
$employe = $model->getEmploye($idemploye);
//On récupère tous les pays
$pays = $model->getPays();
?>
<!-- Title Page-->
<title>Fiche employé : <?php echo $employe['Prenom']." ".$employe['Nom'];?></title>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Fiche employé : </strong><?php echo $employe['Prenom']." ".$employe['Nom'];?>
                        </div>
                        <div class="card-body card-block">
                            <form action="" method="post" class="form-horizontal ajax">
                                <input type="hidden" name="controller" value="updatePersonne">
                                <input type="hidden" id="etape" name="etape" value="">
                                <input type="hidden" name="id_employe" value="<?php echo $employe['ID_Personne'];?>">
                                <input type="hidden" name="id_adresse" value="<?php echo $employe['ID_Adresse'];?>">
                                <div class="row form-group">
                                    <label class="col col-md-3" for="nom">Nom : </label>
                                    <div class="col col-md-3">
                                        <input name="nom" id="nom" class="text-center form-control"  type="text" required disabled value="<?php echo $employe['Nom'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="prenom">Prénom : </label>
                                    <div class="col col-md-3">
                                        <input name="prenom" id="prenom" class="text-center form-control" type="text" required disabled value="<?php echo $employe['Prenom'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group" >
                                    <label class="col col-md-3 form-control-label" for="date_naissance">Date de naissance : </label>
                                    <div class="col col-md-3">
                                        <input name="date_naissance" id="date_naissance" class="text-center form-control"  type="text" required disabled value="<?php echo $employe['anniv'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="telephone">Téléphone : </label>
                                    <div class="col col-md-3">
                                        <input name="telephone" id="telephone" class="text-center form-control" type="text" required disabled value="<?php echo $employe['Telephone'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="num_permis">Numéro de permis : </label>
                                    <div class="col col-md-3">
                                        <input name="num_permis" id="num_permis" class="text-center form-control"  type="text" required disabled value="<?php echo $employe['N_Permis'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="num_secu">Numéro de sécurité sociale : </label>
                                    <div class="col col-md-3">
                                        <input name="num_secu" id="num_secu" class="text-center form-control"  type="text" required disabled value="<?php echo $employe['N_Securite_Sociale'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="num_bees">Numéro BEES : </label>
                                    <div class="col col-md-3">
                                        <input name="num_bees" id="num_bees" class="text-center form-control"  type="text" required disabled value="<?php echo $employe['N_BEES'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="contrat">Contrat : </label>
                                    <div class="col col-md-3">
                                        <input name="contrat" id="contrat" class="text-center form-control"  type="text" required disabled value="<?php echo $employe['Contrat'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="date_embauche">Date d'embauche : </label>
                                    <div class="col col-md-3">
                                        <input name="date_embauche" id="date_embauche" class="text-center form-control"  type="text" required disabled value="<?php echo $employe['dateembau'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="date_visite_med">Date dernière visite médicale : </label>
                                    <div class="col col-md-3">
                                        <input name="date_visite_med" id="date_visite_med" class="text-center form-control"  type="text" required disabled value="<?php echo $employe['datevisit'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="pays">Pays : </label>
                                    <div class="col col-md-3">
                                        <select name="nom_pays" id="nom_pays" class="text-center form-control pays" required disabled>
                                            <?php foreach($pays as $Pays){ ?>
                                                <?php if($Pays['Nom_Pays'] == $employe['Nom_Pays']) {?>
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
                                        <input name="num_voie" id="num_voie" class="text-center form-control"  type="text" required disabled value="<?php echo $employe['Numero_Rue'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="type_voie">Type de voie: </label>
                                    <div class="col col-md-3">
                                        <input name="type_voie" id="type_voie" class="text-center form-control"  type="text" required disabled value="<?php echo $employe['Type_Voie'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="nom_voie">Nom de voie: </label>
                                    <div class="col col-md-3">
                                        <input name="nom_voie" id="nom_voie" class="text-center form-control"  type="text" required disabled value="<?php echo $employe['Rue'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="ville">Ville : </label>
                                    <div class="col col-md-3">
                                        <input name="ville" id="ville" class="text-center form-control"  type="text" required disabled value="<?php echo $employe['Nom_Ville'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="code_postal">Code postal : </label>
                                    <div class="col col-md-3">
                                        <input name="code_postal" id="code_postal" class="text-center form-control"  type="text" required disabled value="<?php echo $employe['Code_Postal'];?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label"></label>
                                    <div class="col col-md-3 text-center">
                                        <strong style="font-size: large">Période d'inactivité</strong>
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="motifs">Motifs : </label>
                                    <div class="col col-md-3">
                                        <input name="motifs" id="motifs" class="text-center form-control"  type="text" disabled value="<?php echo $employe['Motif'];?>">
                                        <input name="newmotifs" id="newmotifs" class="text-center form-control hiddeninact" type="text" hidden value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="date_debut_ina">Date début d'inactivité : </label>
                                    <div class="col col-md-3">
                                        <input name="date_debut_ina" id="date_debut_ina" class="text-center form-control"  type="text" disabled value="<?php echo $employe['max_date_debut'];?>">
                                        <input name="newdate_debut" id="newdate_debut" class="text-center form-control hiddeninact"  type="text" hidden value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="date_fin_ina">Date fin d'inactivité : </label>
                                    <div class="col col-md-3">
                                        <input name="date_fin_ina" id="date_fin_ina" class="text-center form-control" type="text" disabled value="<?php echo $employe['max_date_fin'];?>">
                                        <input name="newdate_fin" id="newdate_fin" class="text-center form-control hiddeninact" type="text" hidden value="">
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
                        </div>
                        <div class="card-footer text-right">
                            <button id="modif" style="margin-left: 2vh" onclick="modif()" class="btn btn-warning btn-sm">
                                <i class="fa fa-cog"></i> Modifier
                            </button>
                            <button id="inact" style="margin-left: 2vh"  onclick="inact()" class="btn btn-secondary btn-sm">
                                <i class="fa fa-ambulance"></i> Ajouter inactivité
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

    <script>
        function modif() {
            $("input").prop('disabled', false);
            $("select").prop('disabled', false);
            $("#hidebtnAnnuler").css("display", "");
            $("#hidebtnValider").css("display", "");
            $("#inact").css("display", "none");
            $('#etape').val('update_employe');
            $('.pays').select2();
        }
        function inact() {
            $("#hidebtnAnnuler").css("display", "");
            $("#hidebtnValider").css("display", "");
            $("#modif").css("display", "none");
            $("#motifs").css("display", "none");
            $("#date_debut_ina").css("display", "none");
            $("#date_fin_ina").css("display", "none");
            $('#etape').val('new_inact');
            $(".hiddeninact").prop('hidden', false);
        }

        function supp() {
            $("#hidebtnAnnuler").css("display", "");
            $("#hidebtnValider").css("display", "");
            $('#etape').val('delete_employe');
            $("#modif").css("display", "none");
        }

        function reload() {
            window.location.reload();
        }
    </script>
