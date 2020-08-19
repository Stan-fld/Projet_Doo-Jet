<?php
if(!isset($_SESSION['connexion'])) {

//On récupère tous les pays
    $pays = $model->getPays();
    ?>
    <!-- Title Page-->
    <title>Inscription : </title>
    <body class="animsition">
    <div class="page-wrapper">
        <div class="container">
            <div class="login-wrap">
                <div class="login-content">
                    <div class="login-logo">
                        <a href="#">
                            <img style="height: 20vh" src="/images/icon/logo-mini.png" alt="CoolAdmin">
                        </a>
                    </div>
                    <div class="login-form">
                        <form action="" method="post" class="form-horizontal ajax">
                            <input  type="hidden" name="controller" value="updatePersonne">
                            <input  type="hidden" id="etape" name="etape" value="create_employe">
                            <div class="form-group">
                                <label for="nom">Nom : </label>
                                <input required id="nom" class="au-input au-input--full" type="text" name="nom" placeholder="Nom">
                            </div>
                            <div class="form-group">
                                <label for="prenom">Prénom</label>
                                <input required class="au-input au-input--full" type="text" id="prenom" name="prenom" placeholder="Prénom">
                            </div>
                            <div class="form-group">
                                <label for="date_naissance">Date de naissance</label>
                                <input required class="au-input au-input--full" type="text" name="date_naissance" id="date_naissance" placeholder="Date de naissance">
                            </div>
                            <div class="form-group">
                                <label for="telephone">Téléphone : (identifiant)</label>
                                <input required class="au-input au-input--full" type="text" name="telephone" id="telephone" placeholder="Téléphone : (identifiant)">
                            </div>
                            <div class="form-group">
                                <label for="password">Mot de passe : </label>
                                <input required class="au-input au-input--full" type="password" name="password" id="password" placeholder="Mot de passe :">
                            </div>
                            <div id="erreur" style="color: red; display: none">
                                <p>Mot de passe trop court !</p>
                            </div>
                            <hr style="border-top: 2px dashed;">
                            <div class="form-group">
                                <label for="num_permis">Numéro de permis: </label>
                                <input class="au-input au-input--full" type="text" name="num_permis" id="num_permis" placeholder="Numéro de permis : ">
                            </div>
                            <div class="form-group">
                                <label for="num_secu">Numéro de sécurité sociale : </label>
                                <input required class="au-input au-input--full" type="text" name="num_secu" id="num_secu" placeholder="Numéro de sécurité sociale : ">
                            </div>
                            <div class="form-group">
                                <label for="num_bees">Numéro BEES : </label>
                                <input class="au-input au-input--full" type="text" name="num_bees" id="num_bees" placeholder="Numéro BEES : ">
                            </div>
                            <div class="form-group">
                                <label for="contrat">Contrat : </label>
                                <input required class="au-input au-input--full" type="text" name="contrat" id="contrat" placeholder="Contrat : ">
                            </div>
                            <div class="form-group">
                                <label for="date_embauche">Date d'embauche : </label>
                                <input required class="au-input au-input--full" type="text" name="date_embauche" id="date_embauche" placeholder="Date d'embauche : ">
                            </div>
                            <div class="form-group">
                                <label for="date_visite_med">Date dernière visite médicale : </label>
                                <input required class="au-input au-input--full" type="text" name="date_visite_med" id="date_visite_med" placeholder="Date dernière visite médicale : ">
                            </div>
                            <hr style="border-top: 2px dashed;">
                            <div class="form-group">
                                <label for="nom_pays">Pays : </label>
                                <select name="nom_pays" id="nom_pays" class="au-input au-input--full pays" required >
                                    <?php foreach($pays as $Pays){ ?>
                                        <?php if($Pays['Nom_Pays'] == 'France'){?>
                                            <option selected value="<?php echo $Pays['Nom_Pays'];?>"><?php echo $Pays['Nom_Pays'];?></option>
                                        <?php }else{?>
                                            <option value="<?php echo $Pays['Nom_Pays'];?>"><?php echo $Pays['Nom_Pays'];?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="num_voie">Numéro de voie: </label>
                                <input required class="au-input au-input--full" type="text" name="num_voie" id="num_voie" placeholder="Numéro de voie: ">
                            </div>
                            <div class="form-group">
                                <label for="type_voie">Type de voie: </label>
                                <input required class="au-input au-input--full" type="text" name="type_voie" id="type_voie" placeholder="Type de voie: ">
                            </div>
                            <div class="form-group">
                                <label for="nom_voie">Nom de voie: </label>
                                <input required class="au-input au-input--full" type="text" name="nom_voie" id="nom_voie" placeholder="Nom de voie: ">
                            </div>
                            <div class="form-group">
                                <label for="ville">Ville : </label>
                                <input required class="au-input au-input--full" type="text" name="ville" id="ville" placeholder="Ville : ">
                            </div>
                            <div class="form-group">
                                <label for="code_postal">Code postal : </label>
                                <input required class="au-input au-input--full" type="text" name="code_postal" id="code_postal" placeholder="Code postal : ">
                            </div>
                            <button class="au-btn au-btn--block au-btn--green m-b-20">Inscription</button>
                        </form>
                        <div class="register-link">
                            <p>
                                Vous avez un compte ?
                                <a href="connexion">Se connecter</a>
                            </p>
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
            window.location.assign("/connexion")
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
    </body>
<?php } else{ echo '<script type="text/javascript">window.location.assign("/");</script>';} ?>