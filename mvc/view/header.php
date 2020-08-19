<!-- HEADER MOBILE-->
<?php
if(!isset($_SESSION['connexion']))
{
    echo'<script type="text/javascript">window.location.assign("/connexion");</script>';
}
else
{
    $id = $_SESSION['connexion']['id_connexion'];
    $user = $model->getEmploye($id);

    $nom = $user['Nom'];
    $prenom = $user['Prenom'];
}
?>
<header class="header-mobile d-block d-lg-none">
    <div class="header-mobile__bar">
        <div class="container-fluid">
            <div class="header-mobile-inner">
                <a href="/">
                    <img src="images/icon/logo.png" alt="Doo Jet" />
                </a>
                <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                </button>
            </div>
        </div>
    </div>
    <nav class="navbar-mobile">
        <div class="container-fluid">
            <ul class="navbar-mobile__list list-unstyled">
                <li<?= $nomPage[0] == 'index' ? ' class="active"' : '' ?>>
                    <a href="/">
                        <i class="fas fa-tachometer-alt"></i>Accueil</a>
                </li>
                <li<?= $nomPage[0] == 'client' || $nomPage[0] == 'createclient' || $nomPage[0] == 'infoclient' ? ' class="active"' : '' ?>>
                    <a href="/client">
                        <i class="fas fa-user"></i>Clients</a>
                </li>
                <li<?= $nomPage[0] == 'employe' || $nomPage[0] == 'createemploye' || $nomPage[0] == 'infoemploye' || $nomPage[0] == 'infoinact' ? ' class="active"' : '' ?>>
                    <a href="/employe">
                        <i class="fas fa-user"></i>Employés</a>
                </li>
                <li <?= $nomPage[0] == 'equipement'? ' class="active"' : '' ?>>
                    <a href="/equipement">
                        <i class="fas  fa-anchor"></i>Equipements</a>
                </li>
                <li<?= $nomPage[0] == 'reservation' ? ' class="active"' : '' ?>>
                    <a href="/reservation">
                        <i class="fas fa-calendar-alt"></i>Réservations</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!-- END HEADER MOBILE-->

<!-- MENU SIDEBAR-->
<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="/">
            <img src="images/icon/logo.png" alt="Doo Jet" />
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li <?= $nomPage[0] == 'index' ? ' class="active"' : '' ?>>
                    <a href="/">
                        <i class="fas fa-tachometer-alt"></i>Accueil</a>
                </li>
                <li <?= $nomPage[0] == 'client' || $nomPage[0] == 'createclient' || $nomPage[0] == 'infoclient' ? ' class="active"' : '' ?>>
                    <a href="/client">
                        <i class="fas fa-user"></i>Clients</a>
                </li>
                <li <?= $nomPage[0] == 'employe' || $nomPage[0] == 'createemploye' || $nomPage[0] == 'infoemploye' || $nomPage[0] == 'infoinact' ? ' class="active"' : '' ?>>
                    <a href="/employe">
                        <i class="fas fa-user"></i>Employés</a>
                </li>
                <li <?= $nomPage[0] == 'equipement'|| $nomPage[0] == 'createequipement' || $nomPage[0] == 'infoequipement' ? ' class="active"' : '' ?>>
                    <a href="/equipement">
                        <i class="fas  fa-anchor"></i>Equipements</a>
                </li>
                <li <?= $nomPage[0] == 'reservation' || $nomPage[0] == 'inforeservation' || $nomPage[0] == 'createreservation' || $nomPage[0] == 'createreservation1' || $nomPage[0] == 'createreservation2' || $nomPage[0] == 'createreservation3' || $nomPage[0] == 'createreservation4' ? ' class="active"' : '' ?>>
                    <a href="/reservation">
                        <i class="fas fa-calendar-alt"></i>Réservations</a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<!-- END MENU SIDEBAR-->

<!-- PAGE CONTAINER-->
<div class="page-container">
    <!-- HEADER DESKTOP-->
    <header class="header-desktop">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="header-wrap">
                    <div class="header-button">
                        <div class="account-wrap">
                            <div class="account-item clearfix js-item-menu">
                                <div class="content col-md-12">
                                    <a class="js-acc-btn" href="#"><?php echo $prenom." ".$nom ?></a>
                                </div>
                                <div class="account-dropdown js-dropdown">
                                    <div class="info clearfix">
                                        <div class="content">
                                            <h5 class="name">
                                                <a><?php echo $prenom." ".$nom ?></a>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="account-dropdown__body">
                                        <div class="account-dropdown__item">
                                            <a href="/infoemploye?id=<?php echo $id;?>">
                                                <i class="zmdi zmdi-account"></i>Account</a>
                                        </div>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="/option">
                                            <i class="zmdi zmdi-settings"></i>Setting</a>
                                    </div>
                                    <div class="account-dropdown__footer">
                                        <a href="/deconnexion">
                                            <i class="zmdi zmdi-power"></i>Logout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- END HEADER DESKTOP-->
    <!--
    <script>
        function aff(){
            $("#popup").css({"display":"", "margin":"auto"});
        }
        $(document).ready(function() {
            $("#close").click(function(){
                $("#popup").css({"display":"none"});
            });
        });
    </script>
    -->