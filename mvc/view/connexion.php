<?php if(!isset($_SESSION['connexion'])) { ?>
<div class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content" style="border-radius: 16px">
                        <div class="login-logo">
                            <img style="height: 20vh" src="/images/icon/logo-mini.png" alt="CoolAdmin">
                        </div>
                        <div class="login-form">
                            <form action="" method="post" class="ajax">
                                <input type="hidden" name="controller" value="connexion">
                                <input type="hidden" name="etape" value="login">
                                <div class="form-group">
                                    <label>Nom d'utilisateur</label>
                                    <input style="border-radius: 16px" class="au-input au-input--full" type="text" name="identifiant" placeholder="Nom d'utilisateur" required>
                                </div>
                                <div class="form-group">
                                    <label>Mot de passe</label>
                                    <input style="border-radius: 16px" class="au-input au-input--full" type="text" name="password" placeholder="Mot de passe" required>
                                </div>
                                <button style="border-radius: 16px" class="au-btn au-btn--block au-btn--green m-b-20">Se connecter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } else{ echo '<script type="text/javascript">window.location.assign("/");</script>';} ?>