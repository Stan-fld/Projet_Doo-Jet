<?php
//On récupère tous les pays
$pays = $model->getPays();
?>
<!-- Title Page-->
<title>Création fiche employé : </title>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Création fiche employé : </strong>
                            <button style="margin-left: 2vh" onclick="backp()" class="btn btn-outline-danger btn-sm">
                                <i class="fa fa-caret-square-o-left"></i> Retour
                            </button>
                        </div>
                        <div class="card-body card-block">
                            <form action="" method="post" class="form-horizontal ajax">
                                <input type="hidden" name="controller" value="updatePersonne">
                                <input type="hidden" id="etape" name="etape" value="create_employe">
                                <div class="row form-group">
                                    <label class="col col-md-3" for="nom">Nom : </label>
                                    <div class="col col-md-3">
                                        <input name="nom" id="nom" class="text-center form-control"  type="text" required  value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="prenom">Prénom : </label>
                                    <div class="col col-md-3">
                                        <input name="prenom" id="prenom" class="text-center form-control" type="text" required value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group" >
                                    <label class="col col-md-3 form-control-label" for="date_naissance">Date de naissance : </label>
                                    <div class="col col-md-3">
                                        <input name="date_naissance" id="date_naissance" class="text-center form-control"  type="text" required value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="telephone">Téléphone : (identifiant)</label>
                                    <div class="col col-md-3">
                                        <input name="telephone" id="telephone" class="text-center form-control" type="text" required  value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="password">Mot de passe : </label>
                                    <div class="col col-md-3">
                                        <input name="password" id="password" class="text-center form-control" type="password" required  value="">
                                    </div>
                                    <div id="erreur" style="color: red; display: none">
                                        <p>Mot de passe trop court !</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="num_permis">Numéro de permis : </label>
                                    <div class="col col-md-3">
                                        <input name="num_permis" id="num_permis" class="text-center form-control"  type="text" value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="num_secu">Numéro de sécurité sociale : </label>
                                    <div class="col col-md-3">
                                        <input name="num_secu" id="num_secu" class="text-center form-control"  type="text" required value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="num_bees">Numéro BEES : </label>
                                    <div class="col col-md-3">
                                        <input name="num_bees" id="num_bees" class="text-center form-control"  type="text" value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="contrat">Contrat : </label>
                                    <div class="col col-md-3">
                                        <input name="contrat" id="contrat" class="text-center form-control"  type="text" required value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="date_embauche">Date d'embauche : </label>
                                    <div class="col col-md-3">
                                        <input name="date_embauche" id="date_embauche" class="text-center form-control"  type="text" required value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="date_visite_med">Date dernière visite médicale : </label>
                                    <div class="col col-md-3">
                                        <input name="date_visite_med" id="date_visite_med" class="text-center form-control"  type="text" required value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="pays">Pays : </label>
                                    <div class="col col-md-3">
                                        <select name="nom_pays" id="nom_pays" class="text-center form-control pays" required >
                                            <?php foreach($pays as $Pays){ ?>
                                                <?php if($Pays['Nom_Pays'] == 'France'){?>
                                                    <option selected value="<?php echo $Pays['Nom_Pays'];?>"><?php echo $Pays['Nom_Pays'];?></option>
                                                <?php }else{?>
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
                                        <input name="num_voie" id="num_voie" class="text-center form-control"  type="text" required  value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="type_voie">Type de voie: </label>
                                    <div class="col col-md-3">
                                        <input name="type_voie" id="type_voie" class="text-center form-control"  type="text" required  value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="nom_voie">Nom de voie: </label>
                                    <div class="col col-md-3">
                                        <input name="nom_voie" id="nom_voie" class="text-center form-control"  type="text" required  value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="ville">Ville : </label>
                                    <div class="col col-md-3">
                                        <input name="ville" id="ville" class="text-center form-control"  type="text" required  value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="code_postal">Code postal : </label>
                                    <div class="col col-md-3">
                                        <input name="code_postal" id="code_postal" class="text-center form-control"  type="text" required  value="">
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
        $( document ).ready(function() {
            $('.pays').select2();
        });

        function backp(){
            window.location.assign("/employe")
        }

        $(document).ready(function(){
            $("#password").on("keyup", function(){
                if($(this).val().length < 6){ // si la chaîne de caractères est inférieure à 6
                    $(this).css({ // on rend le champ rouge
                        borderColor : 'red',
                        color : 'red'
                    });
                    $("#erreur").css('display', 'block');
                }
                else{
                    $(this).css({ // si tout est bon, on le rend vert
                        borderColor : 'green',
                        color : 'green'
                    });
                    $("#erreur").css('display', 'none');
                }
            });
        });
    </script>
