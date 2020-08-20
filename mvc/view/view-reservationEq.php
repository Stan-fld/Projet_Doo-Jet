<?php
$resaC = $model->getReservationAll("Client");

$resaE = $model->getReservationEmp();

$resaEq = $model->getReservationEq();
?>

<!-- Title Page-->
<title>Liste des réservations</title>

<body class="animsition">
<div class="page-wrapper">
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="row m-t-30">
            <div class="col-md-12">
                <div style="margin-bottom: 2vh!important; text-align: center!important;">
                    <h2 class="title-1">Liste des réservations équipements</h2>
                </div>
                <input class ="au-input" id="myInputEq" style="padding: 0px 16px;  border-radius: 10px; margin-bottom: 1vh; margin-left: 1vh" type="text" placeholder="Rechercher..">
                <button style="margin-left: 2vh" onclick="createR()" class="btn btn-outline-success">
                    <i class="fa fa-edit (alias)"></i> Nouvelle réservation
                </button>
                <!-- DATA TABLE-->
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data3 text-center">
                        <thead>
                        <tr class="text-center">
                            <th>Numéro réservation</th>
                            <th>Numéro équipement</th>
                            <th>Nom équipement</th>
                            <th>Commentaire</th>
                            <th>Jour de la réservation</th>
                            <th>Heure de début</th>
                            <th></th>
                            <th>Heure de fin</th>
                            <th>Détails réservation</th>
                            <th class="text-center">Détails employé</th>
                        </tr>
                        </thead>
                        <tbody id="TableResaEq">
                        <?php foreach ($resaEq as $ResaEq){ ?>
                            <tr>
                                <td><?php echo $ResaEq['ID_Reservation'];?></td>
                                <td><?php echo $ResaEq['ID_Equipement'];?></td>
                                <td><?php echo $ResaEq['Nom_Equipement'];?></td>
                                <td><?php echo $ResaEq['Commentaire'];?></td>
                                <td><?php echo  substr($ResaEq['debut'], 0, 10);?></td>
                                <td><?php echo  substr($ResaEq['debut'], 10, 6);?></td>
                                <td> à </td>
                                <td><?php echo  substr($ResaEq['fin'], 10, 6);?></td>
                                <td>
                                    <a href="/inforeservation?id=<?php echo $ResaEq['ID_Reservation'];?>" class="btn btn-info">Détails réservation</a>
                                </td>
                                <td>
                                    <a href="/infoequipement?id=<?php echo $ResaEq['ID_Equipement'];?>" class="btn btn-info">Détails équipement</a>
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
    $(document).ready(function() {
        $("#myInputEq").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#TableResaEq tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    function createR(){
        window.location.assign("/createreservation")
    }
</script>