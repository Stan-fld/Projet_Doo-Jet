<?php
if(!isset($_SESSION['connexion']))
{
    echo'<script type="text/javascript">window.location.assign("/connexion");</script>';
}
else{?>
    <!-- Title Page-->
    <title>Changer de mot de passe : </title>
    <div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Changer de mot de passe : </strong>
                            <button style="margin-left: 2vh" onclick="backp()" class="btn btn-outline-danger btn-sm">
                                <i class="fa fa-caret-square-o-left"></i> Retour
                            </button>
                        </div>
                        <div class="card-body card-block">
                            <form action="" method="post" class="form-horizontal ajax">
                                <input type="hidden" name="controller" value="connexion">
                                <input type="hidden" id="etape" name="etape" value="updatepassword">
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="old_password">Ancien mot de passe : </label>
                                    <div class="col col-md-3">
                                        <input name="old_password" id="old_password" class="text-center form-control" type="password" required  value="">
                                    </div>
                                </div>
                                <hr>
                                <div class="row form-group">
                                    <label class="col col-md-3 form-control-label" for="new_password">Nouveau mot de passe : </label>
                                    <div class="col col-md-3">
                                        <input name="new_password" id="new_password" class="text-center form-control" type="password" required  value="">
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button id="modif" class="btn btn-success btn-sm">
                                        <i class="fa fa-check"></i> Valider le changement
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

        function reload() {
            window.location.reload();
        }
    </script>

<?php } ?>