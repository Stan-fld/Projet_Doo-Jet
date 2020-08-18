<?php
//session_destroy();
$count = false;

//On récupère les infos de l'employé à partir de son id
$idreservation = $_GET["id"];
$resC = $model->getReservationClient($idreservation);
$reservation = $model->getReservation($idreservation);

//On récupère tous les pays
$pays = $model->getPays();


// On récupére les équipement en service
$equipement = $model->getEquipementAll();

?>
<!-- Title Page-->
<title>Réservation de <?php echo $resC['Prenom']." ".$resC['Nom']." : ".$resC['date'] ?></title>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Réservation de <?php echo $resC['Prenom']." ".$resC['Nom'] ?> : </strong><?php  echo $resC['date'] ?>
                            <button style="margin-left: 2vh" onclick="backp()" class="btn btn-outline-danger btn-sm">
                                <i class="fa fa-caret-square-o-left"></i> Retour
                            </button>
                        </div>
                        <form action="" method="post" class="form-horizontal ajax">
                            <input type="hidden" name="controller" value="updateRes">
                            <input type="hidden" id="etape" name="etape" value="">
                            <input type="hidden" name="id_personne" value="<?php echo $resC['ID_Personne']; ?>">
                            <input type="hidden" name="id_resa" value="<?php echo $idreservation; ?>">
                            <div class="card-body card-block">
                                <div class="row form-group">
                                    <label class="col col-md-3" for="date">Date : </label>
                                    <div class="col col-md-3">
                                        <input name="date" id="date" class="text-center form-control enable"  type="text" disabled required value="<?php echo $resC['date']?>">
                                    </div>
                                </div>
                            </div>
                            <hr style="border-top: 2px dashed;">
                            <?php foreach($reservation as $resa){
                                $employe = $model->getEmployeAll();?>
                                <input type="hidden" name="equipement_<?php echo $resa['Nom_Equipement']; ?>" value="<?php echo $resa['ID_Equipement']; ?>">
                                <input type="hidden" name="eq_<?php echo $resa['Nom_Equipement']; ?>" value="<?php echo $resa['Nom_Equipement']; ?>">
                                <input type="hidden" name="debut_init_<?php echo $resa['Nom_Equipement']; ?>" value="<?php echo $resa['debut'];?>">
                                <input type="hidden" name="fin_init_<?php echo $resa['Nom_Equipement']; ?>" value="<?php echo $resa['fin'];?>">
                                <input type="hidden" name="old_id_emp_<?php echo $resa['Nom_Equipement']; ?>" value="<?php echo $resa['id_employe'];?>">
                                <div class="card-body card-block">
                                    <div class="row form-group">
                                        <label class="col col-md-3 form-control-label" for="pays">Moniteur sélectionné : </label>
                                        <div class="col col-md-3">
                                            <select name="id_employe<?php echo $resa['Nom_Equipement']; ?>" id="id_employe" class="text-center form-control enable" <?= ($resC['N_Permis'] !== NULL && $resa['Nom_Equipement'] !== "JETSKI") ||($resC['N_Permis'] == NULL) ? 'required' : '' ?> disabled>
                                                <?php if ($resa['id_employe'] == NULL){ ?>
                                                    <option selected value="">Pas de moniteur requis</option>
                                                <?php }else{ ?>
                                                <option value="">Moniteur requis</option>
                                                <?php } ?>
                                                <?php if($resa['Nom_Equipement'] == "JETSKI"){ ?>
                                                    <?php foreach($employe as $employes){
                                                        if($employes['N_BEES'] !== NULL){ ?>
                                                            <?php if($employes['ID_Personne'] == $resa['id_employe']) { ?>
                                                                <option selected value="<?php echo $employes['ID_Personne']; ?>"><?php echo $employes['Nom']." ".$employes['Prenom']; ?></option>
                                                            <?php }else{ ?>
                                                                <option value="<?php echo $employes['ID_Personne']; ?>"><?php echo $employes['Nom']." ".$employes['Prenom']; ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php }else if($resa['Nom_Equipement'] == "BATEAU" ||$resa['Nom_Equipement'] == "BOUEE"){ ?>
                                                    <?php foreach($employe as $employes){
                                                        if($employes['N_Permis'] !== NULL){ ?>
                                                            <?php if($employes['ID_Personne'] == $resa['id_employe']) { ?>
                                                                <option selected value="<?php echo $employes['ID_Personne'];?>"><?php echo $employes['Nom']." ".$employes['Prenom']; ?></option>
                                                            <?php }else{ ?>
                                                                <option value="<?php echo $employes['ID_Personne'];?>"><?php echo $employes['Nom']." ".$employes['Prenom']; ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php }else if($resa['Nom_Equipement'] == "WAKE-BOARD" ||$resa['Nom_Equipement'] == "SKI-NAUTIQUE"){ ?>
                                                    <?php foreach($employe as $employes){
                                                        if($employes['N_Permis'] !== NULL && $employes['N_BEES'] !== NULL){ ?>
                                                            <?php if($employes['ID_Personne'] == $resa['id_employe']) { ?>
                                                                <option selected value="<?php echo $employes['ID_Personne']; ?>"><?php echo $employes['Nom']." ".$employes['Prenom']; ?></option>
                                                            <?php }else{ ?>
                                                                <option value="<?php echo $employes['ID_Personne']; ?>"><?php echo $employes['Nom']." ".$employes['Prenom']; ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php foreach ($equipement as $eq){
                                        if($eq['Service'] == 1 &&$eq['Commentaire'] == $resa['Commentaire'])
                                        {
                                            $count = true;
                                        } ?>
                                    <?php }
                                    if($count == false){ ?>
                                        <div class="row form-group">
                                            <label class="col col-md-3 form-control-label"></label>
                                            <div class="col col-md-3 text-center">
                                                <strong style="font-size: large; color: #ff0000">Équipement hors service</strong>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="row form-group">
                                        <?php if($resa['Nom_Equipement'] == "JETSKI"){ ?>
                                            <label class="col col-md-3" for="equipement">Équipement : <strong><?php echo  $resa['Nom_Equipement'] ?></strong></label>
                                        <?php }else{ ?>
                                            <label class="col col-md-3" for="equipement">Équipement : </label>
                                        <?php } ?>

                                        <div class="col col-md-3">
                                            <?php if($resa['Nom_Equipement'] == "JETSKI"){ ?>
                                                <input name="equipement>" id="equipement" class="text-center form-control"  type="text" disabled required value="<?php echo  $resa['Commentaire']." ".$resa['Puissance']." cv"; ?>">
                                            <?php }else{ ?>
                                                <input name="equipement" id="equipement" class="text-center form-control"  type="text" disabled required value="<?php echo $resa['Commentaire']; ?>">
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col col-md-3" for="debut">Heure de début : </label>
                                        <div class="col col-md-3">
                                            <input name="debut_<?php echo $resa['Nom_Equipement'] ?>" id="debut" class="text-center form-control enable time_deb"  type="text" disabled required value="<?php echo $resa['debut']; ?>">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col col-md-3" for="fin">Heure de fin : </label>
                                        <div class="col col-md-3">
                                            <input name="fin_<?php echo $resa['Nom_Equipement'] ?>" id="fin" class="text-center form-control enable time_fin"  type="text" disabled required value="<?php echo $resa['fin']; ?>">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col col-md-3" for="nb_pers">Nombre de personnes : </label>
                                        <div class="col col-md-3">
                                            <input name="nb_pers_<?php echo $resa['Nom_Equipement'] ?>" id="nb_pers" class="text-center form-control enable"  type="text" disabled required value="<?php echo $resa['Nombre_Personne']; ?>">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col col-md-3" for="prix_pers">Prix par personne : (&euro;)</label>
                                        <div class="col col-md-3">
                                            <input name="prix_pers" id="prix_pers" class="text-center form-control"  type="text" disabled required value="<?php echo ($resa['Prix_Total']/$resa['Nombre_Personne']); ?>">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col col-md-3" for="total">Total : (&euro;)</label>
                                        <div class="col col-md-3">
                                            <input name="total_<?php echo $resa['Nom_Equipement']; ?>" id="total" class="text-center form-control enable"  type="text" disabled required value="<?php echo $resa['Prix_Total']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <hr>
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
                        <div style="margin-top: 2vh; margin-bottom: 2vh"  class="text-right">
                            <button id="modif" style="margin-left: 2vh" onclick="modif()" class="btn btn-warning btn-sm">
                                <i class="fa fa-cog"></i> Modifier
                            </button>
                            <button id="supp" style="margin-left: 2vh; margin-right: 2vh" onclick="supp()" class="btn btn-danger btn-sm">
                                <i class="fa fa-cog"></i> Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    ?>
    <script>
        function modif() {
            $(".enable").prop('disabled', false);
            $(".enable").prop('disabled', false);
            $("#hidebtnAnnuler").css("display", "");
            $("#hidebtnValider").css("display", "");
            $('#etape').val('update');
        }

        function supp() {
            $("#hidebtnAnnuler").css("display", "");
            $("#hidebtnValider").css("display", "");
            $('#etape').val('delete');
            $("#modif").css("display", "none");
        }

        function backp(){
            history.back();
        }

        function reload() {
            window.location.reload();
        }

        $( function() {
            $( "#date" ).datepicker({
                dateFormat: "dd/mm/yy", //affichage de la date au format français jj-mm-yyyy
                showAnim: "blind",
                dayNames: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
                dayNamesMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
                dayNamesShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
                firstDay: 1,
                monthNames: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
            });
            $(".time_deb").timepicker({
                timeOnlyTitle: 'Choisir l\'heure de début',
            });
            $(".time_fin").timepicker({
                timeOnlyTitle: 'Choisir l\'heure de fin',});
        });

        let forbidden_value = [];
        $(document).on('focus', 'select', function(){
            $(this).data('val', this.value);
        }).on('change','select', function(){
            var prev = $(this).data('val');
            var current = $(this).val();
            if ($.inArray(prev, forbidden_value) !== -1){
                forbidden_value = $.grep(forbidden_value, function(value) {
                    return value != prev;
                });
            }
            forbidden_value.push(current);
            $(this).attr('valu', current)
            $('select').not(this).children().each(function(){
                let otherval = $(this).attr('value');
                if ($.inArray(otherval, forbidden_value) !== -1 && $(this).parent().attr('valu') !== otherval ){
                    $(this).prop('disabled', true);
                }else{
                    $(this).prop('disabled', false);
                }
            })
            $(this).blur();
        });
    </script>
