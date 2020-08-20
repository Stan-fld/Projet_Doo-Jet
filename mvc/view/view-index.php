<?php
$current_year = date("Y");

$clients = $model->getClientAll();
$resa = $model->getReservationAll("Client");
$countresa = $model->getReservationDistinct($current_year);
$equipements = $model->getEquipementAll();
$service = 1;
?>

<!-- Title Page-->
<title>Accueil</title>

<body class="animsition">
<div class="page-wrapper">
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="col-md-12">
                <div class="overview-wrap">
                    <h2 class="title-1">Vue d'ensemble</h2>
                </div>
            </div>
            <div class="row m-t-25">
                <div class="col-sm-6 col-lg-4">
                    <div class="overview-item overview-item--c1">
                        <div class="overview-box clearfix">
                            <div class="icon">
                                <i class="zmdi zmdi-account-o"></i>
                            </div>
                            <div class="text">
                                <h2><?php echo(count($clients)); ?></h2>
                                <span>Nombre total de clients</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="overview-item overview-item--c2">
                        <div class="overview-box clearfix">
                            <div class="icon">
                                <i class="zmdi  zmdi-boat"></i>
                            </div>
                            <div class="text">
                                <h2><?php echo array_count_values(array_column($equipements, 'Service'))[$service]; ?></h2>
                                <span>Équipements en service</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="overview-item overview-item--c3">
                        <div class="overview-box clearfix">
                            <div class="icon">
                                <i class="zmdi  zmdi-calendar-check"></i>
                            </div>
                            <div class="text">
                                <h2><?php echo(count($countresa)); ?></h2>
                                <span>Réservations courant <?php echo $current_year; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-t-30">
            <div class="col-md-12">
                <div style="margin-bottom: 2vh!important; text-align: center!important;">
                    <h2 class="title-1">Liste des réservations</h2>
                </div>
                <input class ="au-input" id="myInput" style="padding: 0px 16px;  border-radius: 10px; margin-bottom: 1vh; margin-left: 1vh" type="text" placeholder="Rechercher..">
                <button style="margin-left: 2vh" onclick="createR()" class="btn btn-outline-success">
                    <i class="fa fa-edit (alias)"></i> Nouvelle réservation
                </button>
                <!-- DATA TABLE-->
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data3 text-center">
                        <thead>
                        <tr class="text-center">
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Téléhpone</th>
                            <th>Jour de la réservation</th>
                            <th>Heure de début</th>
                            <th></th>
                            <th>Heure de fin</th>
                            <th>Détails réservation</th>
                            <th class="text-center">Détails client</th>
                        </tr>
                        </thead>
                        <tbody id="TableClient">
                        <?php foreach ($resa as $Resa){ ?>
                            <tr>
                                <td><?php echo $Resa['Nom'];?></td>
                                <td><?php echo $Resa['Prenom'];?></td>
                                <td><?php echo $Resa['Telephone'];?></td>
                                <td><?php echo  substr($Resa['debut'], 0, 10);?></td>
                                <td><?php echo  substr($Resa['debut'], 10, 6);?></td>
                                <td> à </td>
                                <td><?php echo  substr($Resa['fin'], 10, 6);?></td>
                                <td>
                                    <a href="/inforeservation?id=<?php echo $Resa['ID_Reservation'];?>" class="btn btn-info">Détails réservation</a>
                                </td>
                                <td>
                                    <a href="/infoclient?id=<?php echo $Resa['ID_Personne'];?>" class="btn btn-info">Détails client</a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- END DATA TABLE-->
            </div>
        </div>
    </div>
</div>
</body>
<script>
    $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#TableClient tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    function createR(){
        window.location.assign("/createreservation")
    }
</script>